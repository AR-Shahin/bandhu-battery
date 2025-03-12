<?php

use App\Models\Admin;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Helper\File\File as FileFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Admin\Auth\Foo;
use Yaza\LaravelGoogleDriveStorage\Gdrive;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Models\Image;
use Google\Service\NetworkManagement\RerunConnectivityTestRequest;

Route::get('/', function () {
    // $admin =  Admin::first();
    // return $admin->getAllPermissions()->pluck("name");
    return redirect()->route("admin.login");
});

Route::get('/dashboard', function () {
    return redirect()->route("admin.dashboard");
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
require __DIR__.'/admin/auth.php';
require __DIR__.'/admin/web.php';

Route::view("ars","admin.layouts.app")->name("ars");


Route::get('image',function () {
    return view("image");
});
Route::post('image',function (Request $request) {
    if(!$request->hasFile("image")){
        return back();
    }
    $img =  Image::create([
        "image" => FileFile::upload($request->file("image"),"ars")
     ]);
     return response([
        "message" => "Image uploaded successfully",
        "path" => asset($img->image)
     ]);
})->name("image");

Route::get("drive", function () {



    $contents = Gdrive::all('/shop',false);
    dd($contents);
});


Route::get("backup-drive", function () {

    Artisan::call("db_backup_in_drive");
    session()->flash("success","Backup in drive");
    return back();
})->name("backup_drive");

Route::get("mail",function(){
    try{
        $details = [
            'subject' => 'Test Email',
            'message' => 'This is a test email sent using Laravel and cPanel custom domain email.'
        ];

        Mail::to('mdshahinmije96@gmail.com')->send(new TestMail($details));
    }catch(Exception $e){
        dd($e->getMessage());
    }

});
