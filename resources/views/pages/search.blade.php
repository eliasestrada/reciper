@extends(auth()->check() ? 'layouts.auth' : 'layouts.guest')

@section('title', trans('pages.search'))

@section('content')

<div class="page">
    <div class="center pb-2">
        <h1 class="header">@lang('pages.search')</h1>
    </div>
    
    {{--  Form  --}}
    <div class="container">
        <form action="{{ action('PagesController@search') }}" method="get" id="search-form">
            <div class="input-field">
                <button type="submit" class="prefix btn-floating">
                    <i class="fas fa-search"></i>
                </button>
                <input type="text" name="for" id="search" style="margin-left:4em">
                <label for="search" style="margin-left:4em">@lang('pages.search_details')</label>
            </div>
        </form>
    </div>

    {{--  Cards  --}}
    @component('comps.card', ['recipes' => $recipes])
        @slot('no_recipes')
            {{ $message }} 
        @endslot
    @endcomponent

    @if ($recipes->count() > 0)
        {{ $recipes->appends(request()->input())->links() }}
    @endif
</div>

@endsection