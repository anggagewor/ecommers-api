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

Route::middleware( 'auth:api' )->get( '/user', function ( Request $request ) {
    return $request->user();
} );

Route::namespace( 'Api' )->group( function () {
    
    Route::prefix( 'bukalapak' )->group( function () {
        Route::get( '/', 'BukalapakController@index' )->name( 'api.bukalapak.index' );
        Route::get( '/categories', 'BukalapakController@categories' )->name( 'api.bukalapak.categories' );
        Route::get( '/category', 'BukalapakController@category' )->name( 'api.bukalapak.categories.slug' );
        Route::get( '/product', 'BukalapakController@product' )->name( 'api.bukalapak.products.slug' );
        Route::get( '/seller', 'BukalapakController@seller' )->name( 'api.bukalapak.sellers.slug' );
        Route::get( '/search', 'BukalapakController@search' )->name( 'api.bukalapak.search' );
        Route::get( '/get-category', 'BukalapakController@getCategories' )->name( 'api.bukalapak.get.category' );
    } );
    
    Route::prefix( 'tokopedia' )->group( function () {
        Route::get( '/', 'TokopediaController@index' )->name( 'api.tokopedia.index' );
        Route::get( '/categories', 'TokopediaController@categories' )->name( 'api.tokopedia.categories' );
        Route::get( '/category', 'TokopediaController@category' )->name( 'api.tokopedia.categories.slug' );
        Route::get( '/product', 'TokopediaController@product' )->name( 'api.tokopedia.products.slug' );
        Route::get( '/seller', 'TokopediaController@seller' )->name( 'api.tokopedia.sellers.slug' );
    } );
    
    
    Route::prefix( 'shopee' )->group( function () {
        Route::get( '/search', 'ShopeeController@search' )->name( 'api.shopee.search' );
        Route::get( '/{item_id}/{shop_id}', 'ShopeeController@read' )->name( 'api.shopee.read' );
    } );
    
    Route::namespace( 'V1' )->prefix( 'v1' )->group( function () {
        
        Route::prefix( 'tokopedia' )->group( function () {
            Route::get( '/search', 'TokopediaController@search' )->name( 'api.v1.tokopedia.search' );
        } );
    
        Route::prefix( 'bukalapak' )->group( function () {
            Route::get( '/categories', 'BukalapakController@getCategory' )->name( 'api.v1.bukalapak.categories' );
            Route::get( '/categories/{category_id}', 'BukalapakController@getProductByCategory' )->name( 'api.v1.bukalapak.get.product.by.category' );
        });
        
    } );
} );
