{{--Переключатели возможностей для статей--}}
<div class="form-group">
	<label>Отзывы:</label>
	<select
		class="form-control"
		name="abilities[reviews]"
		{{ $disabled ? ' disabled' : NULL }}
	>

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'reviews',
			'is_selected'    => !$agent->hasAccess('reviews'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'reviews.view',
			'is_selected'    => $agent->checkAbility('reviews.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'reviews.edit',
			'is_selected'    => $agent->checkAbility('reviews.edit'),
		])

	</select>
</div>