@extends('layouts.app')

@section('title', user()->name)

@section('content')

<div class="profile-header">
	<h1>{{ user()->name }}</h1>
	<img src="{{ asset('storage/uploads/' . user()->image) }}" alt="{{ user()->name }}" />
</div>
	
@endsection