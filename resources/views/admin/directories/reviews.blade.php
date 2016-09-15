@extends('chunker.base::admin.template')

@section('page.title', 'Отзывы')

@section('page.content')

	<h3>{{ $title }}</h3>
	@can($ability_edit)

		{{--Форма добавления элемента--}}
		<form method="POST" action="{{ route($route['store']) }}" class="panel panel-default">
			{!! csrf_field() !!}
			{!! method_field('PUT') !!}

			<div class="panel-heading">
				<h4 class="panel-title">{{ $title_new }}</h4>
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
					@include('chunker.base::admin.utils.inputs.timepicker', [
						'name' => 'published_at',
						'value' => is_array(old('published_at')) ? null : old('published_at')
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

	@if($directory->count())

		{{--Список--}}
		<form method="POST" action="{{ route($route['save']) }}" class="panel panel-default">
			{!! method_field('PUT') !!}

				<table class="table table-hover">

					{{--Отключение позиционирование при отсутствии прав на редактирование--}}
					<tbody>

						@foreach ($directory as $item)

							<tr data-id="{{ $item->id }}">

								@can($ability_edit)
									<td>
										<input
											type="text"
											name="names[{{ $item->id }}]"
											value="{{ old('names.' . $item->id) ?: $item->name }}"
											required
											autocomplete="off"
											placeholder="Имя"
											class="form-control"
										>
									</td>

									<td>
										<input
											type="text"
											name="messages[{{ $item->id }}]"
											value="{{ old('messages.' . $item->id) ?: $item->message }}"
											required
											autocomplete="off"
											placeholder="Текст сообщения"
											class="form-control"
										>
									</td>

									<td>
										@include('chunker.base::admin.utils.inputs.timepicker', [
											'name' => 'published_at[' . $item->id . ']',
											'value' => old('published_at')[$item->id] ?: (isset($item->published_at) ? $item->published_at : NULL)
										])
									</td>
								@else
									<td>{{ old('names.' . $item->id) ?: $item->name }}</td>
									<td>{{ old('message.' . $item->id) ?: $item->message }}</td>
									<td>{{ old('published_at.' . $item->id) ?: $item->published_at }}</td>
								@endcan

							</tr>
						@endforeach

					</tbody>

				</table>


			@can($ability_edit)
				<div class="panel-footer">
					<div class="form-group">
						@include('chunker.base::admin.utils.buttons.save')
					</div>
				</div>
			@endcan
		</form>

	@else

		@include('chunker.base::admin.utils.alert', ['message' => $empty])

	@endif


@stop