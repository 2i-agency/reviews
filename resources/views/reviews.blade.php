@extends('base::template')

@section('page.title', 'Отзывы')

@section('page.content')

	<h3>Отзывы</h3>
	@can('reviews.edit')

		{{--Форма добавления элемента--}}
		<form method="POST" action="{{ route('admin.reviews.store') }}" class="panel panel-default">
			{!! csrf_field() !!}
			{!! method_field('PUT') !!}

			<div class="panel-heading">
				<h4 class="panel-title">Новый отзыв</h4>
			</div>

			<div class="panel-body row">

				<div class="col-xs-1">
					<input
						type="text"
						name="name"
						value="{{ old('name') }}"
						autofocus
						required
						autocomplete="off"
						placeholder="Имя"
						class="form-control"
					>
				</div>

				<div class="col-xs-7">
					<input
						type="text"
						name="message"
						value="{{ old('message') }}"
						required
						autocomplete="off"
						placeholder="Текст сообщения"
						class="form-control"
					>
				</div>

				{{--Время публикации--}}
				<div class="col-xs-2">
					@include('base::utils.inputs.timepicker', [
						'name' => 'published_at',
						'value' => is_array(old('published_at')) ? NULL : old('published_at')
					])
				</div>

				<div class="col-xs-2 text-right">
					<button type="submit" class="btn btn-block btn-primary">
						<span class="glyphicon glyphicon-plus"></span>
						Добавить
					</button>
				</div>

			</div>

		</form>

	@endcan

	@if($reviews->count())

		{{--Список--}}
		<form method="POST" action="{{ route('admin.reviews.save') }}" class="panel panel-default">
			{!! method_field('PUT') !!}

			<table class="table table-hover">

				{{--Отключение позиционирование при отсутствии прав на редактирование--}}
				<tbody>

				@foreach ($reviews as $review)

					<tr data-id="{{ $review->id }}">

						@can('reviews.edit')
							<td>
								<input
									type="text"
									name="reviews[{{ $review->id }}][name]"
									value="{{ old('names.' . $review->id) ?: $review->name }}"
									required
									autocomplete="off"
									placeholder="Имя"
									class="form-control"
								>
							</td>

							<td>
								<input
									type="text"
									name="reviews[{{ $review->id }}][message]"
									value="{{ old('messages.' . $review->id) ?: $review->message }}"
									required
									autocomplete="off"
									placeholder="Текст сообщения"
									class="form-control"
								>
							</td>

							<td>
								@php
									if(is_array(old('published_at'))){
										$published_at_value = old('published_at')[$review->id];
									} elseif(old('published_at') !== NULL) {
										$published_at_value = old('published_at');
									} else {
										$published_at_value = isset($review->published_at) ? $review->published_at : NULL;
									}
								@endphp

								@include('base::utils.inputs.timepicker', [
									'name' => 'reviews[' . $review->id . '][published_at]',
									'value' => $published_at_value
								])
							</td>
						@else
							<td>{{ old('names.' . $review->id) ?: $review->name }}</td>
							<td>{{ old('message.' . $review->id) ?: $review->message }}</td>
							<td>{{ old('published_at.' . $review->id) ?: $review->published_at }}</td>
						@endcan

					</tr>
				@endforeach

				</tbody>

			</table>


			@can('reviews.edit')
				<div class="panel-footer">
					<div class="form-group">
						@include('base::utils.buttons.save')
					</div>
				</div>
			@endcan
		</form>

	@else

		@include('base::utils.alert', ['message' => 'Отзывы отсутствуют'])

	@endif


@stop