<?php
Route::view('/', 'welcome')->name('home');


// Statuses routes
Route::get('statuses', 'StatusesController@index')->name('statuses.index');
Route::post('statuses', 'StatusesController@store')->name('statuses.store')->middleware('auth');


// Statuses Likes routes
Route::post('statuses/{status}/likes', 'StatusLikesController@store')->name('statuses.likes.store')->middleware('auth');
Route::delete('statuses/{status}/likes', 'StatusLikesController@destroy')->name('statuses.likes.destroy')->middleware('auth');

// Statuses Comments routes
Route::post('statuses/{status}/comments', 'StatusCommentsController@store')->name('statuses.comments.store')->middleware('auth');



// Comments likes routes
Route::post('comments/{comment}/likes', 'CommentLikesController@store')->name('comments.likes.store')->middleware('auth');
Route::delete('comments/{comment}/likes', 'CommentLikesController@destroy')->name('comments.likes.destroy')->middleware('auth');

//Users routes
Route::get('@{user}', 'UsersController@show')->name('users.show');

//Users statuses routes
Route::get('users/{user}/statuses', 'UsersStatusController@index')->name('users.statuses.index');

//Friendships routes
Route::post('friendships/{recipient}', 'FriendshipsController@store')->name('friendships.store');

//Request Friendships routes

Route::post('request-friendships/{sender}', 'RequestFriendshipsController@store')->name('request-friendships.store');





Route::auth();




