<?php

use App\Models\Admin;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\Auth\Foo;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

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


Route::get('bal',[LoginController::class,"create"]);

Route::get("drive", function () {
    // Increase memory limit
    ini_set('memory_limit', '512M');

    // Define the specific folder ID
    $folderId = '1tCXXKEhuDoBya2rCVORbH1Y8QsrHrWB1';

    // Path where the file should be stored
    $filePath = $folderId . "/ars.png"; // The file will be stored inside the folder with ID 1tCXXKEhuDoBya2rCVORbH1Y8QsrHrWB1

    // Get the file content
    $file = storage_path("app/asa.png");
    $fileData = File::get($file);

    // Upload the file to Google Drive inside the specified folder
    Storage::disk('google')->put($filePath, $fileData);

    return response()->json(['status' => 'File uploaded successfully']);
});




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
