<!doctype html>
<html lang="{{ lang() }}">
<head>
    @yield('head')
    @include('includes.head')
    <title>@yield('title') - @lang('website.name')</title>
</head>
<body>

    @include('includes.nav.sidenav')
    @include('includes.nav.navbar')

    @yield('home-header')

    <div id="app" class="wrapper">
        @yield('content')
    </div>

    <!-- Modal for creating recipe -->
    <div id="modal2" class="modal">
        <div class="modal-content reset">
            <form action="{{ action('RecipesController@store') }}" method="post" class="page" enctype="multipart/form-data">
                @csrf
                {{--  Save button  --}}
                <div class="center pb-4">
                    <button type="submit" class="btn green">
                        <i class="material-icons left">save</i>
                        @lang('tips.save')
                    </button>
                </div>
                {{-- Title --}}
                <div class="input-field">
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="counter" data-length="{{ config('validation.recipe_title_max') }}">
                    <label for="title">@lang('recipes.title')</label>
                </div>
            </form>
        </div>
    </div>

    @include('includes.footer')

    {!! script_timestamp('/js/app.js') !!}

    @yield('script')
    @include('includes.js.dropdown')
    @include('includes.js.sidenav')
    @include('includes.js.tooltip')
    @include('includes.js.collapsible')
    @include('includes.messages')
    @include('includes.js.modal')
    @include('includes.js.counter')
</body>
</html>