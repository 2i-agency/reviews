<?php

Route::group([
	'prefix' => 'admin/reviews',
	'namespace' => 'Chunker\Reviews\Http\Controllers',
	'middleware' => ['admin']
], function () {

	Route::get('/', [
		'as' => 'admin.reviews',
		'uses' => 'ReviewController@index'
	]);

	Route::put('store', [
		'as' => 'admin.reviews.store',
		'uses' => 'ReviewController@store'
	]);

	Route::put('save', [
		'as' => 'admin.reviews.save',
		'uses' => 'ReviewController@save'
	]);

	Route::delete('destroy/{id}', [
		'as' => 'admin.reviews.destroy',
		'uses' => 'ReviewController@destroy'
	]);

});