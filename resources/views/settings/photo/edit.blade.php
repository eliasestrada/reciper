@extends('layouts.app')

@section('title', trans('settings.settings_photo'))

@section('content')

<div class="wrapper">
    <div class="row">
        <div class="col s12 m6 l7">
            <h1 class="headline">@lang('settings.settings_photo')</h1>
            <p>@lang('settings.choose_photo', ['btn1' => trans('forms.select'), 'btn2' => trans('forms.save')])</p>
        </div>

        <form action="{{ action('Settings\PhotoController@update') }}" method="post" enctype="multipart/form-data"> 
            @method('put') @csrf
            <div class="col s12 m6 l5 center">
                <div class="preview-image preview-image-profile position-relative z-depth-2 hoverable">
                    <img src="{{ asset('storage/users/' . user()->image) }}" alt="{{ user()->name }}" id="target-image">
                    <input type="file" name="image" id="src-image" class="hide" style="overflow:hidden">
                    <label for="src-image" class="btn min-w waves-effect waves-light">
                        <i class="fas fa-upload left"></i>
                        @lang('forms.select_file')
                    </label>
                    <div class="preview-overlay"></div>
                </div>
            </div>
            <div class="col s12 center pt-4">
                <button class="min-w btn waves-effect hoverable">
                    <i class="fas fa-save left"></i>
                    @lang('forms.save')
                </button>
            </div>
        </form>

        {{--  Delete image  --}}
        @if (user()->image != 'default.jpg')
            <form action="{{ action('Settings\PhotoController@destroy') }}" method="post" enctype="multipart/form-data" class="center">
                @method('delete') @csrf
                <button type="submit" class="btn red m-1 min-w">
                    <i class="fas fa-trash left"></i>
                    @lang('forms.deleting')
                </button>
            </form>
        @endif
    </div>
</div>

@endsection