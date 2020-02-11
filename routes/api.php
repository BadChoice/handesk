<?php

Route::group(['namespace' => 'Api', 'middleware' => 'apiAuth'], function () {
    Route::resource('tickets', 'TicketsController', ['except' => 'destroy']);
    Route::post('tickets/{ticket}/comments', 'CommentsController@store');
    Route::post('tickets/{ticket}/assign', 'TicketAssignController@store');
    Route::post('users/create', 'UsersController@store');
    Route::post('teams', 'TeamController@store');
    Route::get('users', 'UsersController@index');
    Route::get('teams/{team}/tickets', 'TeamTicketsController@index');
    Route::get('teams/{team}/leads', 'TeamLeadsController@index');

    Route::resource('leads', 'LeadsController', ['only' => 'store']);

    Route::resource('ideas', 'IdeasController', ['only' => ['store', 'index']]);
});

Route::post('agent/login', 'Api\AgentController@login');
Route::group(['namespace' => 'Api', 'prefix' => 'agent', 'middleware' => 'apiAuthAgent'], function () {
    Route::resource('tickets', 'AgentController', ['only' => 'index']);
    Route::resource('tickets.comments', 'AgentTicketCommentsController', ['only' => ['index', 'store']]);
});
