@extends(setLayout())

@section('title', trans('help.help'))

@section('content')

<div class="page">
    <div class="center"><h1 class="header">@lang('help.help')</h1></div>

    <div class="row mt-4">
        @isset($help_categories, $help_list)
            @foreach ($help_categories as $category)
                <div class="col s12 m6 l4">
                    <h5 class="header">
                        <i class="fas {{ $category['icon'] }} left red-text w20"></i>
                        {{ $category[_('title')] }}
                    </h5>
                    <div class="divider"></div>

                    <ul>
                        @foreach ($help_list as $help)
                            @if ($help['help_category_id'] == $category['id'])
                                <li>
                                    <a href="/help/{{ $help['id'] }}" class="text text-hover" style="font-size:1.05em">
                                        <span class="red-text">#</span> {{ $help[_('title')] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endforeach
        @endisset
    </div>
</div>

@hasRole('admin')
    @component('comps.btns.fixed-btn')
        @slot('icon') fa-plus @endslot
        @slot('link') /master/help/create @endslot
        @slot('tip') @lang('help.new_help') @endslot
    @endcomponent
@endhasRole

@endsection