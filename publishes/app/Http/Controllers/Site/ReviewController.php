<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Chunker\Base\Models\Language;
use Chunker\Reviews\Models\Review;

class ReviewController extends Controller
{
	/*
	 *  Отзывы
	 */
	public function reviews(Language $language) {
		$reviews = Review::where('published_at', '<>', '')->get();
		return view('site.reviews', compact('reviews'));
	}
}