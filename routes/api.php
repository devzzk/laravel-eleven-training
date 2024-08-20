<?php

use Illuminate\Support\Facades\Route;

Route::post('/test', [\App\Http\Controllers\CurrentDateController::class, 'test'])->name('api.test');
