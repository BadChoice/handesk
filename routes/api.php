<?php

Route::post('agent/login', 'Api\AgentController@login');
Route::group(['namespace' => 'Api', 'prefix' => 'agent', 'middleware' => 'apiAuthAgent'], function () {
    Route::resource('tickets', 'AgentController', ['only' => 'index']);
    Route::resource('tickets.comments', 'AgentTicketCommentsController', ['only' => ['index', 'store']]);
});

/**
 * Login Route
 */
Route::post('v1/login', 'Api\Auth\AuthController@login');

/**
 * Private Route
 */
Route::group(['namespace' => 'Api', 'prefix' => 'v1', 'middleware' => 'auth:api'], function(){
    // user detail
    Route::get('me', 'Auth\AuthController@me');

    // list ticket
    Route::get('ticket/all', 'AgentTicketCommentsController@ticketAll');
    Route::get('ticket/detail/{id}', 'AgentTicketCommentsController@detail');
    Route::post('ticket/start-task/{id}', 'AgentTicketCommentsController@startTask');
    Route::post('ticket/{id}/comments', 'AgentTicketCommentsController@report');


    /**
     * Original Handesk Route
     */
    Route::resource('tickets', 'TicketsController', ['except' => 'destroy']);
    Route::post('tickets/{ticket}/comments', 'CommentsController@store');
    Route::post('tickets/{ticket}/assign', 'TicketAssignController@store');
    Route::get('users', 'UsersController@index');
    Route::post('users/create', 'UsersController@store');
    Route::post('teams', 'TeamController@store');
    Route::get('teams/{team}/tickets', 'TeamTicketsController@index');
    Route::get('teams/{team}/leads', 'TeamLeadsController@index');

    Route::resource('leads', 'LeadsController', ['only' => 'store']);
    Route::resource('ideas', 'IdeasController', ['only' => ['store', 'index']]);
});
