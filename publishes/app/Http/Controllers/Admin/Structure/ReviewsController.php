<?php

namespace App\Http\Controllers\Admin\Structure;

use App\Http\Controllers\Controller;
use Chunker\Articles\Models\Article;
use Chunker\Articles\Models\Category;
use Chunker\Structure\Models\Element;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
	public function reviews() {
		return [
			'markup'   => '',
			'disabled' => false
		];
	}
}