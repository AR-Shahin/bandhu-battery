<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Sell;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function index(Request $request) {
        if($request->ajax()){
            $query = Sell::query()->with(["customer","admin"])->latest();
            return $this->table($query)
                ->addIndexColumn()
                ->addColumn("name",fn($row) => "$row->bn_name - $row->en_name")
                ->addColumn("actions",function($row) {
                    $deleteRoute = route('admin.brands.destroy', $row["id"]);
                    $editRoute = route('admin.brands.update', $row["id"]);
                    $html = '';
                    $html .= '<a class="btn btn-sm btn-success mr-1" href="'. route("admin.orders.view",$row->id).'"><i class="fa fa-eye"></i></a>';
                    return $html;
                })

                ->rawColumns(["actions","status","name"])
                ->make(true);
        }
        return view("admin.order.index");
    }

    function create() {
        return view("admin.order.create",[
            "products" => Product::latest()->get(),
            "customers" => Customer::latest()->get()
        ]);
    }

    public $sell;
    function store(Request $request)  {
        $request->validate([
            "customer_id" => ["required"],
        ]);

        try{
            $oldSell = Sell::latest()->first("id");
            DB::transaction(function() use ($request,$oldSell) {
                $inv = $oldSell ? $oldSell->id + 1 : 1;
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
                    $total += $request->quantites[$index] ?? 0;
                    $product = Product::find($value);
                    $product->update_stock($request->quantites[$index] ?? 0,ProductStock::REMOVE,"Order Placed to customer $customer->phone");
                    $product->decrement("stock",$request->quantites[$index] ?? 0);
                    $sell->details()->create([
                        "product_id" => $value,
                        "quantity" => $request->quantites[$index] ?? 0
                    ]);
                }
                $sell->update(["quantity" => $total]);
            });

            return redirect()->route("admin.orders.view",$this->sell->id);
        }catch(Exception $e){
            $this->logError($e->getMessage());
            dd($e->getMessage());
        }
    }

    function view(Sell $sell) {
        return $sell->load("details");
    }
}
