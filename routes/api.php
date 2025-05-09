<?php

use App\Http\Controllers\API\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix("v1")->controller(APIController::class)->group(function(){
    Route::get("dashboard","dashboard");
    Route::get("stocks","stocks");
});
