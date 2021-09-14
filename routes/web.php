<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MpesaController;

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

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::get('/profile', '\App\Http\Controllers\Auth\ProfileController@show')->name('profile');

Route::get('/products', 'ProductsController@index')->name('products');
Route::get('/products/create', 'ProductsController@create')->name('addproducts');
Route::get('/products/edit/{id}', 'ProductsController@edit')->name('editproducts');
Route::post('/products/store', 'ProductsController@store')->name('storeproducts');
Route::post('/products/update/{id}', 'ProductsController@update')->name('updateproducts');
// Route::post('/products/delete/{id}', 'ProductsController@delete')->name('deleteproducts');
Route::delete('/products/delete/{id}', 'ProductsController@delete')->name('deleteproducts');
Route::get('/products/show{id}', 'ProductsController@show')->name('showproducts');

Route::get('/transactions', 'TransactionController@index')->name('transactions');
Route::get('/transactions/create', 'TransactionController@create')->name('addtransactions');
// Route::get('ajax-autocomplete-search', 'TransactionController@selectSearch')->name('search');
// Route::get('ajax-autocomplete-search2', 'TransactionController@selectSearch2')->name('search');
Route::get('/buyer/search', 'TransactionController@buyerSearch')->name('buyerSearch');
Route::post('/transactions/getVendors/','TransactionController@getVendors')->name('transaction.getVendors');
Route::post('/transactions/getClients/','TransactionController@getClients')->name('transaction.getClients');
Route::get('/transactions/edit/{id}', 'TransactionController@edit')->name('edittransactions');
Route::post('/transactions/store', 'TransactionController@store')->name('storetransactions');
Route::post('/transactions/update/{id}', 'TransactionController@update')->name('updatetransactions');
Route::post('/transactions/delete/{id}', 'TransactionController@delete')->name('deletetransaction');
Route::get('/transactions/show/{id}', 'TransactionController@show')->name('showtransactions');
Route::get('/transactions/receipt', 'TransactionController@generatereceipt')->name('generatereceipt');
Route::post('/transactions/payment', 'MpesaController@transactionpayment')->name('transactionpayment');

Route::get('/abanks', 'BankController@index')->name('abanks');
Route::get('/abanks/create', 'BankController@create')->name('addabank');
Route::get('/abanks/edit/{id}', 'BankController@edit')->name('editabanks');
Route::post('/abanks/store', 'BankController@store')->name('storeabank');
Route::post('/abanks/update/{id}', 'BankController@update')->name('updateabank');
Route::post('/abanks/delete/{id}', 'BankController@delete')->name('deleteabanks');
Route::get('/abanks/show/{id}', 'BankController@show')->name('showabank');

Route::get('/clients', 'ClientController@index')->name('clients');
Route::get('/clients/create', 'ClientController@create')->name('addclient');
Route::get('/clients/edit/{id}', 'ClientController@edit')->name('editclient');
Route::get('/clients/location/{id}', 'ClientController@location')->name('location');
Route::post('/clients/store', 'ClientController@store')->name('storeclient');
Route::post('/cients/update/{id}', 'ClientController@update')->name('updateclient');
Route::post('/clients/delete/{id}', 'ClientController@delete')->name('deleteclient');
Route::get('/clients/show/{id}', 'ClientController@show')->name('showclient');

Route::get('/vendors', 'VendorController@index')->name('vendors');
Route::get('/vendors/create', 'VendorController@create')->name('addvendor');
Route::get('/vendors/edit/{id}', 'VendorController@edit')->name('editvendor');
Route::post('/vendors/store', 'VendorController@store')->name('storevendor');
Route::post('/vendors/update/{id}', 'VendorController@update')->name('updatevendor');
Route::post('/vendors/delete/{id}', 'VendorController@delete')->name('deletevendor');
Route::get('/vendors/show/{id}', 'VendorController@show')->name('showvendor');
Route::get('/vendors/search', 'VendorController@search')->name('vendorsearch');


Route::get('/disputes', 'DisputeController@index')->name('disputes');
Route::get('/disputes/create', 'DisputeController@create')->name('adddispute');
Route::post('/disputes/store', 'DisputeController@store')->name('stordispute');
Route::post('/disputes/update', 'DisputeController@update')->name('updatedispute');
Route::post('/disputes/delete', 'DisputeController@delete')->name('deletedispute');
Route::get('/disputes/show', 'DisputeController@show')->name('showdispute');

Route::get('/deposits', 'DepositController@index')->name('deposits');
Route::get('/deposits/create', 'DepositController@create')->name('adddeposit');
Route::post('/deposits/store', 'DepositController@store')->name('storedeposit');
Route::post('/deposits/update', 'DepositController@update')->name('updatedeposit');
Route::post('/deposits/delete', 'DepositController@delete')->name('deletedeposit');
Route::get('/deposits/show', 'DepositController@show')->name('showdeposit');

Route::get('/payments', 'PaymentController@index')->name('payments');
Route::get('/payments/create', 'PaymentController@create')->name('addpayment');
Route::post('/payments/store', 'PaymentController@store')->name('storepayment');
Route::post('/payments/update', 'PaymentController@update')->name('updatepayment');
Route::post('/payments/delete', 'PaymentController@delete')->name('deletepayment');
Route::get('/payments/show', 'PaymentController@show')->name('showpayment');

Route::get('/settlements', 'SettlementController@index')->name('settlements');
Route::get('/settlements/create', 'SettlementController@create')->name('addsettlement');
Route::post('/settlements/store', 'SettlementController@store')->name('storesettlement');
Route::post('/settlements/update', 'SettlementController@update')->name('updatesetlement');
Route::post('/settlements/delete', 'SettlementController@delete')->name('deletesettlement');
Route::get('/settlements/show', 'SettlementController@show')->name('showsettlement');


Route::get('/deliveries', 'DeliveryController@index')->name('deliveries');
Route::get('/deliveries/create', 'DeliveryController@create')->name('adddelivery');
Route::post('/deliveries/acceptdelivery', 'MpesaController@acceptDelivery')->name('acceptdelivery');
Route::post('/deliveries/rejectDelivery', 'RejectDeliveryController@rejectDelivery')->name('rejectDelivery');
Route::get('/deliveries/rejections', 'RejectDeliveryController@index')->name('rejections');
Route::get('/deliveries/rejectionInfo/{id}', 'RejectDeliveryController@show')->name('rejectionInfo');
Route::get('/deliveries/clearRejection/{id}', 'RejectDeliveryController@clearRejection')->name('clearRejection');
Route::get('/deliveries/search', 'DeliveryController@search')->name('deliverysearch');
Route::post('/deliveries/update', 'DeliveryController@update')->name('updatedelivery');
Route::post('/deliveries/delete', 'DeliveryController@delete')->name('deletedelviery');
Route::get('/deliveries/show/{id}', 'DeliveryController@show')->name('showdelivery');


Route::get('/mediations', 'MediationController@index')->name('mediations');
Route::get('/mediations/create', 'MediationController@create')->name('addmediation');
Route::post('/mediations/store', 'MediationController@store')->name('storemediation');
Route::post('/mediations/update', 'MediationController@update')->name('updatemediation');
Route::post('/mediations/delete', 'MediationController@delete')->name('deletemediation');
Route::get('/mediations/show', 'MediationController@show')->name('showmediation');


/**
 * Mpesa Web Route For B2c
 */

Route::get('/b2c', function(){
    return view('Mpesa/b2c');
});

Route::post('simulateb2c', [MpesaController::class, 'b2cRequest'])->name('b2cRequest');