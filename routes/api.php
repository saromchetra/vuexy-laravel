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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace'=> 'Api'], function(){
    Route::resource('/address', 'AdressController', [
        'except' => ['edit', 'show', 'store']
    ]);
    Route::post('get-province', 'AdressController@getProvince');
    Route::post('get-khan', 'AdressController@getKhan');
    Route::post('get-sangkat', 'AdressController@getSangkat');
    Route::post('get-village', 'AdressController@getVillage');
});
