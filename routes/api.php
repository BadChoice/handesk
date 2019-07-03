<?php
use App\Events\TicketNotificationEvent;
use GrahamCampbell\GitHub\Facades\GitHub;

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

Route::group(['namespace' => 'Azure', 'middleware' => 'azure.api', 'prefix'=>'azure'], function () {
    Route::resource('ticket', 'TicketController');
    Route::get('counter/ticket', 'TicketController@calculatingCounter');
});

Route::get('/socket', function () {
    $data = GitHub::connection('main')->issues()->comments()
    ->create('loveunCG', 'smartApp', 14, array('body' => 'The issue body'));
    // $data = GitHub::connection('main')->issues()->labels()
    // ->add('loveunCG', 'smartApp', 10, 'ToolBox');
    return response()->json($data);
    // event(new TicketNotificationEvent('c696c4fb-e742-4945-bc5b-c9bc257dbbdb'));
});
