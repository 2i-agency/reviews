<?php

// Маршрут для отображения отзывов
Route::get('reviews', [
	'uses' => 'ReviewController@reviews',
	'as'   => 'site.reviews'
]);