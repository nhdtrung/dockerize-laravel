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

Route::fallback(function(){
    return response()->json([
        'error' => 'Page Not Found!'], 404);
});

// Wager APIs for missing understand, dont do that
Route::namespace('API\V1')->group(function () {
    Route::post('wagers', 'WagerController@store');
    Route::post('buy/{wager_id}', 'WagerController@buy');
    Route::get('wagers', 'WagerController@show');
});
