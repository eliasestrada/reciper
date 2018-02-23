@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    @if (count($recipes) > 0)
        <ul>
            @foreach ($recipes as $recipe)
            <li>{{ $recipe }}</li>
            @endforeach
        </ul>
    @endif

@endsection