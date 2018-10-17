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
                <input type="text" name="for" id="autocomplete-input" class="autocomplete" style="margin-left:4em" autocomplete="off">
                <label for="autocomplete-input" style="margin-left:4em">@lang('pages.search_details')</label>
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

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var titles = {!! json_encode($search_suggest) !!}
        var converted = {};

        titles.forEach(function (title) {
            converted[title] = null;
        })

        var elems = document.querySelectorAll('.autocomplete');
        M.Autocomplete.init(elems, {
            data: converted,
            limit: 20,
            onAutocomplete: function() {
                $('search-form').submit()
            }
        });
    });
</script>
@endsection