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

//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');
//
//Route::get('/settings', 'UserController@settings')->name('settings');
//
//Route::patch('/settings/update', 'UserController@update')->name('settings.update');
//
//
//Route::get('/product/create', 'ProductController@create')->name('product.create');
//Route::post('/product/store', 'ProductController@store')->name('product.store');
//
//Route::get('/products', 'ProductsController@lists')->name('products.lists');
//
//Route::get('/{test}', 'ProductController@index')->name('product');

Route::post('/link/store', 'LinkController@store')->name('link.store');
Route::post('/conversion', 'LinkController@conversion')->name('conversion');

Route::get('/{link_id}', 'LinkController@index')->name('link');


