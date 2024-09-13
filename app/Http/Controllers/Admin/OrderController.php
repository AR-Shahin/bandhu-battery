<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sell;
use Illuminate\Http\Request;

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
                    $html = $this->generateEditButton($row,$editRoute) .  $this->generateDeleteButton($row,$deleteRoute,"admin-delete","DELETE");
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
}
