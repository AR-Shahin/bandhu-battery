<?php

namespace App\Http\Controllers\API;

use App\Models\Sell;
use App\Models\Product;
use App\Models\Customer;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class APIController extends Controller
{
    private int $take = 15;
    function dashboard(Request $request)  {
        $products = Product::pluck('stock', 'name')->toArray();

        return response()->json([
            "warning_products" => Product::isActive()
                ->where("stock", "<=", 10)
                ->take(10)
                ->get(['id', "name", "stock"]),

            "top_customers" => Customer::select(["id", "name"])
                ->whereHas("sells")
                ->withCount('sells')
                ->orderBy('sells_count', 'desc')
                ->take($this->take)
                ->get(),

            "top_products" => Product::select('id', 'name', "stock")
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
                // "totalAmountOfMoney" => convert_eng_to_bn_number(number_format(Product::sum(DB::raw('stock * price')),2))
                "totalAmountOfMoney" => Product::sum(DB::raw('stock * price'))
            ],

            "currentMonthSell" => getSellDataByDate($request->date),
            "totalSellPrice" => getTotalPriceByDate($request->date),
            "sellData" => getSellData($request->date)
        ]);
    }

    function stocks() {
        $data =  ProductStock::with("product")->latest("product_stocks.id")->with(["product","admin"])->paginate(20);

        return response([
            "stocks" => $data
        ]);
    }
}
