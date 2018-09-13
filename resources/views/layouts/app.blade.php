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
            <form action="{{ action('RecipesController@store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="center">
                    <p class="flow-text main-text">@lang('recipes.name_for_recipe')</p>
                </div>

                {{-- Title --}}
                <div class="input-field">
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="counter" data-length="{{ config('validation.recipe_title_max') }}" minlength="5" required>
                    <label for="title">@lang('recipes.title')</label>
                </div>

                {{--  Save button  --}}
                <div class="center pb-2">
                    <button type="submit" class="btn waves-effect waves-light">
                        <i class="material-icons right">keyboard_arrow_right</i>
                        @lang('recipes.next')
                    </button>
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