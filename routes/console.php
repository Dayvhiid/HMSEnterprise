<?php

use App\Http\Controllers\TwilioSmsController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    (new TwilioSmsController)->test();
})->everyMinute();

Schedule::call(function () {
    (new TwilioSmsController)->playing();
})->everyFifteenSeconds();