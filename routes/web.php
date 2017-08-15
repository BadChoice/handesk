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
    return redirect()->route('login');
});

Auth::routes();

Route::group(["prefix" => "requester"], function(){
    Route::get ('tickets/{token}'                   ,'RequesterTicketsController@show')     ->name('requester.tickets.show');
    Route::post('tickets/{token}/comments'          ,'RequesterCommentsController@store')    ->name('requester.comments.store');
});

Route::group(["middleware" => "auth"], function(){
    Route::get      ('profile'                      ,'ProfileController@show')             ->name('profile.show');
    Route::put      ('profile'                      ,'ProfileController@update')           ->name('profile.update');
    Route::post     ('password'                     ,'ProfileController@password')         ->name('profile.password');

    Route::resource ('tickets'                      ,'TicketsController', ["except" => ["edit", "destroy"]]);
    Route::post     ('tickets/{ticket}/assign'      ,'TicketsAssignController@store')      ->name('tickets.assign');
    Route::post     ('tickets/{ticket}/comments'    ,'CommentsController@store')           ->name('comments.store');
    Route::resource('tickets/{ticket}/tags'         ,'TicketsTagsController', ["only" => ["store", "destroy"], "as" => "tickets"]);

    Route::resource ('leads'                        ,'LeadsController');
    Route::post     ('leads/{lead}/assign'          ,'LeadAssignController@store')      ->name('leads.assign');
    Route::post     ('leads/{lead}/status'          ,'LeadStatusController@store')      ->name('leads.status.store');
    Route::resource ('leads/{lead}/tags'            ,'LeadTagsController', ["only" => ["store", "destroy"], "as" => "leads"]);

    Route::resource('teams'                         ,'TeamsController');
    Route::get ('teams/{token}/join', 'TeamMembershipController@index')->name('membership.index');
    Route::post('teams/{token}/join', 'TeamMembershipController@store')->name('membership.store');

    Route::resource('users'                         ,'UsersController', ["only" => "index"]);

    Route::get('reports',               'ReportsController@index')->name('reports.index');
});

