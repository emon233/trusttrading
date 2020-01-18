<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => 'App\Http\Middleware\SuperAdminMiddleware'], function () {
    Route::get('/superAdminOnlyPage', 'HomeController@superAdmin');
});

Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function () {
    Route::get('/adminOnlyPage', 'HomeController@admin');

    Route::get('/brands', 'BrandController@index');
    Route::post('/brands', 'BrandController@store');
    Route::post('/brands/update', 'BrandController@update');
    Route::get('/brands/destroy/{id}', 'BrandController@destroy');

    Route::get('/categories', 'CategoryController@index');
    Route::post('/categories', 'CategoryController@store');
    Route::post('/categories/update', 'CategoryController@update');
    Route::get('/categories/destroy/{id}', 'CategoryController@destroy');

    Route::get('/products/{id}', 'ProductController@index');
    Route::post('/products', 'ProductController@store');
    Route::post('/products/update', 'ProductController@update');
    Route::get('/products/destroy/{id}', 'ProductController@destroy');
    Route::get('/productsearch', 'ProductController@product_search');

    Route::get('/productsbybrand', 'ProductController@get_products_by_brand');
    Route::get('/getInventoryStatusOfProduct', 'ProductController@get_inventory_status_by_product_id');

    Route::get('/productsearchforstock', 'StockController@product_search');
    Route::get('/stocks/{id}', 'StockController@index');

    Route::get('/purchases/{id}', 'PurchaseController@index');
    Route::post('/purchases', 'PurchaseController@store');
    Route::get('/productsearchforpurchase', 'PurchaseController@product_search_for_purchase');
    Route::get('/purchasehistory/{product_id}', 'PurchaseController@history');
    Route::post('/purchases/update', 'PurchaseController@update');

    Route::get('/zones', 'ZoneController@index');
    Route::post('/zones', 'ZoneController@store');
    Route::post('/zones/update', 'ZoneController@update');
    Route::get('/zones/destroy/{id}', 'ZoneController@destroy');

    Route::get('/deliverymen', 'DeliveryManController@index');
    Route::post('/deliverymen', 'DeliveryManController@store');
    Route::post('/deliverymen/update', 'DeliveryManController@update');
    Route::get('/deliverymen/destroy/{id}', 'DeliveryManController@destroy');

    Route::get('/clients', 'ClientController@index');
    Route::post('/clients', 'ClientController@store');
    Route::post('/clients/update', 'ClientController@update');
    Route::get('/clients/destroy/{id}', 'ClientController@destroy');

    Route::get('/morningout', 'DailyZoneDeliverymanComboController@index');

    Route::post('/dailyzonedeliverymancombo', 'DailyZoneDeliverymanComboController@store');
    Route::post('/updateDailyZoneDeliverymanCombo', 'DailyZoneDeliverymanComboController@update');

    Route::get('/editDailySellProductInfo', 'DailySheetController@dailysheetupdate');
    Route::post('/updateProductSellInfo', 'DailySheetController@updateProductSellInfo');

    Route::get('/morningoutproducts/{id}', 'DailySheetController@index')->name('morningoutproducts');
    Route::get('/eveningoutproducts/{id}', 'DailySheetController@evening_index');
    Route::post('/storeDailyOutData', 'DailySheetController@store');
    Route::post('/updateDailyOutData', 'DailySheetController@update');


    Route::get('/search_dailysheet_by_date', 'DailyZoneDeliverymanComboController@search_dailysheet_by_date');

    Route::get('/accounts', 'AccBrandTransactionController@pay_index');
    Route::post('/accounts', 'AccBrandTransactionController@store');
    Route::post('/accounts/update', 'AccBrandTransactionController@update');

    Route::get('/paymenthistory/{id}', 'AccBrandTransactionController@pay_history_index');


    Route::post('/storeClientPaymentData', 'AccClientTransactionController@store');

    Route::post('/storeDailyDamageData', 'DailyZoneDeliverymanComboController@store_damage');

    Route::post('/storeDamageClaimedData', 'DamageClaimController@store');
    Route::post('/storeDebitClaimedData', 'DebitClaimController@store');

    Route::post('/resetProductInfo', 'PurchaseController@resetProductInfo');

    /** Report Section */

    Route::get('/dailysheetindex', 'ReportController@report_daily_sheet_index');
    Route::get('/dailysheetdetails/{id}', 'ReportController@report_daily_sheet_details');

    Route::get('/dailybrandtransactionsindex', 'ReportController@report_daily_brand_transaction_index');
    Route::get('/dailybrandfinalcount/{id}', 'ReportController@report_daily_brand_final_count');
    Route::get('/reportdailybrandfinalcountbydatesearch', 'ReportController@report_daily_brand_final_count_by_date_search');

    Route::get('/dailybranddue/{id}', 'ReportController@report_daily_brand_due');
    Route::get('/dailybrandpayment/{id}', 'ReportController@report_daily_brand_payment');
    Route::get('/dailybrandtransaction/{id}', 'ReportController@report_daily_brand_transaction');

    Route::get('/dailybrandduedatesearch', 'ReportController@report_daily_brand_due_by_date_search');
    Route::get('/dailybrandpaymentdatesearch', 'ReportController@report_daily_brand_payment_by_date_search');
    Route::get('/dailybrandtransactiondatesearch', 'ReportController@report_daily_brand_transaction_by_date_search');

    Route::get('/brandtransaction/{id}', 'ReportController@report_brand_transaction');
    Route::get('/brandtransactionbydatesearch', 'ReportController@report_brand_transaction_by_date_search');

    Route::get('/reportclienttransactionindex', 'ReportController@report_client_transaction_index');
    Route::get('/reportclienttransactiondetails', 'ReportController@report_client_transaction_details');

    Route::get('/inventroyreportindex', 'ReportController@inventory_report_index');
    Route::get('/inventroyreportdetails/{id}', 'ReportController@inventory_report_details');

    Route::get('/duereportdetails/{id}', 'ReportController@due_report_details_2');
    Route::get('/clienttransactiondetails/{client_id}/{brand_id}', 'ReportController@client_transaction_details');
});

Route::group(['middleware' => 'App\Http\Middleware\MemberMiddleware'], function () {
    Route::get('/memberOnlyPage', 'HomeController@member');
});

include_once('defined/js.php');
