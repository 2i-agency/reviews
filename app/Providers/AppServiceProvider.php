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

		// Публикация файлов для пакета Structure
		$this->publishes([

			// admin
			static::ROOT . '/assets/admin/ReviewController.php' =>
				app_path('Http/Controllers/Admin/Structure/ReviewController.php'),

			static::ROOT . '/assets/admin/routes.php' =>
				app_path('Http/routes/admin/reviews.php'),

			//site
			static::ROOT . '/assets/site/ReviewController.php' =>
				app_path('Http/Controllers/Site/ReviewController.php'),

			static::ROOT . '/assets/site/reviews.blade.php' =>
				resource_path('views/site/reviews.blade.php'),

			static::ROOT . '/assets/site/routes.php' =>
				app_path('Http/routes/site/reviews.php')

		], 'app');

	}


	public function register() {

	}
}