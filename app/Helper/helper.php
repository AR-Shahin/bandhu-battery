<?php
use Carbon\Carbon;
use App\Models\SellDetails;
use Illuminate\Support\Str;
use App\Helper\Trait\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Helper\File\File as FileFile;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Storage;
use Rakibhstu\Banglanumber\NumberToBangla;


function database_backup(Helper $helper,$is_download = true)
{
try{
    Log::info("Backup Start.");
    $backupDir = storage_path('backups');
    if (!is_dir($backupDir)) {
        mkdir($backupDir, 0777, true);
    }
    $directoryPath = storage_path("backups");
    $oldSQLFiles = File::glob("$directoryPath/*.sql");
    foreach ($oldSQLFiles as $file) {
        FileFile::deleteFile($file);
    }

    $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
    $backupFile = "{$backupDir}/backup_{$timestamp}.sql";
    if(DB::connection()->getDriverName() == "sqlite"){
        $helper->warningAlert("Wrong Database!");
        return back();
    }
    $tables = DB::select('SHOW TABLES');
    $tableKey = key((array)$tables[0]);

    $file = fopen($backupFile, 'w');

    foreach ($tables as $table) {
        $tableName = $table->{$tableKey};

        // Get CREATE TABLE statement
        $createTable = DB::select("SHOW CREATE TABLE {$tableName}")[0]->{'Create Table'};

        // Write CREATE TABLE statement to the backup file
        fwrite($file, $createTable . ";\n\n");

        // Get table data
        $data = DB::select("SELECT * FROM {$tableName}");

        if (count($data)) {
            // Insert data into backup file
            foreach ($data as $row) {
                $rowData = array_values((array)$row);
                $rowData = array_map(fn ($val) => is_null($val) ? 'NULL' : "'" . addslashes($val) . "'", $rowData);
                $rowDataStr = implode(', ', $rowData);
                fwrite($file, "INSERT INTO {$tableName} VALUES ({$rowDataStr});\n");
            }

            fwrite($file, "\n");
        }
    }

    fclose($file);

    if($is_download){
        return response()->download($backupFile);
    }
    return $backupFile;
}catch(Exception $e){
    Log::log($e->getMessage());
    dd($e->getMessage());
}
}


function database_backup_with_file(Helper $helper) {
    try{
        $directoryPath = storage_path("app/Laravel");


    $zipFiles = File::glob("$directoryPath/*.zip");
    foreach ($zipFiles as $zipFile) {

        $filename = pathinfo($zipFile, PATHINFO_FILENAME);

        $zipFileContents = Storage::get("Laravel/{$filename}.zip");

        unlink($zipFile);
    }

    $exitCode = Artisan::call("backup:run");
    if($exitCode != 0){

        $helper->errorAlert("Error!");
        return back();
    }else{
        $zipFiles = File::glob("$directoryPath/*.zip");

        if($zipFiles){
            return response()->download($zipFiles[0]);
        }else{

            $helper->warningAlert("Something went wrong!");
            return back();
        }
    }

    }catch(Exception $e){
        Log::info("Backup Error " . $e->getMessage());
        dd($e->getMessage());
    }

}


function convert_eng_to_bn_number($number)
{
    $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $banglaNumbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

    return str_replace($englishNumbers, $banglaNumbers, $number);
}


