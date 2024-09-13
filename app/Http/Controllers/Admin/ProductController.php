<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Vendor;
use App\Repositories\BaseCRUDRepository;

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

            return $this->table($this->repository->query(["category","brand","unit","vendor"]))
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
                    $html = $this->generateEditButton($row,$editRoute,) .  $this->generateDeleteButton($row,$deleteRoute,"admin-delete","DELETE");
                    return $html;
                })

                ->addColumn("status", fn($row) => $row->status_badge)

                ->rawColumns(["actions","status","stock"])
                ->make(true);
        }
        return view("admin.product.index");
    }

    function destroy($product) {
        if($this->repository->delete($product)){
            $this->deletedAlert();
            return back();
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
            "name" => ["required"],
            "stock" => ["required"],
        ]);
        $product = $this->repository->store([
            "category_id" => $request->category_id,
            "brand_id" => $request->brand_id,
            "unit_id" => $request->unit_id,
            "name" => $request->name,
            "stock" => $request->stock,
            "vendor_id" => $request->vendor_id,
            "admin_id" => auth()->id(),
            "code" => "-",
            "description" => $request->des
        ]);
        if(
            $product
        )
        {
            $product->update([
                "code" => "PN-{$product->id}"
            ]);
            $this->createdAlert();
            return back();
        }
    }

    function update(Request $request,$id) {

        // $request->validate([
        //     "bn_name" => ["required","unique:$this->table,bn_name"],
        //     "en_name" => ["required","unique:$this->table,en_name"],
        // ]);
        if(
            $this->repository->update($id,[
                "bn_name" => $request->bn_name,
                "en_name" => $request->en_name,
                "parent_id" => $request->parent_id ?? null,
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
}
