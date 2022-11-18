<?php

use App\Http\Controllers\GeneralController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [GeneralController::class, "index"])->name("home");
Route::get('/invoices', [GeneralController::class, "invoices"])->name("invoices");
Route::get('/invoices/{id?}', [GeneralController::class, "getInvoice"])->name("getInvoice");
