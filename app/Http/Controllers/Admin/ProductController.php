<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Vendor;
use App\Repositories\BaseCRUDRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use App\QueryFilters\{ CommonFilter};
use Illuminate\Pipeline\Pipeline;
class ProductController extends Controller
{
    private $repository;
    private $table = "products";

    function __construct()
    {
        parent::__construct();
        $this->repository = new BaseCRUDRepository(new Product());
    }

    function index(Request $request, Category $category)  {

        if($request->ajax()){
            $query = $this->repository->query(["category","brand","unit","vendor"]);
            $query = app(Pipeline::class)
                ->send($query)
                ->through([
                    new CommonFilter("brand_id","brand"),
                    new CommonFilter("unit_id","unit"),
                    new CommonFilter("vendor_id","vendor"),
                ])->thenReturn();
            return $this->table($query)
                ->addIndexColumn()
                ->addColumn("stock",function($row){
                    if($row->stock < 10){
                        return "<span class='badge bg-danger'>{$row->stock}</span>";
                    }
                    return "<span class='badge bg-success'>{$row->stock}</span>";
                })
                ->addColumn("actions",function($row){
                    $deleteRoute = route('admin.products.destroy', $row["id"]);
                    $editRoute = route('admin.products.update', $row["id"]);

                    $html = "";
                    $html .= '<a class="btn btn-sm btn-success mr-1" href="'. route("admin.products.stock",$row->id).'">স্টক হিসাব</a>';
                    $html .= '<a class="btn btn-sm btn-info mr-1" href="'. route("admin.products.edit",$row->id).'"> <i class="fa fa-edit"></i></a>';
                    return $html;
                })

                ->addColumn("status", fn($row) => $row->status_badge)

                ->rawColumns(["actions","status","stock"])
                ->make(true);
        }
        return view("admin.product.index",[
            "brands" => Brand::latest()->get(),
            "units" => Unit::latest()->get(),
            "vendors" => Vendor::latest()->get(["id","name"]),
        ]);
    }

    function destroy($product) {
        if(!$product->sells()->exists()){
            if($this->repository->delete($product)){
                $this->deletedAlert();
                return back();
            }
        }

    }

    function create() {
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        $units = Unit::latest()->get();
        $brands = Brand::latest()->get();
        $vendors = Vendor::latest()->get();
        return view("admin.product.create",compact("categories","brands","units","vendors"));
    }
    function store(Request $request) {
        $request->validate([
            "category_id" => ["required"],
            "brand_id" => ["required"],
            "unit_id" => ["required"],
            "name" => ["required","unique:products,name"],
            "stock" => ["nullable"],
            "code" => ["nullable", "sometimes", "unique:products,code"]
        ]);
        try{
            DB::transaction(function () use($request){
                $product = $this->repository->store([
                    "category_id" => $request->category_id,
                    "brand_id" => $request->brand_id,
                    "unit_id" => $request->unit_id,
                    "name" => $request->name,
                    "stock" => $request->stock ?? 0,
                    "price" => $request->price ?? 0,
                    "vendor_id" => $request->vendor_id,
                    "admin_id" => auth()->id(),
                    "code" => "-",
                    "description" => $request->des ?? "-"
                ]);
                if($product)
                {
                    $product->update([
                        "code" => $request->code
                    ]);
                    $product->update_stock(
                        $request->stock ?? 0,
                        ProductStock::ADD,
                        "When Product added!"
                    );
                }
            });

            $this->createdAlert();
            return back();
        }catch(Exception $e){
            $this->logError($e->getMessage());
            dd($e->getMessage());
        }
    }

    function stock(Request $request,Product $product) {

        if($request->ajax()){
            $query = ProductStock::query()->with("admin")->whereProductId($product->id)->latest();
            return $this->table($query)
                ->addIndexColumn()
                ->addColumn("created_at",fn($row) => $row->created_at->format("Y-M-d h:i:s"))

                ->addColumn("flag", fn($row) => $row->flag_badge)

                ->rawColumns(["flag","created_at"])
                ->make(true);
        }
        return view("admin.product.stock",compact("product"));
    }

