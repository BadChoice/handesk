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

Route::get('/', 'HomeController@index');

Auth::routes();
Route::get('/azure/login', 'Auth\LoginController@redirectToAzureProvider')->name('azure.sign.in');
Route::get('/login/microsoft/callback', 'Auth\LoginController@handleAzureProviderCallback');

Route::group(['prefix' => 'requester'], function () {
    Route::get('tickets/{token}', 'RequesterTicketsController@show')->name('requester.tickets.show');
    Route::post('tickets/{token}/comments', 'RequesterCommentsController@store')->name('requester.comments.store');
    Route::get('tickets/{token}/rate', 'RequesterTicketsController@rate')->name('requester.tickets.rate');
});

Route::post('webhook/bitbucket', 'WebhookController@store');

Route::group(['middleware' => ['auth', 'userLocale']], function () {
    Route::get('profile', 'ProfileController@show')->name('profile.show');
    Route::put('profile', 'ProfileController@update')->name('profile.update');
    Route::post('password', 'ProfileController@password')->name('profile.password');

    Route::get('tickets/merge', 'TicketsMergeController@index')->name('tickets.merge.index');
    //Route::post('tickets/merge', 'TicketsMergeController@store')->name('tickets.merge.store');
    Route::get('tickets/search/{text}', 'TicketsSearchController@index')->name('tickets.search');
    Route::resource('tickets', 'TicketsController', ['except' => ['edit', 'destroy']]);
    Route::post('tickets/{ticket}/assign', 'TicketsAssignController@store')->name('tickets.assign');
    Route::post('tickets/{ticket}/comments', 'CommentsController@store')->name('comments.store');
    Route::resource('tickets/{ticket}/tags', 'TicketsTagsController', ['only' => ['store', 'destroy'], 'as' => 'tickets']);
    Route::post('tickets/{ticket}/reopen', 'TicketsController@reopen')->name('tickets.reopen');
    Route::get('tickets/{ticket}/update-time-tracker', 'TicketsController@updateTimeTracker')->name('tickets.time.tracker.update');

    Route::post('tickets/{ticket}/escalate', 'TicketsEscalateController@store')->name('tickets.escalate.store');
    Route::delete('tickets/{ticket}/escalate', 'TicketsEscalateController@destroy')->name('tickets.escalate.destroy');

    Route::post('tickets/{ticket}/issue', 'TicketsIssueController@store')->name('tickets.issue.store');
    Route::post('tickets/{ticket}/idea', 'TicketsIdeaController@store')->name('tickets.idea.store');

    Route::resource('leads', 'LeadsController');
    Route::get('leads/search/{text}', 'LeadsSearchController@index')->name('leads.search');
    Route::post('leads/{lead}/assign', 'LeadAssignController@store')->name('leads.assign');
    Route::post('leads/{lead}/status', 'LeadStatusController@store')->name('leads.status.store');
    Route::resource('leads/{lead}/tags', 'LeadTagsController', ['only' => ['store', 'destroy'], 'as' => 'leads']);
    Route::resource('leads/{lead}/tasks', 'LeadTasksController', ['only' => ['index', 'store', 'update', 'destroy'], 'as' => 'leads']);

    Route::resource('tasks', 'TasksController', ['only' => ['index', 'update', 'destroy']]);

    Route::resource('teams', 'TeamsController');
    Route::get('teams/{team}/agents', 'TeamAgentsController@index')->name('teams.agents');
    Route::get('teams/{token}/join', 'TeamMembershipController@index')->name('membership.index');
    Route::post('teams/{token}/join', 'TeamMembershipController@store')->name('membership.store');

    Route::group(['middleware' => 'can:see-admin'], function () {
        Route::resource('ideas', 'IdeasController');
        Route::get('roadmap', 'RoadmapController@index')->name('roadmap.index');
        Route::resource('ideas/{idea}/tags', 'IdeaTagsController', ['only' => ['store', 'destroy'], 'as' => 'ideas']);
        Route::post('ideas/{idea}/issue', 'IdeaIssueController@store')->name('ideas.issue.store');

        Route::resource('users', 'UsersController', ['only' => ['index', 'destroy']]);
        Route::get('users/{user}/impersonate', 'UsersController@impersonate')->name('users.impersonate');
        Route::resource('settings', 'SettingsController', ['only' => ['edit', 'update']]);

        Route::resource('types', 'TypesController');
    });

    Route::get('reports', 'ReportsController@index')->name('reports.index');
    Route::post('thrust/{resourceName}/actions', 'ThrustActionsController@perform')->name('thrust.actions.perform');
    Route::get('thrust/{resourceName}/{id}/toggle/{field}', 'ThrustActionsController@toggle')->name('thrust.toggle');
});