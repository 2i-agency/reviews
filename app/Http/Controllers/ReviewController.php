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

		$review = Review::create($request->all());

		if (config('chunker.reviews.icon') && $request->hasFile('image')) {
			$file = $request->file('image');
			if ($file->isValid()) {
				$original_extension = $file->getClientOriginalExtension();

				$review
					->copyMedia($file)
					->setFileName('original.' . $original_extension)
					->toCollectionOnDisk();

			}
		}

		flash()->success('Отзыв добавлен');

		return back();
	}


	/*
	 * Обновление списка
	 */
	function save(Request $request) {
		$this->authorize('reviews.edit');
		$reviews = $request->get('reviews');
		$delete = $request->input('delete', []);
		$images = $request->file('imagesUpload');
		$delete_images = $request->input('imagesDelete');

		foreach ($reviews as $id => $data) {

			if (!in_array($id, $delete)) {
				/** @var Review $review */
				$review = Review::find($id);

				$review->update($data);

				if (
					config('chunker.reviews.icon') &&
					isset($images) &&
					key_exists($review->id, $images) &&
					$images[ $review->id ] &&
					$review->media()->count() ||
					is_array($delete_images) &&
					key_exists($review->id, $delete_images)
				) {
					$review->clearMediaCollection();
				}

				if (
					config('chunker.reviews.icon') &&
					isset($images) &&
					key_exists($review->id, $images) &&
					$images [ $review->id ]
				) {
					$file = $images[ $review->id ];
					$original_extension = $file->getClientOriginalExtension();

					$review
						->copyMedia($file)
						->setFileName('original.' . $original_extension)
						->toCollectionOnDisk();
				}
			}

		}

		Review::whereIn('id', $request->input('delete'))->delete();

		flash()->success('Отзывы сохранены');

		return back();
	}
}