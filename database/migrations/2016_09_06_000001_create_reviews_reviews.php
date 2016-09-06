<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Chunker\Base\Libs\Columns;

class CreateReviewsReviews extends Migration
{
	protected $table = 'reviews_reviews';

	public function up() {
		Schema::create($this->table, function (Blueprint $table) {

			$table->engine = 'MyISAM';
			$table->comment = 'Отзывы';

			// Ключ
			Columns::id($table);

			// Название
			$table
				->string('name', 150)
				->index()
				->comment('Имя');

			// Название
			$table
				->text('message')
				->comment('Сообщение');

			// Время публикации
			Columns::publishedAt($table);

			// Ключи редакторов
			Columns::editorsIds($table);
		});
	}


	public function down() {
		Schema::drop($this->table);
	}
}