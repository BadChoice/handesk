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

Auth::routes();

Route::group(["middlware" => "auth"], function(){
    Route::get('/home'                              , 'HomeController@index')->name('home');
    Route::get('/tickets/{ticket}'                  , 'TicketsController@show')->name('tickets.show');
    Route::post('/tickets/{ticket}/comments'        , 'CommentsController@store')->name('comments.store');
});

