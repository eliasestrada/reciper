@extends('layouts.app')

@section('content')

<div class="wrapper">
    <h1>{{ $title }}</h1>

    @if (count($recipes) > 0)
        <ul>
            @foreach ($recipes as $recipe)
            <li>{{ $recipe }}</li>
            @endforeach
        </ul>
    @endif
</div>

@endsection