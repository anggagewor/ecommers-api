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

Route::namespace('Api')->group(function () {

	Route::prefix('bukalapak')->group(function () {
		Route::get('/','BukalapakController@index')->name('bukalapak.index');
		Route::get('/categories','BukalapakController@categories')->name('bukalapak.categories');
		Route::get('/category','BukalapakController@category')->name('bukalapak.categories.slug');
		Route::get('/product','BukalapakController@product')->name('bukalapak.products.slug');
		Route::get('/seller','BukalapakController@seller')->name('bukalapak.sellers.slug');
	});

	Route::prefix('tokopedia')->group(function () {
		Route::get('/','TokopediaController@index')->name('tokopedia.index');
		Route::get('/categories','TokopediaController@categories')->name('tokopedia.categories');
		Route::get('/category','TokopediaController@category')->name('tokopedia.categories.slug');
		Route::get('/product','TokopediaController@product')->name('tokopedia.products.slug');
		Route::get('/seller','TokopediaController@seller')->name('tokopedia.sellers.slug');
	});



	Route::prefix('shopee')->group(function () {
		Route::get('/search','ShopeeController@search')->name('shopee.search');
		Route::get('/{item_id}/{shop_id}','ShopeeController@read')->name('shopee.read');
	});
    
    Route::namespace('V1')->prefix('v1')->group(function () {
    
    
        Route::prefix('tokopedia')->group(function () {
            Route::get('/search','TokopediaController@search')->name('v1.tokopedia.search');
        });
    });
});
