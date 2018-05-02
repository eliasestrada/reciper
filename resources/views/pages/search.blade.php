@extends('layouts.app')

@section('title', trans('pages.search'))

@section('content')

{{--  Form  --}}
{!! Form::open([
	'action' => 'PagesController@search',
	'method' => 'GET',
	'class' => 'form'
]) !!}
	<div class="form-group simple-group">
		<h2 class="form-headline">
			<i class="title-icon" style="background: url('/css/icons/svg/search.svg')"></i>
			@lang('pages.search')
		</h2>

		{{ Form::text('for', '', [
			'placeholder' => trans('pages.search_details'),
			'id' => 'search-input'
		]) }}

		{{ Form::submit('', ['style' => 'display:none'])}}
	</div>
{!! Form::close() !!}

{{--  Results  --}}
@if ($recipes)
	<section class="container recipes">
		<div class="row">

			@foreach ($recipes as $recipe)
				<div class="recipe-container col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<div class="recipe">

						{{--  Image  --}}
						<a href="/recipes/{{ $recipe->id }}">
							<img  src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->title }}" title="{{ $recipe->title }}">
						</a>

						{{--  Title  --}}
						<div class="recipes-content">
							<h3>{{ $recipe->title }}</h3>
						</div>
					</div>
				</div>
			@endforeach

		</div>
	</section>
@endif

<div class="content">
	<h4 class="content center">{{ $message }}</h4>
</div>

@endsection