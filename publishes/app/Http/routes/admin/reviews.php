<?php

/*
 * Маршрут для представления части формы элемента структуры сайта
 */
Route::get('reviews/structure', [
	'uses'  => 'Structure\ReviewsController@reviews',
	'as'    => 'admin.reviews.structure'
]);