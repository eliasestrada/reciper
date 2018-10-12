@extends('layouts.app')

@section('title', trans('settings.settings'))

@section('content')

<div class="wrapper">
    <div class="container">
        <ul class="collection with-header">
            <li class="collection-header"><h4 class="header">@lang('settings.settings')</h4></li>
            <a href="/settings/general/edit" class="collection-item">
                <i class="fas fa-cogs fa-15x right grey-text"></i>
                @lang('settings.general'). 
                <span class="grey-text">@lang('settings.general_desc')</span>
            </a>
            <a href="/settings/password/edit" class="collection-item">
                <i class="fas fa-key right fa-15x grey-text"></i>
                @lang('settings.password'). 
                <span class="grey-text">@lang('settings.password_desc')</span>
            </a>
            <a href="/settings/photo/edit" class="collection-item">
                <i class="fas fa-camera right fa-15x grey-text"></i>
                @lang('settings.photo'). 
                <span class="grey-text">@lang('settings.photo_desc')</span>
            </a>
        </ul>
    </div>
</div>

@endsection