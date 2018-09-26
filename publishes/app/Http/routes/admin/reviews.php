<?php

/*
 * Маршрут для представления части формы элемента структуры сайта
 */
Route::get('reviews/structure', [
	'uses'  => 'Structure\ReviewController@reviews',
	'as'    => 'admin.reviews.structure'
]);