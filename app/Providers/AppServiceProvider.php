<?php

namespace Chunker\Reviews\Providers;

use Chunker\Base\Packages\Package;
use Chunker\Base\Providers\Traits\Migrator;
use Chunker\Reviews\Models\Review;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
	use Migrator;

	/** Корневая папка пакета */
	const ROOT = __DIR__ . '/../..';


	public function boot(Package $package) {
		/** Конфигурация пакета */
		$package
			->setName('reviews')
			->registerAbilities([
				'reviews.edit' => 'Редактирование отзывов',
				'reviews.view' => 'Просмотр отзывов',
			])
			->registerAbilitiesViews([
				'reviews::abilities.reviews',
			])
			->registerMenuItems([
				'reviews' => [
					'name'   => 'Отзывы',
					'icon'   => 'comments',
					'route'  => 'admin.reviews',
					'policy' => 'reviews.view'
				]
			])
			->registerActivityElements([
				Review::class => 'reviews::entities.review'
			]);

		/** Регистрация пакета */
		$this
			->app[ 'Packages' ]
			->register($package);


		/** Объявление пространства имён представлений пакета */
		$this->loadViewsFrom(static::ROOT . '/resources/views', 'reviews');

		/** Публикация необходимых файлов */
		$this->publish(static::ROOT . '/publishes/');

		// Маршруты пакета
		require_once static::ROOT . '/app/Http/routes.php';

	}


	public function register() {

	}
}