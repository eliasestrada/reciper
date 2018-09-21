@extends('layouts.app')

@section('title', trans('help.help'))

@section('content')

<div class="page">
    <div class="center"><h1 class="headline">@lang('help.help')</h1></div>

    <div class="row mt-4">
        @foreach ($help_categories as $category)
            <div class="col s12 m6 l4">
                <h5 class="grey-dark-text header"> <i class="material-icons left red-text">{{ $category->icon }}</i>
                    {{ $category->getTitle() }}
                </h5>
                <div class="divider"></div>

                <ul>
                    @foreach ($help->where('help_category_id', $category->id) as $h)
                        <li>
                            <a href="/help/{{ $h->id }}" class="main-dark-text" style="font-size:1.05em">
                                <span class="red-text">#</span> {{ $h->getTitle() }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>

@endsection