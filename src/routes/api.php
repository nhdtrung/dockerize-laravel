<?php

use Illuminate\Http\Request;

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

// Wager APIs
Route::namespace('API\V1')->group(function () {
    Route::post('wagers', 'WagerController@store');
    Route::post('buy/{wager_id}', 'WagerController@buy');
    Route::get('wagers', 'WagerController@show');
});

