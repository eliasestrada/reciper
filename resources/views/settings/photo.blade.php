@extends('layouts.app')

@section('title', trans('settings.settings_photo'))

@section('content')

<div class="container">
	<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<h2 class="form-headline">
					<i class="title-icon" style="background: url('/css/icons/svg/camera.svg')"></i>
					@lang('settings.settings_photo')
				</h2>
				<p class="content">@lang('settings.photo_should_be_square')</p>
			</div>
			<div class="col-md-6">
				<div class="profile-header" style="height: 11em;">
					<img src="{{ asset('storage/uploads/' . user()->image) }}" alt="{{ user()->name }}" id="target-image" style="width: 170px; height:186px;" />
				</div>
			</div>
			<div class="col-12">
				{{--  Upload image  --}}
				{!! Form::open(['action' => ['SettingsController@updatePhoto', null], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}
								
					@method('PUT')

					<div class="form-group simple-group" style="text-align:center;">
						{{ Form::hidden('delete', 0) }}
						{{ Form::label('src-image', trans('form.select_file'), ['class' => 'image-label']) }}
						{{ Form::file('image', ['style' => "display:none;", 'id' => 'src-image']) }}
						{{ Form::submit(trans('form.save_changes'), ['class' => 'center bg-none']) }}
					</div>
				{!! Form::close() !!}

				{{--  Delete image  --}}
				{!! Form::open(['action' => ['SettingsController@updatePhoto', null], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

					@method('PUT')

					<div class="form-group simple-group">
						{{ Form::hidden('delete', 1) }}
						{{ Form::submit(trans('form.delete_photo'), ['style' => 'margin-top: -2.3rem; color:brown;', 'class' => 'center bg-none']) }}
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection