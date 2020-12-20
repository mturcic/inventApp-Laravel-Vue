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

//custom
Route::get('kategorije','KategorijaController@all');
Route::get('prostori','ProstorController@all');
Route::get('inventari','InventarController@all');
Route::get('vrste','VrstaController@all');
Route::get('tvrtke','TvrtkaController@all');
Route::get('prostorije','ProstorijaController@all');
Route::get('findInventar','InventarController@search');
Route::put('userUpdate','AppController@update');

Route::resource('kategorija', 'KategorijaController');
Route::resource('vrsta', 'VrstaController');
Route::resource('prostor', 'ProstorController');
Route::resource('prostorija', 'ProstorijaController');
Route::resource('inventar', 'InventarController');
Route::resource('tvrtka', 'TvrtkaController');

Route::post('formSubmit','InventarController@formSubmit');