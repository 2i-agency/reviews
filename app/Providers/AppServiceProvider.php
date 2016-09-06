<?php

namespace Chunker\Reviews\Providers;

use Chunker\Base\Packages\Package;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
	// Корневая папка пакета
	const ROOT = __DIR__ . '/../..';


	public function boot(Package $package) {

		// Конфигурация пакета
		$package
			->setName('reviews')
			->registerAbilities([

				'reviews.edit' => 'Редактирование отзывов',
				'reviews.view' => 'Просмотр отзывов',

			])
			->registerAbilitiesViews([

				'chunker.reviews::admin.abilities.reviews'

			]);


		// Регистрация пакета
		$this
			->app['Packages']
			->register($package);


		// Шаблоны пакета
		$this->loadViewsFrom(static::ROOT . '/resources/views', 'chunker.reviews');

		// Публикация миграций
		$this->publishes([static::ROOT . '/database/migrations' => database_path('migrations')], 'database');

		// Маршруты пакета
		require_once static::ROOT . '/app/Http/routes/admin.php';

	}


	public function register() {

	}
}