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

Route::group(["prefix" => "requester"], function(){
    Route::get ('tickets/{token}'                  , 'RequesterTicketsController@show')     ->name('requester.tickets.show');
    Route::post('tickets/{token}/comments'        , 'RequesterCommentsController@store')    ->name('requester.comments.store');
});

Route::group(["middlware" => "auth"], function(){
    Route::get ('tickets'                           , 'TicketsController@index')            ->name('tickets.index');
    Route::get ('tickets/{ticket}'                  , 'TicketsController@show')             ->name('tickets.show');
    Route::post('tickets/{ticket}/assign'           , 'TicketsAssignController@store')      ->name('tickets.assign');
    Route::post('tickets/{ticket}/comments'         , 'CommentsController@store')           ->name('comments.store');
    Route::resource('tickets/{ticket}/tags'         , 'TicketsTagsController', ["only" => ["store", "destroy"], "as" => "tickets"]);

    Route::resource('teams'                      ,'TeamsController');
    Route::get ('teams/{token}/join', 'TeamMembershipController@index')->name('membership.index');
    Route::post('teams/{token}/join', 'TeamMembershipController@store')->name('membership.store');
});

