<?php

namespace Chunker\Reviews\Models;

use Chunker\Base\Models\Traits\Publicable;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	use Publicable;

	protected $table = 'reviews_reviews';

	protected $fillable = [
		'name',
		'message',
		'published_at'
	];

	protected $dates = [
		'published_at'
	];

	public $timestamps = false;

}
