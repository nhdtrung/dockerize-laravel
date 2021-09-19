<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::fallback(function(){
    return response()->json([
        'error' => 'Page Not Found!'], 404);
});

// Wager APIs for missing understand, dont do that
Route::group([
    'namespace' => 'API\V1',
    'middleware' => 'auth'
], function () {
    Route::get('wagers', 'WagerController@show');
    Route::post('wagers', 'WagerController@store');
    Route::post('wagers/{id}/buy', 'WagerController@buy');
});

// Route::get('/teams', 'TeamController@index');
// Route::get('/teams/create', 'TeamController@create');
// Route::post('/teams/store', 'TeamController@store');
// Route::get('/teams/{id}', 'TeamController@show');
// Route::get('/teams/{id}/edit', 'TeamController@edit');
// Route::put('/teams/{id}/update', 'TeamController@update');
// Route::delete('/teams/{id}/delete', 'TeamController@delete');

