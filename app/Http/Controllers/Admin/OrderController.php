<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Sell;
use App\Models\SellDetails;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class OrderController extends Controller
{
    function index(Request $request) {
        if($request->ajax()){
            $query = Sell::query()->with(["customer","admin"])->latest();
            return $this->table($query)
                ->addIndexColumn()
                ->addColumn("name",fn($row) => "$row->bn_name - $row->en_name")
                ->addColumn("created_at",fn($row) => $row->created_at->format('d-M-Y H:i:s'))
                ->addColumn("actions",function($row) {
                    $deleteRoute = route('admin.brands.destroy', $row["id"]);
                    $editRoute = route('admin.brands.update', $row["id"]);
                    $html = '';
                    $html .= '<a class="btn btn-sm btn-info mr-1" href="'. route("admin.orders.edit",$row->id).'"><i class="fa fa-edit"></i></a>';
                    $html .= '<a class="btn btn-sm btn-success mr-1" href="'. route("admin.orders.view",$row->id).'"><i class="fa fa-eye"></i></a>';
                    return $html;
                })

                ->rawColumns(["actions","status","name","created_at"])
                ->make(true);
        }
        return view("admin.order.index",[
            "customers" => Customer::get(["name","id","phone"])
        ]);
    }

    function create() {
        return view("admin.order.create",[
            "products" => Product::latest()->get(["id","name","stock"]),
            "customers" => Customer::latest()->get(["name","id"])
        ]);
    }

    public $sell;

    private function getInvoiceID($oldSell){
        if ($oldSell && !empty($oldSell->invoice_id)) {
            $invParts = explode("_", $oldSell->invoice_id);
            if (!empty($invParts)) {
               return end($invParts) + 1;
            }
        }
        return 1;
    }
    function store(Request $request)  {
        $request->validate([
            "customer_id" => ["required"],
        ]);


        try{
            $oldSell = Sell::latest()->first("invoice_id",);

            DB::transaction(function() use ($request,$oldSell) {
                $inv = $this->getInvoiceID($oldSell);
                $customer = Customer::find($request->customer_id);

                $sell = Sell::create([
                    "customer_id" => $request->customer_id,
                    "remarks" => $request->remark ?? null,
                    "invoice_id" => "INV_$inv",
                    "quantity" => 0,
                    "admin_id" => auth()->id()
                ]);
                $this->sell = $sell;
                $total = 0;
                foreach($request->products as $index => $value){
                    $total += $request->quantites[$index] ?? 1;
                    $product = Product::find($value);
                    $product->update_stock($request->quantites[$index] ?? 1,ProductStock::REMOVE,"Order Placed to customer $customer->phone");
                    $product->decrement("stock",$request->quantites[$index] ?? 1);
                    $sell->details()->create([
                        "product_id" => $value,
                        "quantity" => $request->quantites[$index] ?? 1
                    ]);
                }
                $sell->update(["quantity" => $total]);
            });
            $this->successAlert("অর্ডার সফলভাবে করা হয়েছে");
            return redirect()->route("admin.orders.view",$this->sell->id);
        }catch(Exception $e){
            $this->logError($e->getMessage());
            dd($e->getMessage());
        }
    }

    function view(Sell $sell) {
        $sell->load(["details.product:id,name","customer"]);
        return view("admin.order.view",[
            "sell" => $sell
        ]);
    }

    function edit(Sell $sell) {
        $productIds = $sell->details->pluck("product_id");
        return view("admin.order.edit",[
            "products" => Product::latest()->whereNotIn("id",$productIds)->get(["id","name","stock"]),
            "customers" => Customer::latest()->get(["name","id"]),
            "sell" => $sell->load(["details.product:id,name"])
        ]);

    }

    function update(Request $request, Sell $sell)  {
        try{
            DB::transaction(function() use ($request,$sell) {
                $customer = Customer::find($request->customer_id);
                 $sell->update([
                    "customer_id" => $request->customer_id,
                    "remarks" => $request->remark ?? null,
                    "admin_id" => auth()->id()
                ]);
                $this->sell = $sell ;
                $total = $this->sell->quantity;

              // dd($request->products, !is_null($request->products[0]));
                if(count($request->products) > 0 && !is_null($request->products[0])){
                    foreach($request->products as $index => $value){
                        $total += $request->quantites[$index] ?? 1;
                        $product = Product::find($value);
                        $product->update_stock($request->quantites[$index] ?? 1,ProductStock::REMOVE,"গ্রাহক {$customer->phone} এর ইনভয়েসে পণ্য যোগ করা হয়েছে।");
                        $product->decrement("stock",$request->quantites[$index] ?? 1);
                        $sell->details()->create([
                            "product_id" => $value,
                            "quantity" => $request->quantites[$index] ?? 1
                        ]);
                    }
                    $sell->update(["quantity" => $total]);
                }
            });
            $this->successAlert("অর্ডার সফলভাবে আপডেট করা হয়েছে");
            return back();
        }catch(Exception $e){
            $this->logError($e->getMessage());
            dd($e->getMessage());
        }
    }

    function deleteQuantity(SellDetails $sell) {
        try{
            DB::transaction(function() use($sell){
                $product = Product::find($sell->product_id);
                $customer = Customer::find($sell->order->customer_id);
                $product->update_stock($sell->quantity,ProductStock::ADD,"গ্রাহক {$customer?->phone} ইনভয়েস থেকে পণ্য বাতিল করা হয়েছে।");
                $product->increment("stock",$sell->quantity);
                $sell->order->decrement("quantity",$sell->quantity);
                $sell->delete();
            });
            $this->successAlert("অর্ডার সফলভাবে আপডেট করা হয়েছে");
            return back();
        }catch(Exception $e){
            $this->logError($e->getMessage());
            dd($e->getMessage());
        }
    }
    public function updateQuantity(Request $request, SellDetails $sell)
    {
        try {
            DB::transaction(function() use ($sell, $request) {
                $currentQuantity = $request->quantity;
                $product = Product::find($sell->product_id);
                $customer = Customer::find($sell->order->customer_id);

                if ($currentQuantity == $sell->quantity) {
                    return;
                }

                $quantityDifference = $currentQuantity - $sell->quantity;
                $isIncreasing = $quantityDifference > 0;

                if ($isIncreasing) {
                    // Update stock for increased quantity
                    $product->update_stock($quantityDifference, ProductStock::REMOVE, "গ্রাহক {$customer->phone} ইনভয়েস এড করা হয়েছে।");
                    $product->decrement("stock", $quantityDifference);
                    $sell->order->increment("quantity", $quantityDifference);
                } else {
                    // Update stock for decreased quantity
                    $product->update_stock(-$quantityDifference, ProductStock::ADD, "গ্রাহক {$customer->phone} ইনভয়েস থেকে সরানো হয়েছে।");
                    $product->increment("stock", -$quantityDifference);
                    $sell->order->decrement("quantity", -$quantityDifference);
                }

                // Update sell quantity
                $sell->update(["quantity" => $currentQuantity]);
            });

            $this->successAlert("অর্ডার সফলভাবে আপডেট করা হয়েছে");
            return back();
        } catch (Exception $e) {
            $this->logError($e->getMessage());
            dd($e->getMessage());
        }
    }


}
