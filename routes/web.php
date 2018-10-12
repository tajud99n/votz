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

Route::get('/{provider}/auth', [
    'uses'  => 'Auth\LoginController@redirectToProvider',
    'as'    => 'social.auth'
]);

Route::get('/{provider}/redirect', [
    'uses'  => 'Auth\LoginController@handleProviderCallback',
    'as'    => 'social.redirect'
]);

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/results', function () {
        $query = request('query');

        $polls = \App\Poll::where('title', 'like', '%' . $query . '%')->where('voting_status', 'in-progress')->paginate(5);

        return view('results', compact(['polls', 'query']));
    });
    
    # Super Admin  
    
    Route::group(['middleware' => 'admin'], function () {
        // Site settings
        Route::get('/settings', [
            'uses' => 'SettingController@index',
            'as' => 'settings'
        ]);
        Route::post('/settings/update', [
            'uses' => 'SettingController@update',
            'as' => 'settings.update'
        ]);

        // Category routes
        Route::get('/categories', [
            'uses' => 'CategoriesController@index',
            'as'   => 'categories'
        ]);
        Route::get('/category/create', [
            'uses' => 'CategoriesController@create',
            'as'   => 'category.create'
        ]);
        Route::post('/category/store', [
            'uses' => 'CategoriesController@store',
            'as'   => 'category.store'
        ]);
        Route::get('/category/show/{id}', [
            'uses'  => 'CategoriesController@show',
            'as'    => 'category.show'
        ]);
        Route::get('/category/edit/{id}', [
            'uses' => 'CategoriesController@edit',
            'as'   => 'category.edit'
        ]);
        Route::post('/categories/update/{id}', [
            'uses' => 'CategoriesController@update',
            'as'   => 'category.update'
        ]);
        Route::get('/categories/delete/{id}', [
            'uses' => 'CategoriesController@destroy',
            'as'   => 'category.delete'
        ]);

        // Users routes
        Route::get('/users', [
            'uses'  => 'UsersController@index',
            'as'    => 'users'
        ]);
        Route::get('/users/suspend', [
            'uses'  => 'UsersController@suspend',
            'as'    => 'user.suspend'
        ]);
        Route::get('/users/restore/{id}', [
            'uses'  => 'UsersController@restore',
            'as'    => 'user.restore'
        ]);

        // Poll routes
        Route::get('/polls', [
            'uses'  => 'PollsController@index',
            'as'    => 'polls'
        ]);
        Route::get('/polls/trashed', [
            'uses'  => 'PollsController@trashed',
            'as'    => 'polls.trashed'
        ]);
        Route::get('/polls/restore/{id}', [
            'uses' => 'PollsController@restore',
            'as'   => 'poll.restore'
        ]);
        Route::get('/poll/kill/{id}', [
            'uses' => 'PollsController@kill',
            'as' => 'poll.kill'
        ]);

    });

    # Profile route
    Route::get('/user/profile', [
        'uses'  => 'ProfileController@index',
        'as'    => 'user.profile'
    ]);
    Route::post('/user/profile/update', [
        'uses'  => 'ProfileController@update',
        'as'    => 'user.profile.update'
    ]);

    # Polls routes
    Route::get('/poll/create', [
        'uses'  => 'PollsController@create',
        'as'    => 'poll.create'
    ]);
    Route::post('/poll/store', [
        'uses'  => 'PollsController@store',
        'as'    => 'poll.store'
    ]);
    Route::get('/poll/show/{slug}', [
        'uses'  => 'PollsController@show',
        'as'    => 'poll.show'
    ]);
    Route::get('/poll/edit/{slug}', [
        'uses'  => 'PollsController@edit',
        'as'    => 'poll.edit'
    ]);
    Route::post('/poll/update/{slug}', [
        'uses'  => 'PollsController@update',
        'as'    => 'poll.update'
    ]);
    Route::get('/poll/delete/{slug}', [
        'uses'  => 'PollsController@destroy',
        'as'    => 'poll.delete'
    ]);
    Route::get('/poll/report/{poll}', [
        'uses'  => 'DashboardController@report',
        'as'    => 'poll.report'
    ]);
    Route::get('/poll/status/{status}', [
        'uses'  => 'PollsController@status',
        'as'    => 'poll.status'
    ]);
    Route::get('/polls/publish/{publish}', [
        'uses' => 'PollsController@publish',
        'as' => 'poll.publish'
    ]);

    # Dashboard routes
    Route::get('/poll/mypolls', [
        'uses'  => 'DashboardController@my_polls',
        'as'    => 'poll.mypolls'
    ]);
    Route::get('/poll/participated', [
        'uses'  => 'DashboardController@participated',
        'as'    => 'poll.participated'
    ]);
    Route::get('/poll/lastest', [
        'uses'  => 'DashboardController@latest',
        'as'    => 'poll.lastest'
    ]);
    Route::get('/poll/participate/{slug}', [
        'uses' => 'DashboardController@participate',
        'as' => 'poll.participate'
    ]);

    # Vote routes
    Route::get('/poll/vote/{vote}', [
        'uses'  => 'VotesController@vote',
        'as'    => 'poll.vote'
    ]);
});
