<?php

Route::group(['namespace' => 'Api', 'middleware' => 'apiAuth'], function () {
    Route::resource('tickets', 'TicketsController', ['except' => 'destroy']);
    Route::post('tickets/{ticket}/comments', 'CommentsController@store');
    Route::post('tickets/{ticket}/assign', 'TicketAssignController@store');
    Route::get('ticket/{id}/rating', 'TicketsController@updateRating');
    Route::get('ticket/{id}/assign', 'TicketsController@assignTicket');
    Route::post('ticket/{id}/tracker', 'TicketsController@updateTracker');
    Route::get('user/fetch', 'UsersController@getUsers');
    Route::post('teams', 'TeamController@store');
    Route::get('teams/{team}/tickets', 'TeamTicketsController@index');
    Route::get('teams/{team}/leads', 'TeamLeadsController@index');
    Route::get('fetch/teams-and-types', 'TicketsController@fetchTypeAndStatus');
    Route::post('ticket/store', 'TicketsController@storeFromApp');
    Route::resource('leads', 'LeadsController', ['only' => 'store']);
    Route::resource('ideas', 'IdeasController', ['only' => ['store', 'index']]);
});