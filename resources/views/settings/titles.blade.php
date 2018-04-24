@extends('layouts.app')

@section('title', trans('settings.titles_home_page'))

@section('content')

<div class="container">
	<h2 class="headline">@lang('settings.titles_home_page')</h2>

	{{--  Настройки Баннера  --}}
	<button class="accordion" type="button">@lang('settings.banner')</button>
	<div class="accordion-panel">
		{!! Form::open(['action' => 'SettingsController@updateBannerData', 'method' => 'POST', 'class' => 'form']) !!}

			@method('PUT')

			<div class="form-group">
				{{ Form::label('title', trans('settings.banner_title')) }}
				{{ Form::text('title', $title_banner->title, ['placeholder' => trans('settings.banner_title')]) }}
			</div>

			<div class="form-group">
				{{ Form::label('text', trans('settings.banner_text')) }}
				{{ Form::textarea('text', $title_banner->text, ['placeholder' => trans('settings.banner_text')]) }}
			</div>

			<div class="form-group">
				{{ Form::submit(trans('form.save')) }}
			</div>
		{!! Form::close() !!}
	</div>

	{{--  Настройки Интро  --}}
	<button class="accordion" type="button">@lang('settings.intro')</button>
	<div class="accordion-panel">
		{!! Form::open(['action' => 'SettingsController@updateIntroData', 'method' => 'POST', 'class' => 'form']) !!}

			@method('PUT')

			<div class="form-group">
				{{ Form::label('title', trans('settings.intro_title')) }}
				{{ Form::text('title', $title_intro->title, ['placeholder' => trans('settings.intro_title')]) }}
			</div>

			<div class="form-group">
				{{ Form::label('text', trans('settings.intro_text')) }}
				{{ Form::textarea('text', $title_intro->text, ['placeholder' => trans('settings.intro_text')]) }}
			</div>

			<div class="form-group">
				{{ Form::submit(trans('form.save')) }}
			</div>
		{!! Form::close() !!}
	</div>

	{{--  Настройки подвала  --}}
	<button class="accordion" type="button">@lang('settings.footer')</button>
	<div class="accordion-panel">
		{!! Form::open(['action' => 'SettingsController@updateFooterData', 'method' => 'POST', 'class' => 'form']) !!}

			@method('PUT')

			<div class="form-group">
				{{ Form::label('text', trans('settings.footer_text')) }}
				{{ Form::textarea('text', $title_footer->text, ['placeholder' => trans('settings.footer_text')]) }}
			</div>

			<div class="form-group">
				{{ Form::submit(trans('form.save')) }}
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