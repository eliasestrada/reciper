@extends('layouts.error')

@section('title', $title)

@section('content')

<div class="d-flex pb-5" style="height:90vh; align-items:center; justify-content:center; flex-direction:column">
    <div class="center">
        <img src="{{ asset('storage/other/walking.gif') }}" alt="" width="250">
    </div>
    <h6 class="mb-0">{{ $error }}</h6>
    <h5 class="m-1">{{ $title }}</h5>
    <p class="mt-1 mb-4">{{ $slot }}</p>

    @if (! isset($btn))
        @include('includes.buttons.btns')
    @endif
</div>

@endsection