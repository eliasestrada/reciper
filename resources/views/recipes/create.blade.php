@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')
    @include('recipes.partials.create-form')
@endsection