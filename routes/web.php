<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function() {
	// route untuk system crud quote
	Route::resource('/quotes', 'QuoteController', ['except' => ['index', 'show']]);
	// route untuk system comments pada sebuah quote
	Route::post('/quotes-comment/{id}', 'QuoteCommentController@store');
	Route::put('/quotes-comment/{id}', 'QuoteCommentController@update');
	Route::get('/quotes-comment/{id}/edit', 'QuoteCommentController@edit');
	Route::delete('/quotes-comment/{id}', 'QuoteCommentController@destroy');
	//route fungsi system like pada quotes & comments
	Route::get('/like/{type}/{model}', 'LikeController@like');
	Route::get('/unlike/{type}/{model}', 'LikeController@unlike');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/quotes/random', 'QuoteController@randomQuote'); // route untuk fungsi acak quote
Route::get('/quotes/filter/{tag}', 'QuoteController@filter'); // route untuk fungsi filter quote berdasarkan tag
Route::get('/profile/{id?}', 'HomeController@profile'); // quote untuk profile masing2 user
Route::resource('/quotes', 'QuoteController', ['only' => ['index', 'show']]); // untuk route quote
