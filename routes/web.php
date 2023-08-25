<?php

use Illuminate\Support\Facades\Route;
use App\ApiHelper;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/admin/dashboard/', 302);
});

Route::post('/request/get-programmes', [ApiHelper::class, 'getProgrammes']);