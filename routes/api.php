<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/test', function (Request $request) {
//    return response(['success']);
//});
//
//Route::group(['middleware'  => 'auth',
//    'headers'     => ['Accept' => 'application/json']
//], function(){
//    Route::get('/test', function (Request $request) {
//        return response(['success']);
//    });
//});


