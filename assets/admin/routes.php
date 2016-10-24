<?php

// Маршрут для отзывово
Route::get('review/structure', [
	'uses'  => 'Structure\ReviewController@index',
	'as'    => 'admin.review.structure'
]);