<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sell;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    private int $take = 15;
    function index()  {
        $products = Product::pluck('stock', 'name')->toArray();
        return view("admin.dashboard",[
            "warning_products" => Product::isActive()->where("stock","<=",10)->take(10)->get(['id',"name","stock"]),

            "top_customers" => Customer::select(["id","name"])->whereHas("sells")->withCount('sells')
            ->orderBy('sells_count', 'desc')
            ->take($this->take)
            ->get(),

            "top_products" => Product::select('id', 'name',"stock")
                ->whereHas('sells')
                ->withCount('sells')
                ->orderBy('sells_count', 'desc')
                ->take($this->take)
                ->get(),

            "today_sells" => Sell::select("id", "invoice_id", "quantity", "created_at")
                ->whereDate('created_at', today())
                ->paginate($this->take),
            "products" => [
                "names" => array_keys($products),
                "stocks" => array_values($products),
               # "totalAmountOfMoney" => convert_eng_to_bn_number(number_format(Product::sum(DB::raw('stock * price')),2))
                "totalAmountOfMoney" => Product::sum(DB::raw('stock * price'))
            ]
        ]);
    }
}
