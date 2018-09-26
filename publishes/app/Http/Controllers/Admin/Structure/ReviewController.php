<?php

namespace App\Http\Controllers\Admin\Structure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
	/*
	 * Часть формы элемента структуры сайта
	 */
	public function index(Request $request) {
		return [
			'markup'    => '',
			'disabled'  => false
		];
	}
}