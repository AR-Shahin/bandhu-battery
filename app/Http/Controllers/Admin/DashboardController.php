<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    function index()  {

        return view("admin.dashboard",[
            "waring_products" => Product::isActive()->where("stock","<=",10)->take(10)->get(['id',"name","stock"]),
            "top_customers" => Customer::whereHas("sells")->withCount('sells')
            ->orderBy('sells_count', 'desc')
            ->take(15)
            ->get(),
            "top_products" => Product::whereHas("sells")->withCount('sells')
            ->orderBy('sells_count', 'desc')
            ->take(15)
            ->get()
        ]);
    }
}
