<?php

namespace Chunker\Reviews\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Chunker\HousesProjects\Models\Type;
use Chunker\Reviews\Models\Review;
use Illuminate\Http\Request;
use \Validator;

class ReviewController extends Controller
{
	
	// Правило валидации
	protected $rules = [
		'name'       => 'required|max:150|unique:reviews_reviews,name',
		'message'    => 'required',
	];

	// Сообщения об ошибках
	protected $validateMessages = [
		'name.require'       => 'Необходимо указать имя',
		'name.unique'        => 'Такое имя уже существует',
		'name.max'           => 'Превышено количество символов',
		'message.require'    => 'Необходимо указать текст сообщения',
	];

	// Сообщения для flash()
	protected $flashMessages = [
		'store' => 'Отзыв добавлен',
		'save'  => 'Отзывы сохранены'
	];
	
	// Класс модели
	protected $model = Review::class;

	// Абилки
	protected $abilities = [
		'view' => 'reviews.view',
		'edit' => 'reviews.edit'
	];
	
	// Вьюха
	protected $view = 'chunker.reviews::admin.directories.reviews';

	/*
	 * Отображение
	 */
	function index() {
		$this->authorize($this->abilities['view']);

		$model = $this->model;

		return view($this->view, [
			'directory' => $model::OrderBy('published_at')->get(),
			'title' => 'Отзывы',
			'title_new' => 'Новый отзыв',
			'ability_edit' => 'reviews.edit',
			'route' => [
				'store'       => 'admin.reviews.store',
				'save'        => 'admin.reviews.save',
			],
			'empty' => 'Отзывы отсутствуют',
		]);
	}


	/*
	 * Добавление
	 */
	function store(Request $request) {
		$this->authorize($this->abilities['edit']);
		$this->validate($request, $this->rules, $this->validateMessages);

		$model = $this->model;
		$model::create($request->all());

		flash()->success($this->flashMessages['store']);
		return back();
	}


	/*
	 * Обновление списка
	 */
	function save(Request $request) {
		$this->authorize($this->abilities['edit']);

		$model = $this->model;
		$names = $request->names;
		$messages = $request->messages;
		$published_at = $request->published_at;

		foreach ($names as $id => $name) {
			$rules = [
				'name'    => 'required|max:150|unique:reviews_reviews,name,' . $id,
				'message' => 'required'
			];

			$validate_messages = [
				'name.require'    => 'Необходимо указать имя',
				'name.unique'     => 'Имя <b>' . $name . '</b> уже существует',
				'name.max'        => 'Превышено количество символов',
				'message.require' => 'Необходимо указать текст сообщения',
			];

			$validate = Validator::make([
				'name'    => $name,
				'message' => $messages[$id]
			],
				$rules, $validate_messages);

			if ($validate->fails())
			{
				return redirect()->back()->withErrors($validate->errors());
			}

//			$this->validate($request, $rules, $validate_messages);

			$model::find($id)->update([
				'name'         => $name,
				'message'      => $messages[$id],
				'published_at' => isset($published_at[$id]) ? $published_at[$id] : ''
			]);

		}

		flash()->success($this->flashMessages['save']);
		return back();
	}
}