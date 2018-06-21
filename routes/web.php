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

Route::get('/test', ['uses' => 'TestController@test', 'as' => 'test']);
Route::get('/testRedirect', ['uses' => 'TestController@testRedirect', 'as' => 'testRedirect']);
Route::get('/testConnection', ['uses' => 'TestController@testConnection', 'as' => 'testConnection']);