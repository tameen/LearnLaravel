<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/store', 'App\Http\Controllers\StoreController@index')->name('stores.index')->middleware('auth');
Route::get('/store/getstore', 'App\Http\Controllers\StoreController@getStore')->name('stores.get')->middleware('auth');
Route::post('/store/create', 'App\Http\Controllers\StoreController@store')->middleware('auth');
Route::delete('/store/delete/{id}', 'App\Http\Controllers\StoreController@destroy')->middleware('auth');
Route::put('store/update/{id}', 'App\Http\Controllers\StoreController@update')->middleware('auth');
Route::get('store/json/{id}', 'App\Http\Controllers\StoreController@jsonData')->middleware('auth');
Route::get('/store/{id}', 'App\Http\Controllers\StoreController@show')->middleware('auth');




