<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

//Artisan::command('app:excel-research', function () {
//    ini_set('memory_limit', '-1');
//    $import = (new ProductImport)->withOutput();
//
////    \Maatwebsite\Excel\Facades\Excel::import($import, 'test.xlsx', 'public');
//
//    return 0;
//});

Artisan::command('app:test-ai', function () {

    dump(now()->addHours(15)->addMinutes(43)->timezone('PRC'));

});
