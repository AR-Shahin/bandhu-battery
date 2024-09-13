<?php

use App\Helper\Trait\Helper;
use App\Http\Controllers\Admin\{
    AdminController,
    BackupController,
    BrandController,
    CategoryController,
    CustomerController,
    DashboardController,
    OrderController,
    PermissionController,
    ProductController,
    RoleController,
    UnitController,
    VendorController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("admin")->middleware("auth:admin")->name("admin.")->group(function(){
    Route::get("/dashboard",[DashboardController::class,"index"])->name("dashboard");
    Route::post("/backup",fn() => database_backup_with_file(new Helper))->name("backup");
    Route::post("/backup-db",fn() => database_backup(new Helper))->name("backup_db");
    # Role
    Route::prefix('roles')->controller(RoleController::class)->name("roles.")->group(function () {
        Route::get("","index")->name("index");
        Route::post("/store/{role?}","storeAndUpdate")->name("store");
        Route::post("delete/{role}","delete")->name("delete");
        Route::get("assign-permissions/{role}","assignPermission")->name("assign_permission");
        Route::post("assign--permissions/{role}","assignPermissionStore")->name("assign__permission");
    });

      # Permission
      Route::prefix('permissions')->controller(PermissionController::class)->name("permissions.")->group(function () {
        Route::get("","index")->name("index");
        Route::get("data_table","data_table")->name("data_table");
        Route::post("store/{permission?}","store")->name("store");
        Route::post("delete/{permission}","delete")->name("delete");
    });



      # Admin
      Route::prefix('admins')->controller(AdminController::class)->name("admins.")->group(function () {
        Route::get("","index")->name("index");
        Route::get("/create","create")->name("create");
        Route::get("/edit/{admin}","edit")->name("edit");
        Route::get("data_table","data_table")->name("data_table");
        Route::post("store","store")->name("store");
        Route::post("update/{admin?}","update")->name("update");
        Route::post("delete/{admin}","delete")->name("delete");
    });

    # Category
    Route::resource("categories",CategoryController::class)->except(["create","show","edit"]);
    Route::resource("brands",BrandController::class)->except(["create","show","edit"]);
    Route::resource("units",UnitController::class)->except(["create","show","edit"]);
    Route::resource("customers",CustomerController::class)->except(["create","show","edit"]);
    Route::resource("vendors",VendorController::class)->except(["create","show","edit"]);
    Route::resource("products",ProductController::class);
    Route::controller(ProductController::class)->prefix("product")->name("products.")->group(function(){
        Route::get("stock/{product}","stock")->name("stock");
        Route::post("stock_adjust/{product}","stock_adjust")->name("stock_adjust");
    });

    Route::controller(OrderController::class)->prefix("order")->name("orders.")->group(function(){
        Route::get("index","index")->name("index");
        Route::get("create","create")->name("create");
        Route::post("store","store")->name("store");
        Route::get("view/{sell}","view")->name("view");
    });

    Route::get("shahin",[BackupController::class,"backupAndDownload"]);
    Route::get('/download', function (Request $request) {
        $filePath = storage_path('app/' . $request->query('file'));

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        abort(404, 'File not found.');
    })->name('admin.download');
});
