<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Reports Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::prefix('reports')->group(function (){
        Route::get('rider_invoice_report','ReportController@rider_invoice_index');
        Route::get('vendor_invoice_report','ReportController@vendor_invoice_index');
    });
});