    function stock_adjust(Request $request,Product $product) {
        $request->validate([
            "stock" => ["required"],
            "flag" => ["required"]
        ]);
        if($request->flag == "remove" && $product->stock < $request->stock){
            $this->warningAlert("Stock is limited");
            return back();
        }
        try{
            DB::transaction(function() use($request,$product){
                if($request->flag == "add"){
                    $product->increment("stock",$request->stock);
                    $product->update_stock($request->stock,ProductStock::ADD,$request->remarks ?? "");
                }
                if($request->flag == "remove"){
                    $product->decrement("stock",$request->stock);
                    $product->update_stock($request->stock,ProductStock::REMOVE,$request->remarks ?? "");
                }
            });
            $this->successAlert("Stock Updated");
            return back();
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }

    function edit(Product $product)  {
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        $units = Unit::latest()->get();
        $brands = Brand::latest()->get();
        $vendors = Vendor::latest()->get();
        return view("admin.product.edit",compact("product",
        "categories","brands","units","vendors"));
    }
    function update(Request $request,$id) {
        if(
            $this->repository->update($id,[
                "category_id" => $request->category_id,
                "brand_id" => $request->brand_id,
                "unit_id" => $request->unit_id,
                "name" => $request->name,
                "vendor_id" => $request->vendor_id,
                "code" => $request->code,
                "price" => $request->price,
                "admin_id" => auth()->id(),
                "description" => $request->des ?? "-",
                "status" => $request->status,
            ])
        ){
            $this->updatedAlert();
            return back();
        }
    }

    protected function generateCategoryEditButton($row, $route, $categories)
    {
        $html = '<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#rowId_' . $row['id'] . '">
            <i class="fa fa-edit"></i>
        </button>
        <div class="modal fade" id="rowId_' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="rowId_' . $row['id'] . 'Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="' . $route . '" method="post">
                    <div class="modal-content text-left">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rowId_' . $row['id'] . 'Label">Edit ' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group">
                                <label for="en_name_' . $row['id'] . '"><b>En Name</b></label>
                                <input type="text" class="form-control" id="en_name_' . $row['id'] . '" name="en_name" value="' . htmlspecialchars($row['en_name'], ENT_QUOTES, 'UTF-8') . '">
                            </div>
                            <div class="form-group">
                                <label for="bn_name_' . $row['id'] . '"><b>Bn Name</b></label>
                                <input type="text" class="form-control" id="bn_name_' . $row['id'] . '" name="bn_name" value="' . htmlspecialchars($row['bn_name'], ENT_QUOTES, 'UTF-8') . '">
                            </div>
                            <div class="form-group">
                                <label for="parent_id_' . $row['id'] . '"><b>Parent Category</b></label>
                                <select name="parent_id" id="parent_id_' . $row['id'] . '" class="form-control">
                                    <option value="">Select Parent</option>';
                                    foreach ($categories as $category) {
                                        $selected = ($row['parent_id'] == $category->id) ? 'selected' : '';
                                        $html .= '<option value="' . $category->id . '" ' . $selected . '>' . htmlspecialchars($category->bn_name, ENT_QUOTES, 'UTF-8') . '</option>';
                                    }
        $html .=        '</select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>';

        return $html;
    }

    function stock_all(Request $request) {


        if($request->ajax()){
            $query =  ProductStock::with("product")->latest("product_stocks.id")->with(["product","admin"]);
            // $query = app(Pipeline::class)
            //     ->send($query)
            //     ->through([

            //     ])->thenReturn();
            return $this->table($query)
                ->addIndexColumn()

                ->addColumn("created_at",function($row){
                    return $row->created_at->format("d-m-Y h:i:s");
                })
                ->addColumn("flag",function($row){
                    return $row->flag_badge;
                })->addColumn("price",function($row){
                    return $row->stock * $row->product->price;
                })->addColumn("single_price",function($row){
                    
                    return $row->product?->price ?? 0;
                })
                ->rawColumns(["flag","price","single_price"])
                ->make(true);
        }

        return view("admin.product.stock_all");
    }
}
