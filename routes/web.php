<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Invoices\RiderInvoiceController;
use App\Http\Controllers\invoices\TaxInvoiceController;
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
//Route::get('/home', [HomeController::class, 'index'])->name('home');
//Route::post('notify','LeadController@notify');
Route::get('expiry_checker', [HomeController::class, 'expiry_checker']);
Route::get('redirect_url', [HomeController::class, 'redirect_url']);
Auth::routes();
Route::get('/', function () {
    return Redirect::to('home');
    //    return view('home');
});
Route::get('noti', function () {
    return view('noti');
});
Route::get('get_agent_umrah_notification', function () {
    event(new App\Events\NotificationEvent('Some Agent Create Umrah Trip'));
});
//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return view('dashboard');
//})->name('dashboard');

Route::get('/locale/update/{user_prefer_language}', function ($locale) {
    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/logout', function () {
        Auth::logout();
        return Redirect::to('login');
    });
    Route::prefix('invoices')->group(function () {
        Route::resource('vendor_invoices', Invoices\VendorInvoiceController::class);
        Route::resource('rider_invoices', Invoices\RiderInvoiceController::class);
        Route::any('tax_invoice', [TaxInvoiceController::class, 'index'])->name('tax_invoice');
        Route::get('getInvoices', [RiderInvoiceController::class, 'getInvoices'])->name('getInvoices');
        Route::get('search_item_price/{RID}/{itemID}', [\App\Http\Controllers\ItemController::class, 'search_item_price']);
        Route::post('import_excel', [\App\Http\Controllers\Invoices\RiderInvoiceController::class, 'import_excel'])->name('invoices.import_excel');
        Route::any('sendemail/{id}', [\App\Http\Controllers\Invoices\RiderInvoiceController::class, 'sendEmail'])->name('invoices.send_email');
    });
    Route::resource('item', ItemController::class);
    Route::get('item_assign_rv', 'ItemController@assign_rv');
    Route::post('save_rv', 'ItemController@save_rv');
    Route::get('/assign_price', [\App\Http\Controllers\ItemController::class, 'assign_price'])->name('item.assign_price');
    Route::get('/assign_price_edit/{id}/{VID}', 'ItemController@assign_price_edit');
    Route::delete('del_assignRV/{VID}', 'ItemController@del_assignRV');

    //    Route::post('item/fetch_vendor',[\App\Http\Controllers\ItemController::class,'fetch_vendor'])->name('item.fetch_vendor');
    Route::post('item/fetch_rider', [\App\Http\Controllers\ItemController::class, 'fetch_rider'])->name('item.fetch_rider');
    Route::resource('vendors', VendorController::class);
    Route::get('assign_rider', [\App\Http\Controllers\AssignRiderController::class, 'index'])->name('vendor.assign_rider');
    Route::post('vendor/assign_rider/store', [\App\Http\Controllers\AssignRiderController::class, 'store'])->name('vendor.assign_rider.store');
    Route::delete('vendor/assign_rider/destroy/{id}', [\App\Http\Controllers\AssignRiderController::class, 'destroy']);
    Route::get('vendor/assign_rider/edit/{id}', [\App\Http\Controllers\AssignRiderController::class, 'edit']);
    Route::resource('rider', RiderController::class);

    Route::get('riders/contract/{id?}', [\App\Http\Controllers\RiderController::class, 'contract'])->name('rider.contract');
    Route::any('riders/contract_upload/{id?}', [\App\Http\Controllers\RiderController::class, 'contract_upload'])->name('rider_contract_upload');
    Route::any('riders/picture_upload/{id?}', [\App\Http\Controllers\RiderController::class, 'picture_upload'])->name('rider_picture_upload');
    Route::any('riders/show/{id?}', [\App\Http\Controllers\RiderController::class, 'show'])->name('rider_show');
    Route::any('riders/view/{id?}', [\App\Http\Controllers\RiderController::class, 'show'])->name('rider_view');

    Route::get('bike/get_bike_history/{id?}', [\App\Http\Controllers\BikeController::class, 'get_bike_history']);
    Route::get('bike/contract/{id?}', [\App\Http\Controllers\BikeController::class, 'contract']);
    Route::post('bike/contract_upload', [\App\Http\Controllers\BikeController::class, 'contract_upload'])->name('contract_upload');
    Route::post('change_rider', [\App\Http\Controllers\BikeController::class, 'change_rider'])->name('bike.change_rider');

    Route::get('sim/get_sim_history/{id?}', [\App\Http\Controllers\SimController::class, 'get_sim_history']);
    Route::post('change_status', [\App\Http\Controllers\SimController::class, 'change_rider'])->name('sim.change_status');
    Route::post('rider/import_excel', [\App\Http\Controllers\RiderController::class, 'import_excel'])->name('rider.import_excel');
    Route::any('rider-document/{id}', [\App\Http\Controllers\RiderController::class, 'document'])->name('rider.document');
    Route::any('rider-status', [\App\Http\Controllers\RiderController::class, 'status'])->name('rider.status');
    Route::any('item-list', [\App\Http\Controllers\RiderController::class, 'getItems'])->name('rider.items');


    Route::resource('bike', BikeController::class);
    Route::get("bike/fetch_vendor_comp/{RID}", [\App\Http\Controllers\BikeController::class, 'fetch_vendor_comp'])->name('bike.fetch_vendor_comp');
    Route::resource('sim', SimController::class);
    Route::resource('projects', ProjectsController::class);
    Route::resource('countries', CountryController::class);
    Route::post('get_countries', 'CountryController@get_data');
    //appication setup
    Route::prefix('Application_Setup')->group(function () {
        Route::prefix('user_management')->group(function () {
            Route::resource('roles', RoleController::class);
            Route::post('store_menu', 'RoleController@store_menu');
            Route::post('get_menu', 'RoleController@get_menu');
            Route::resource('users', UserController::class);
            Route::resource('permission', PermissionController::class);
            Route::post('get_permission', 'PermissionController@get_data');
            Route::get('get_role_permission/{id}', 'PermissionController@get_role_permission');
        });

    });
    Route::resource('rta_fine', RtaFineController::class);
    Route::post('rta_fine/import_excel', [\App\Http\Controllers\RtaFineController::class, 'import_excel'])->name('rta_fine.import_excel');
    Route::post('get_rta_fine', 'RtaFineController@get_data');
    Route::resource('sim_charges', SimChargesController::class);
    Route::post('get_sim_charges', 'SimChargesController@get_data');
    Route::resource('lease_company', LeaseCompController::class);
    //Fetch Routes all common and basics result call
    Route::get('fetch_cities', 'CityController@fetch_cities');
    Route::get('menu_notification', 'HomeController@menu_notification');
    Route::get('seen_notification/{tbl_name}', 'HomeController@seen_notification');
    Route::any('settings', [\App\Http\Controllers\HomeController::class, 'settings'])->name('settings');

    Route::resource('vouchers', VouchersController::class);
    Route::post('import_excel', 'VouchersController@import_excel')->name('voucher.import_excel');
    Route::get('get_invoice_balance', 'VouchersController@GetInvoiceBalance')->name('get_invoice_balance');
    Route::get('fetch_invoices/{id}/{vt}', 'VouchersController@fetch_invoices');
    Route::any('attach_file/{id}', 'VouchersController@fileUpload');

    Route::resource('loans', LoansController::class);

});






