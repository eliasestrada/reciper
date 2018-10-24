@extends('layouts.auth')

@section('title', trans('settings.settings_photo'))

@section('content')

<div class="page">
    <div class="row">
        <div class="col s12 m5 l4">
            @include('includes.settings-sidebar')
        </div>
        <div class="col s12 m7 l8 mt-3">
            <div class="row">
                <div class="col s12 l6">
                    <h1 class="header ml-2">@lang('settings.settings_photo')</h1>
                    <p>@lang('settings.choose_photo', ['btn1' => trans('forms.select_file'), 'btn2' => trans('forms.save')])</p>
                </div>

                <div class="col s12 l6">
                    <form action="{{ action('Settings\PhotoController@update') }}" method="post" enctype="multipart/form-data" class="center"> 
                        @method('put') @csrf
                        <div class="preview-image preview-image-profile position-relative z-depth-2 hoverable">
                            <img src="{{ asset('storage/users/' . user()->photo) }}" alt="{{ user()->getName() }}" id="target-image">
                            <input type="file" name="photo" id="src-image" class="hide" style="overflow:hidden">
                            <label for="src-image" class="btn min-w waves-effect waves-light">
                                <i class="fas fa-upload left"></i>
                                @lang('forms.select_file')
                            </label>
                            <div class="preview-overlay"></div>
                        </div>
                        <button class="d-block mx-auto min-w btn waves-effect hoverable mt-2">
                            <i class="fas fa-save left"></i>
                            @lang('forms.save')
                        </button>
                    </form>

                    {{--  Delete image  --}}
                    @if (user()->image != 'default.jpg')
                        <form action="{{ action('Settings\PhotoController@destroy') }}" method="post" enctype="multipart/form-data" class="center">
                            @method('delete') @csrf
                            <button type="submit" class="d-block mx-auto btn red my-1 min-w hoverable waves-effect waves-light">
                                <i class="fas fa-trash left"></i>
                                @lang('forms.deleting')
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    @include('includes.js.collapsible')
@endsection
