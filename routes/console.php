<?php

use App\Console\Commands\DBBackupInDrive;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


// Schedule::call(new DBBackupInDrive)->everySecond();

Schedule::command("db_backup_in_drive")->daily();


#/opt/cpanel/ea-php82/root/usr/bin/php /home2/bandhuba/shop.bandhubattery.com/artisan schedule:run >> /dev/null 2>&1

