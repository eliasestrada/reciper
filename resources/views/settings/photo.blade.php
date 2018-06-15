@extends('layouts.app')

@section('title', trans('settings.settings_photo'))

@section('content')

<div class="form-group">
	<div class="row">
		<div class="col m6">
			<h2 class="form-headline">
				<i class="title-icon" style="background: url('/css/icons/svg/camera.svg')"></i>
				@lang('settings.settings_photo')
			</h2>
			<p class="content">@lang('settings.photo_should_be_square')</p>
		</div>
		<div class="col m6">
			<div class="profile-header" style="height: 11em;">
				<img src="{{ asset('storage/uploads/' . user()->image) }}" alt="{{ user()->name }}" id="target-image" style="width: 170px; height:186px;" />
			</div>
		</div>
		<div class="col s12">
			{{--  Upload image  --}}
			<form action="{{ action('SettingsController@updatePhoto') }}" method="post" enctype="multipart/form-data" class="form">

				@method('put') @csrf

				<div class="form-group simple-group center-align">
					<input type="hidden" name="delete" value="0">

					<label for="src-image" class="image-label mb-5">
						@lang('form.select_file')
					</label>

					<input type="file" name="image" id="src-image" class="d-none">

					<button type="submit" style="margin-top:-1.7rem;" class="btn btn-main btn-lg">
						@lang('form.save_changes')
					</button>
				</div>
			</form>

			{{--  Delete image  --}}
			<form action="{{ action('SettingsController@updatePhoto') }}" method="post" enctype="multipart/form-data" class="form">

				@method('put') @csrf

				<div class="form-group simple-group">
					<input type="hidden" name="delete" value="1">
					<button type="submit" style="margin-top:-1.4rem;" class="btn btn-lg">
						@lang('form.delete_photo')
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection