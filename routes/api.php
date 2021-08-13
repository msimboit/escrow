<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('v1/escrow/access/token', 'MpesaController@generateAccessToken');
Route::post('v1/escrow/token', 'MpesaController@GenerateToken');
Route::post('v1/escrow/PASSS', 'MpesaController@GenerateToken');
Route::post('v1/escrow/stk/push', 'MpesaController@customerMpesaSTKPush')->name("push");
Route::post('v1/escrow/validation', 'MpesaController@mpesaValidation');
Route::post('v1/escrow/transaction/confirmation', 'MpesaController@mpesaConfirmation')->name("mpesaConfirmation");
Route::post('v1/escrow/register/url', 'MpesaController@mpesaRegisterUrls');