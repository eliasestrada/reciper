@extends('layouts.app')

@section('title', Auth::user()->name)

@section('content')

<div class="profile-header">
	<h1>{{ auth()->user()->name }}</h1>
	<img src="{{ asset('storage/uploads/'.auth()->user()->image) }}" alt="{{ auth()->user()->name }}" />
</div>

{{--  Buttons  --}}
<div style="animation: appear .5s; padding-bottom: 4em;">
	<a href="/notifications" title="Оповещения" class="button" {{ $notifications }}>Оповещения</a>

	@if (Auth::user()->admin === 1)
		<a href="/checklist" title="Проверочная" class="button" {{ $allunapproved }}>Проверочная</a>
		<a href="/feedback" title="Обратная связь" class="button" {{ $allfeedback }}>Обратная связь</a>
	@endif
</div>
	
@endsection