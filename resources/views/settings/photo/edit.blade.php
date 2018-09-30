@extends('layouts.app')

@section('title', trans('settings.settings_photo'))

@section('content')

<div class="page">
    <div class="row">
        <div class="col s12 m6">
            <h1 class="headline">@lang('settings.settings_photo')</h1>
            <p>@lang('settings.choose_photo', ['btn1' => trans('forms.select_file'), 'btn2' => trans('forms.save')])</p>
        </div>
        <div class="col s12 m6">
            <div class="profile-header">
                <div class="image-wrapper">
                    <img src="{{ asset('storage/users/' . user()->image) }}" alt="{{ user()->name }}" id="target-image" style="width:170px" />
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ action('Settings\PhotoController@update') }}" method="post" enctype="multipart/form-data"> 
            @method('put') @csrf
            <div class="file-field input-field">
                <div class="btn">
                    <span>@lang('forms.select_file')</span>
                    <input type="file" name="image" id="src-image">
                </div>
                <div class="file-path-wrapper">
                    <input type="text" class="file-path validate" name="delete">
                </div>
                <label for="src-image" class="image-label mb-5">
            </div>

            <div class="center">
                <button type="submit" class="btn m-1 min-w">@lang('forms.save')</button>
            </div>
        </form>

        {{--  Delete image  --}}
        @if (user()->image != 'default.jpg')
            <form action="{{ action('Settings\PhotoController@destroy') }}" method="post" enctype="multipart/form-data" class="center">
                @method('delete') @csrf
                <div><button type="submit" class="btn red m-1 min-w">@lang('forms.delete_photo')</button></div>
            </form>
        @endif
    </div>
</div>

@endsection