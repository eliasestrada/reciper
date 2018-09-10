@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')
    @include('recipes.partials.edit-form')
@endsection

@section('script')
    @include('includes.js.counter')
@endsection