<?php

Route::group(['namespace' => 'Api'], function () {
    Route::resource('tickets', 'TicketsController', ['except' => 'destroy']);
    Route::post('tickets/{ticket}/comments', 'CommentsController@store');
    Route::post('tickets/{ticket}/assign', 'TicketAssignController@store');
    Route::post('teams', 'TeamController@store');
    Route::get('teams/{team}/tickets', 'TeamTicketsController@index');

    Route::resource('leads', 'LeadsController', ['only' => 'store']);

    Route::resource('ideas', 'IdeasController', ['only' => ['store', 'index']]);
});
