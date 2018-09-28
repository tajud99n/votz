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
    
    # Super Admin  
    
    Route::group(['middleware' => 'admin'], function () {
        // Site settings
        Route::get('/settings', [
            'uses' => 'SettingsController@index',
            'as' => 'settings'
        ]);
        Route::post('/settings/update', [
            'uses' => 'SettingsController@update',
            'as' => 'settings.update'
        ]);

        // Category routes
        Route::get('/categories', [
            'uses' => 'CategoriesController@index',
            'as' => 'categories'
        ]);
        Route::get('/category/create', [
            'uses' => 'CategoriesController@create',
            'as' => 'category.create'
        ]);
        Route::post('/category/store', [
            'uses' => 'CategoriesController@store',
            'as' => 'category.store'
        ]);
        Route::get('/category/edit/{id}', [
            'uses' => 'CategoriesController@edit',
            'as' => 'category.edit'
        ]);
        Route::post('/categories/update/{id}', [
            'uses' => 'CategoriesController@update',
            'as' => 'category.update'
        ]);
        Route::get('/categories/delete/{id}', [
            'uses' => 'CategoriesController@destroy',
            'as' => 'category.delete'
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
        Route::get('/polls/suspend', [
            'uses'  => 'PollsController@suspend',
            'as'    => 'poll.suspend'
        ]);
        Route::get('/polls/restore/{id}', [
            'uses' => 'PollsController@restore',
            'as'   => 'poll.restore'
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
    Route::get('/post/create', [
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
    Route::get('/poll/update/{slug}', [
        'uses'  => 'PollsController@update',
        'as'    => 'poll.update'
    ]);
    Route::get('/poll/delete/{slug}', [
        'uses'  => 'PollsController@destroy',
        'as'    => 'poll.delete'
    ]);

    # Vote routes
    Route::post('/poll/vote', [
        'uses'  => 'VotesController@vote',
        'as'    => 'poll.vote'
    ]);
});
