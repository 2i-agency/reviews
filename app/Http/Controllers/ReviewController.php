<?php

namespace Chunker\Reviews\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Chunker\Reviews\Models\Review;
use Illuminate\Http\Request;
use \Validator;

class ReviewController extends Controller
{
	/*
	 * Отображение
	 */
	function index() {
		$this->authorize('reviews.view');
		$reviews = Review::OrderBy('published_at')->get();

		return view('reviews::reviews', compact('reviews'));
	}


	/*
	 * Добавление
	 */
	function store(Request $request) {
		$this->authorize('reviews.edit');
		$data = $request->all();

		Review::create($data);

		flash()->success('Отзыв добавлен');

		return back();
	}


	/*
	 * Обновление списка
	 */
	function save(Request $request) {
		$this->authorize('reviews.edit');
		$reviews = $request->get('reviews');

		foreach ($reviews as $id => $data) {

			Review::find($id)->update($data);

		}

		flash()->success('Отзывы сохранены');

		return back();
	}
}