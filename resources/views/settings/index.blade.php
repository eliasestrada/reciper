@extends('layouts.user')

@section('title', 'Настройки')

@section('head')
	<style>#settings { border-bottom: 3px solid #a8a8a8; }</style>
@endsection

@section('content')

	<h2 class="headline">Настройки</h2>
	
	<div class="container" style="margin-top: 1em;">
		<a href="/settings/general" title="Общие" class="button">Общие</a>
		<a href="/settings/photo" title="Настройки" class="button">Фотография</a>

		{{--  Для Админов  --}}
		@if (Auth::user()->admin === 1)
			<a href="/settings/titles" title="Заголовки" class="button">Заголовки</a>
		@endif
	</div>

@endsection