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
Route::post('storeCategory', 'CategoriesController@store');
Route::get('getCategories', 'CategoriesController@index');
Route::post('updateCategory/{id}', 'CategoriesController@update');
Route::get('showCategory/{id}', 'CategoriesController@show');
Route::post('deleteCategory/{id}', 'CategoriesController@destroy');

Route::post('storeProduct', 'ProductsController@store');
Route::get('getProducts', 'ProductsController@index');
Route::post('updateProduct/{id}', 'ProductsController@update');
Route::get('showProduct/{id}', 'ProductsController@show');
Route::post('deleteProduct/{id}', 'ProductsController@destroy');

Route::post('storeOrder', 'OrdersController@store');
Route::get('getOrders', 'OrdersController@index');
Route::post('updateOrder/{id}', 'OrdersController@update');
Route::get('showOrder/{id}', 'OrdersController@show');
Route::post('deleteOrder/{id}', 'OrdersController@destroy');
//enter more routes here, leaving below as last route!
Route::any('{path?}', 'MainController@index')->where("path", ".+");
