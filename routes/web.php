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
    return redirect('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function() {
	Route::resource('/supplier', 'SupplierController');
	Route::resource('/product', 'ProductController');
	Route::get('/product/detail/{id}', 'ProductController@detail')->name('product.detail');
	Route::resource('/purchase-order', 'PurchaseOrderController');

	Route::get('/purchase-order/product/{supplier}', 'PurchaseOrderController@getProduct')->name('purchase-order.product');
	Route::patch('/purchase-order/approve/{id}', 'PurchaseOrderController@approve')->name('purchase-order.approve');
	Route::delete('/purchase-order/delete-item/{id}', 'PurchaseOrderController@deleteItem')->name('purchase-order.delete-item');
}); 