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
Route::group(["namespace" => "Api"], function(){
    Route::resource('tickets',                  "TicketsController", ["except" => "destroy"]);
    Route::post('tickets/{ticket}/comments',    "CommentsController@store");
    Route::post('tickets/{ticket}/assign',      "TicketAssignController@store");

    Route::resource('leads',                  "LeadsController", ["only" => "store"]);
});
