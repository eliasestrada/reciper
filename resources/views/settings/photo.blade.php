@extends('layouts.app')

@section('title', trans('settings.settings_photo'))

@section('content')

<i class="title-icon" style="background: url('/css/icons/svg/camera.svg')"></i>

<h2 class="headline">@lang('settings.settings_photo')</h2>

<p class="content center">@lang('settings.photo_should_be_square')</p>

{{--  Upload image  --}}
{!! Form::open(['action' => ['SettingsController@updatePhoto', null], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

	@method('PUT')

	<div class="form-group simple-group" style="text-align:center;">
		<div class="profile-header" style="height: 11em;">
			<img src="{{ asset('storage/uploads/' . user()->image) }}" alt="{{ user()->name }}" id="target-image" style="width: 170px; height:186px;" />
		</div>
		<br />
		{{ Form::hidden('delete', 0) }}
		{{ Form::label('src-image', trans('form.select_file'), ['class' => 'image-label']) }}
		{{ Form::file('image', ['style' => "display:none;", 'id' => 'src-image']) }}
		{{ Form::submit(trans('form.save_changes'), ['style' => 'text-align:center;']) }}
	</div>
{!! Form::close() !!}

{{--  Delete image  --}}
{!! Form::open(['action' => ['SettingsController@updatePhoto', null], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

	@method('PUT')

	<div class="form-group simple-group">
		{{ Form::hidden('delete', 1) }}
		{{ Form::submit(trans('form.delete_photo'), ['style' => 'text-align:center; margin-top: -2.3rem; color:brown;']) }}
	</div>
{!! Form::close() !!}

@endsection