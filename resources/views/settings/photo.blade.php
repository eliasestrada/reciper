@extends('layouts.app')

@section('title', 'Настройки')

@section('content')

	<h2 class="headline">Настройки</h2>
	<p class="content center">Единственное требование к выбору изображению это соотношение его сторон, оно долно быть квадратное, в противном случае изображение будет искажено.</p>

	{{--  Upload image  --}}
	{!! Form::open(['action' => ['SettingsController@updatePhoto', null], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

		@method('PUT')

		<div class="form-group">
			<div class="profile-header" style="height: 11em;">
				<img src="{{ asset('storage/uploads/'.$user->image) }}" alt="{{$user->name}}" id="target-image" style="width: 170px; height:186px;" />
			</div>
			<br />

			{{ Form::hidden('delete', 0) }}

			{{ Form::label('src-image', 'Выбрать файл', ['class' => 'image-label']) }}
			{{ Form::file('image', ['style' => "display:none;", 'id' => 'src-image']) }}
			{{ Form::submit('Сохранить') }}
		</div>
	{!! Form::close() !!}

	{{--  Delete image  --}}
	{!! Form::open(['action' => ['SettingsController@updatePhoto', null], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

		@method('PUT')

		<div class="form-group">
			{{ Form::hidden('delete', 1) }}
			{{ Form::submit('Удалить', ['style' => 'background: brown; margin-top: -2.3rem;']) }}
		</div>
	{!! Form::close() !!}

@endsection

@section('script')
<script>
	var src = document.getElementById("src-image")
	var target = document.getElementById("target-image")

	function showImage(src, target) {
		var fr = new FileReader()
		
		fr.onload = function(e) { target.src = this.result }
		src.addEventListener("change", ()=> fr.readAsDataURL(src.files[0]))
	}

	showImage(src, target)
</script>
@endsection