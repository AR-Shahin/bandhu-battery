<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Repositories\BaseCRUDRepository;

class CategoryController extends Controller
{
    private $repository;
    private $table = "categories";

    function __construct()
    {
        parent::__construct();
        $this->repository = new BaseCRUDRepository(new Category());
    }

    function index(Request $request, Category $category)  {
        $categories = $category->rootCategories();

        if($request->ajax()){

            return $this->table($this->repository->query(["parent"]))
                ->addIndexColumn()
                ->addColumn("name",fn($row) => "$row->bn_name - $row->en_name")
                ->addColumn("actions",function($row) use ($categories){
                    $deleteRoute = route('admin.categories.destroy', $row["id"]);
                    $editRoute = route('admin.categories.update', $row["id"]);
                    $html = $this->generateCategoryEditButton($row,$editRoute,$categories) .  $this->generateDeleteButton($row,$deleteRoute,"admin-delete","DELETE");
                    return $html;
                })

                ->addColumn("status", fn($row) => $row->status_badge)

                ->rawColumns(["actions","status","name"])
                ->make(true);
        }
        return view("admin.category.index",compact("categories"));
    }

    function destroy($category) {
        if($this->repository->delete($category)){
            $this->deletedAlert();
            return back();
        }
    }

    function store(Request $request) {
        $request->validate([
            "bn_name" => ["required","unique:$this->table,bn_name"],
            "en_name" => ["required","unique:$this->table,en_name"],
            "parent_id" => ["required"]
        ]);
        if(
            $this->repository->store([
                "parent_id" => $request->parent_id,
                "bn_name" => $request->bn_name,
                "en_name" => $request->en_name,
            ])
        ){
            $this->createdAlert();
            return back();
        }
    }

    function update(Request $request,$id) {
        $request->validate([
            "name" => ["required",Rule::unique($this->table)->ignore($id)]
        ]);
        if(
            $this->repository->update($id,[
                "name" => $request->name,
                "slug" => $request->name,
            ])
        ){
            $this->updatedAlert();
            return back();
        }
    }
}
