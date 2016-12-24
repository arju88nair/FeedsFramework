<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//  API routes

Route::post('login', 'userController@addUser');

Route::post('getFeedIds', 'feedController@getFeedIds');

Route::post('getFeeds', 'feedController@getFeeds');

Route::post('like', 'userController@like');

Route::post('unlike', 'userController@unlike');

Route::post('feedCount', 'userController@feedCount');

Route::post('like', 'userController@like');

Route::post('unlike', 'userController@unlike');

Route::post('addCategories', 'userController@addCategories');

Route::post('postComments', 'userController@comments');

