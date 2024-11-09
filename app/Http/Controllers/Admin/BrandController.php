<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Repositories\BaseCRUDRepository;

class BrandController extends Controller
{
    private $repository;
    private $table = "brands";

    function __construct()
    {
        parent::__construct();
        $this->repository = new BaseCRUDRepository(new Brand());
    }

    function index(Request $request)  {
        if($request->ajax()){

            return $this->table($this->repository->query())
                ->addIndexColumn()
                ->addColumn("name",fn($row) => "$row->bn_name - $row->en_name")
                ->addColumn("actions",function($row) {
                    $deleteRoute = route('admin.brands.destroy', $row["id"]);
                    $editRoute = route('admin.brands.update', $row["id"]);
                    $html = $this->generateEditButton($row,$editRoute);
                    //  $this->generateDeleteButton($row,$deleteRoute,"admin-delete","DELETE");
                    return $html;
                })

                ->rawColumns(["actions","status","name"])
                ->make(true);
        }
        return view("admin.brand.index");
    }

    function destroy($brand) {
        if($this->repository->delete($brand)){
            $this->deletedAlert();
            return back();
        }
    }

    function store(Request $request) {
        $request->validate([
            "bn_name" => ["required","unique:$this->table,bn_name"],
            "en_name" => ["required","unique:$this->table,en_name"],
        ]);
        if(
            $this->repository->store([
                "bn_name" => $request->bn_name,
                "en_name" => $request->en_name,
            ])
        ){
            $this->createdAlert();
            return back();
        }
    }

    function update(Request $request,$id) {
      //  return $request;
        $request->validate([
            "bn_name" => ["required"],
            "en_name" => ["required"],
        ]);
        if(
            $this->repository->update($id,[
                "bn_name" => $request->bn_name,
                "en_name" => $request->en_name,
            ])
        ){
            $this->updatedAlert();
            return back();
        }
    }
}
