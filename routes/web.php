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
})->middleware(['verify.shopify','billable'])->name('home');


Route::get('/insert-pixel', 'PixelController@insert_pixel')->middleware(['verify.shopify']);

Route::get('/pixel-list', 'PixelController@get_pixels');

Route::get('/remove-pixel', 'PixelController@delete_pixel')->middleware(['verify.shopify']);

Route::get('/remove-pixels', 'PixelController@delete_pixels')->middleware(['verify.shopify']);

Route::get('/event-list', 'EventController@get_events')->middleware(['verify.shopify']);

Route::get('/edit-event/{id}', 'EventController@edit_status')->middleware(['verify.shopify']);

Route::get('/insert-product', 'PixelProductController@insert_products')->middleware(['verify.shopify']);

Route::get('/insert-content-view', 'ThemeController@insert_content_view_script')->middleware(['verify.shopify']);

Route::get('/addasset', 'ThemeController@addassetfile')->middleware(['verify.shopify']);

Route::get('/product-detail', 'ThemeController@get_product_deatils');

Route::get('/event-stats', 'HomeController@get_stats');






