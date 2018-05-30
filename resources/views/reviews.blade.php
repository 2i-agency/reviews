@extends('base::template')

@section('page.title', 'Отзывы')

@section('page.content')

	<h3>Отзывы</h3>
	@can('reviews.edit')

		{{--Форма добавления элемента--}}
		<form method="POST" action="{{ route('admin.reviews.store') }}" enctype="multipart/form-data" class="panel panel-default">
			{!! csrf_field() !!}
			{!! method_field('PUT') !!}

			<div class="panel-heading">
				<h4 class="panel-title">Новый отзыв</h4>
			</div>

			<div class="panel-body">
				<div class="row">
					<div class="col-sm-8">

						<div class="form-group">
							<label>Имя</label>
							<input
								type="text"
								name="name"
								value="{{ old('name') }}"
								autofocus
								required
								autocomplete="off"
								placeholder="Иван Иванов"
								class="form-control"
							>
						</div>

						<div class="form-group">
							<label>Сообщение</label>
							<textarea
								name="message"
								required
								rows="3"
								class="form-control"
							>{{ old('message') }}</textarea>
						</div>
					</div>

					<div class="col-sm-4">

						<div class="form-group">
							<label>Время публикации</label>
							@include('base::utils.inputs.timepicker', [
								'name' => 'published_at',
								'value' => is_array(old('published_at')) ? NULL : old('published_at')
							])
						</div>

						@if(config('chunker.reviews.icon'))
							<div class="form-group">
								<label>Фото</label>
								<input type="file" accept="image/*" name="image">
							</div>
						@endif

					</div>
				</div>
			</div>

			<div class="panel-footer">
				<button type="submit" class="btn btn-primary">
					<span class="glyphicon glyphicon-plus"></span>
					Добавить
				</button>
			</div>

		</form>

	@endcan

	@if($reviews->count())

		{{--Список--}}
		<form method="POST" action="{{ route('admin.reviews.save') }}" enctype="multipart/form-data">
			{!! method_field('PUT') !!}

			<div class="flex-row">
				@foreach ($reviews as $review)
					<div data-id="{{ $review->id }}" class="flex-col-lg-3 flex-col-md-4 flex-col-sm-6 flex-col-xs-12">
						<div class="panel panel-default">

							<div class="panel-body">
								<div class="form-group">
									<label>Имя</label>
									<input
										type="text"
										name="reviews[{{ $review->id }}][name]"
										value="{{ old('names.' . $review->id) ?: $review->name }}"
										required
										autocomplete="off"
										placeholder="Имя"
										class="form-control"
									>
								</div>

								<div class="form-group">
									<label>Сообщение</label>
									<textarea
										name="reviews[{{ $review->id }}][message]"
										required
										rows="3"
										placeholder="Текст сообщения"
										class="form-control"
									>{{ old('messages.' . $review->id) ?: $review->message }}</textarea>
								</div>

								<div class="form-group">
									<label>Время публикации</label>
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
								</div>

								@if(config('chunker.reviews.icon'))
									@php($media = $review->getFirstMedia())
									<div class="form-group">
										<label>Фото</label>
										@if($media)
											<img src="{{ asset($media->getUrl()) }}" width="100" class="thumbnail">
											<div class="checkbox">
												<label>
													<input type="checkbox" name="imagesDelete[{{ $review->id }}]" value="{{ $media->id }}"> Удалить фото
												</label>
											</div>
										@endif

										<input type="file" name="imagesUpload[{{ $review->id }}]" accept="image/*">
									</div>
								@endif
							</div>

							<div class="panel-footer">
								<div class="checkbox">
									<label>
										<input name="delete[]" value="{{ $review->id }}" type="checkbox"> Удалить
									</label>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>

			{{--<table class="table table-hover">--}}

				{{--Отключение позиционирование при отсутствии прав на редактирование--}}
				{{--<tbody>--}}

				{{--@foreach ($reviews as $review)--}}

					{{--<tr data-id="{{ $review->id }}">--}}

						{{--<td>--}}
							{{--@if($media)--}}
								{{--<img src="{{ asset($media->getUrl()) }}" width="100" class="thumbnail">--}}
							{{--@endif--}}
								{{--<input type="text">--}}
						{{--</td>--}}

						{{--@can('reviews.edit')--}}
							{{--<td>--}}
								{{--<input--}}
									{{--type="text"--}}
									{{--name="reviews[{{ $review->id }}][name]"--}}
									{{--value="{{ old('names.' . $review->id) ?: $review->name }}"--}}
									{{--required--}}
									{{--autocomplete="off"--}}
									{{--placeholder="Имя"--}}
									{{--class="form-control"--}}
								{{-->--}}
							{{--</td>--}}

							{{--<td>--}}
								{{--<textarea--}}
									{{--name="reviews[{{ $review->id }}][message]"--}}
									{{--required--}}
									{{--rows="3"--}}
									{{--placeholder="Текст сообщения"--}}
									{{--class="form-control"--}}
								{{-->{{ old('messages.' . $review->id) ?: $review->message }}</textarea>--}}
							{{--</td>--}}

							{{--<td>--}}
								{{--@php--}}
									{{--if(is_array(old('published_at'))){--}}
										{{--$published_at_value = old('published_at')[$review->id];--}}
									{{--} elseif(old('published_at') !== NULL) {--}}
										{{--$published_at_value = old('published_at');--}}
									{{--} else {--}}
										{{--$published_at_value = isset($review->published_at) ? $review->published_at : NULL;--}}
									{{--}--}}
								{{--@endphp--}}

								{{--@include('base::utils.inputs.timepicker', [--}}
									{{--'name' => 'reviews[' . $review->id . '][published_at]',--}}
									{{--'value' => $published_at_value--}}
								{{--])--}}
							{{--</td>--}}
							{{--<td>--}}
								{{--<div class="checkbox">--}}
									{{--<label>--}}
										{{--<input name="delete[]" value="{{ $review->id }}" type="checkbox"> Удалить--}}
									{{--</label>--}}
								{{--</div>--}}
							{{--</td>--}}
						{{--@else--}}
							{{--<td>{{ old('names.' . $review->id) ?: $review->name }}</td>--}}
							{{--<td>{{ old('message.' . $review->id) ?: $review->message }}</td>--}}
							{{--<td>{{ old('published_at.' . $review->id) ?: $review->published_at }}</td>--}}
						{{--@endcan--}}

					{{--</tr>--}}
				{{--@endforeach--}}

				{{--</tbody>--}}

			{{--</table>--}}

			<div class="mt20px mb20px">
				@include('base::utils.buttons.save')
			</div>
		</form>

	@else

		@include('base::utils.alert', ['message' => 'Отзывы отсутствуют'])

	@endif


@stop