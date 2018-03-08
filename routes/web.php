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
    return view('layouts.app');
});

Route::resource('products', 'Product\ProductController', ['only' => [
    'index', 'show'
]]);

Route::get('analytics/traffic', 'TrackerController@visitors')
    ->name('analytics.traffic');

Route::get('analytics/traffic/{id}', 'TrackerController@visitorsBySessionId')
    ->name('analytics.traffic.id');

