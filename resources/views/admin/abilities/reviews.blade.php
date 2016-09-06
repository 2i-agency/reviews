<div class="form-group">
	<label>Отзывы:</label>
	<div class="btn-group w100percent" data-toggle="buttons">

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'reviews',
			'icon'          => 'ban',
			'is_checked'    => !$role->hasAccess('reviews'),
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'reviews.view',
			'icon'          => 'eye',
			'is_checked'    => $role->hasAbility('reviews.view'),
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'reviews.edit',
			'icon'          => 'pencil',
			'is_checked'    => $role->hasAbility('reviews.edit'),
		])

	</div>
</div>