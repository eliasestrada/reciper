@extends('layouts.app')

@section('title', user()->name)

@section('content')

<div class="profile-header">
	<h1>{{ user()->name }}</h1>
	<img src="{{ asset('storage/uploads/' . user()->image) }}" alt="{{ user()->name }}" />
</div>

{{--  Buttons  --}}
<div style="animation: appear .5s; padding-bottom: 4em;">
	<a href="/notifications" title="Оповещения" class="button" {{ $notifications }}>Оповещения</a>

	@admin
		<a href="/checklist" title="Проверочная" class="button" {{ $allunapproved }}>Проверочная</a>
		<a href="/feedback" title="Обратная связь" class="button" {{ $allfeedback }}>Обратная связь</a>
	@endadmin
</div>
	
@endsection