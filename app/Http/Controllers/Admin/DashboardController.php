<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Sell;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\SellDetails;

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
            ],
            "currentMonthSell" => DB::table('sell_details')
            ->whereMonth('created_at', now()->month) // Filter by current month
            ->whereYear('created_at', now()->year)  // Filter by current year
            ->sum('quantity'),
            "totalPrice" => DB::table('sell_details')
                ->join('products', 'sell_details.product_id', '=', 'products.id') // Join products table
                ->whereMonth('sell_details.created_at', now()->month) // Filter for current month
                ->whereYear('sell_details.created_at', now()->year)   // Filter for current year
                ->sum(DB::raw('sell_details.quantity * products.price')),
            "sellData" => SellDetails::select('products.name as product_name', DB::raw('SUM(sell_details.quantity) as total_quantity'))
                    ->join('products', 'sell_details.product_id', '=', 'products.id') // Join products table
                    ->whereMonth('sell_details.created_at', now()->month) // Filter for current month
                    ->whereYear('sell_details.created_at', now()->year)   // Filter for current year
                    ->groupBy('sell_details.product_id', 'products.name') // Group by product ID and name
                    ->get()
        ]);
    }
}
