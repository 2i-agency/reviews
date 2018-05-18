<?php

namespace Chunker\Reviews\Models;

use Chunker\Base\Models\Traits\MediaConversions;
use Chunker\Base\Models\Traits\Publicable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Review extends Model implements HasMediaConversions
{
	use Publicable, HasMediaTrait, MediaConversions;

	protected $table = 'reviews_reviews';

	protected $fillable = [
		'name',
		'message',
		'published_at'
	];

	protected $dates = [
		'published_at'
	];

	/** @var string Переменная для указания списка конверсий */
	protected $conversions_config = 'chunker.reviews.conversions';

	public $timestamps = false;

}
