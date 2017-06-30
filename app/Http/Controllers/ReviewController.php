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
		$this->validate($request, $this->rules, $this->validateMessages);
		Review::create($request->all());

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
			$rules = [
				'name'    => 'required|max:150|unique:reviews_reviews,name,' . $id,
				'message' => 'required'
			];

			$validate_messages = [
				'name.require'    => 'Необходимо указать имя',
				'name.unique'     => 'Имя <b>' . $data[ 'name' ] . '</b> уже существует',
				'name.max'        => 'Превышено количество символов',
				'message.require' => 'Необходимо указать текст сообщения',
			];

			$validate = Validator::make($data, $rules, $validate_messages);

			if ($validate->fails()) {
				return redirect()->back()->withErrors($validate->errors());
			}

			Review::find($id)->update($data);

		}

		flash()->success('Отзывы сохранены');

		return back();
	}
}