function convertNumberToBanglaWords($number)
{
    $banglaNumbers = [
        0 => 'শূন্য', 1 => 'এক', 2 => 'দুই', 3 => 'তিন', 4 => 'চার',
        5 => 'পাঁচ', 6 => 'ছয়', 7 => 'সাত', 8 => 'আট', 9 => 'নয়',
        10 => 'দশ', 11 => 'এগারো', 12 => 'বারো', 13 => 'তেরো', 14 => 'চৌদ্দ',
        15 => 'পনেরো', 16 => 'ষোলো', 17 => 'সতেরো', 18 => 'আঠারো', 19 => 'উনিশ',
        20 => 'বিশ', 30 => 'ত্রিশ', 40 => 'চল্লিশ', 50 => 'পঞ্চাশ',
        60 => 'ষাট', 70 => 'সত্তর', 80 => 'আশি', 90 => 'নব্বই'
    ];

    $units = [
        100 => 'শত', 1000 => 'হাজার', 100000 => 'লক্ষ', 10000000 => 'কোটি'
    ];

    if ($number < 21) {
        return $banglaNumbers[$number];
    } elseif ($number < 100) {
        $tens = (int)($number / 10) * 10;
        $remainder = $number % 10;
        return $banglaNumbers[$tens] . ($remainder ? ' ' . $banglaNumbers[$remainder] : '');
    } elseif ($number < 1000) {
        $hundreds = (int)($number / 100);
        $remainder = $number % 100;
        return $banglaNumbers[$hundreds] . ' ' . $units[100] . ($remainder ? ' ' . convertNumberToBanglaWords($remainder) : '');
    } elseif ($number < 100000) {
        $thousands = (int)($number / 1000);
        $remainder = $number % 1000;
        return convertNumberToBanglaWords($thousands) . ' ' . $units[1000] . ($remainder ? ' ' . convertNumberToBanglaWords($remainder) : '');
    } elseif ($number < 10000000) {
        $lakhs = (int)($number / 100000);
        $remainder = $number % 100000;
        return convertNumberToBanglaWords($lakhs) . ' ' . $units[100000] . ($remainder ? ' ' . convertNumberToBanglaWords($remainder) : '');
    } else {
        $crores = (int)($number / 10000000);
        $remainder = $number % 10000000;
        return convertNumberToBanglaWords($crores) . ' ' . $units[10000000] . ($remainder ? ' ' . convertNumberToBanglaWords($remainder) : '');
    }
}

function bn_to_en($num)  {
    $numto = new NumberToBangla();
    return $numto->bnWord($num);
}



function getSellData($date = null)
{
    // If no date is passed, use the current date
    $date = $date ? Carbon::parse($date) : now();

    // Get the month and year from the provided or default date
    $month = $date->month;
    $year = $date->year;

    // Query to fetch the data
    $sellData = SellDetails::select(
            'products.name as product_name',
            DB::raw('SUM(sell_details.quantity) as total_quantity'),
            DB::raw('GROUP_CONCAT(DISTINCT customers.name ORDER BY customers.name ASC) as customer_names')
        )
        ->join('products', 'sell_details.product_id', '=', 'products.id')
        ->join('sells', 'sell_details.sell_id', '=', 'sells.id')
        ->join('customers', 'sells.customer_id', '=', 'customers.id')
        ->whereMonth('sell_details.created_at', $month)
        ->whereYear('sell_details.created_at', $year)
        ->groupBy('sell_details.product_id', 'products.name')
        ->get();

    return $sellData;
}


function getSellDataByDate($date = null)
{
    // If no date is provided, use the current date
    $date = $date ? Carbon::parse($date) : now();

    // Get the month and year from the provided date
    $month = $date->month;
    $year = $date->year;

    // Query to calculate the total quantity sold in the specific month and year
    $currentMonthSell = DB::table('sell_details')
        ->whereMonth('created_at', $month)    // Filter by month
        ->whereYear('created_at', $year)      // Filter by year
        ->sum('quantity');                     // Sum of the quantities

    return $currentMonthSell;
}


function getTotalPriceByDate($date = null)
{
    // If no date is provided, use the current date
    $date = $date ? Carbon::parse($date) : now();

    // Get the month and year from the provided date
    $month = $date->month;
    $year = $date->year;

    // Query to calculate the total price for the specified month and year
    $totalPrice = DB::table('sell_details')
        ->join('products', 'sell_details.product_id', '=', 'products.id')  // Join products table
        ->whereMonth('sell_details.created_at', $month)                       // Filter by month
        ->whereYear('sell_details.created_at', $year)                         // Filter by year
        ->sum(DB::raw('sell_details.quantity * products.price'));             // Sum of quantity * price

    return $totalPrice;
}
