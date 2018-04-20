@extends('layouts.app')

@section('title', 'Заголовки')

@section('content')

<div class="container">
	<h2 class="headline">Заголовки главной страницы</h2>

	{{--  Настройки Баннера  --}}
	<button class="accordion" type="button">Баннер</button>
	<div class="accordion-panel">
		{!! Form::open(['action' => 'SettingsController@updateBannerData', 'method' => 'POST', 'class' => 'form']) !!}
			@method('PUT')

			<div class="form-group">
				{{ Form::label('title', 'Заголовок баннера') }}
				{{ Form::text('title', $title_banner->title, ['placeholder' => 'Заголово баннера']) }}
			</div>

			<div class="form-group">
				{{ Form::label('text', 'Содержание баннера') }}
				{{ Form::textarea('text', $title_banner->text, ['placeholder' => 'Содержание баннера']) }}
			</div>

			<div class="form-group">
				{{ Form::submit('Сохранить') }}
			</div>
		{!! Form::close() !!}
	</div>

	{{--  Настройки Интро  --}}
	<button class="accordion" type="button">Интро</button>
	<div class="accordion-panel">
		{!! Form::open(['action' => 'SettingsController@updateIntroData', 'method' => 'POST', 'class' => 'form']) !!}
			@method('PUT')

			<div class="form-group">
				{{ Form::label('title', 'Заголовок баннера') }}
				{{ Form::text('title', $title_intro->title, ['placeholder' => 'Заголово интро']) }}
			</div>

			<div class="form-group">
				{{ Form::label('text', 'Содержание интро') }}
				{{ Form::textarea('text', $title_intro->text, ['placeholder' => 'Содержание интро']) }}
			</div>

			<div class="form-group">
				{{ Form::submit('Сохранить') }}
			</div>
		{!! Form::close() !!}
	</div>

	{{--  Настройки подвала  --}}
	<button class="accordion" type="button">Подвал</button>
	<div class="accordion-panel">
		{!! Form::open(['action' => 'SettingsController@updateFooterData', 'method' => 'POST', 'class' => 'form']) !!}

			@method('PUT')

			<div class="form-group">
				{{ Form::label('text', 'Содержание подвала') }}
				{{ Form::textarea('text', $title_footer->text, ['placeholder' => 'Содержание подвала']) }}
			</div>

			<div class="form-group">
				{{ Form::submit('Сохранить') }}
			</div>
		{!! Form::close() !!}
	</div>
</div>

@endsection

@section('script')
<script>
	var acc = document.getElementsByClassName("accordion")
	var src = document.getElementById("src-image")
	var target = document.getElementById("target-image")
	var i

	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function(){
			this.classList.toggle("accordion-active")
			var panel = this.nextElementSibling

			if (panel.style.maxHeight) {
				panel.style.maxHeight = null
			} else {
				panel.style.maxHeight = panel.scrollHeight + "px"
			} 
		})
	}
	
	showImage(src, target)
</script>
@endsection