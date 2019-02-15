@extends(setLayout())

@section('title', trans('help.help'))

@section('content')

<div class="hide-on-large-only">
    @include('includes.buttons.back', ['url' => '/help'])
</div>

<div class="p-3 row">
    @isset($help_categories, $help_list)
        <ul class="sidenav col l3 z-depth-0 position-relative hide-on-med-only hide-on-small-only transparent"
            style="transform:translateX(0%);overflow:scroll;max-height:700px"
        >
            @foreach ($help_categories as $category)
                <li>
                    <a class="subheader grey-text mt-3">
                        <i class="fas {{ $category['icon'] }}  red-text fa-15x"></i>
                        {{ $category[_('title')] }}
                    </a>
                </li>
                <div class="divider mb-2"></div>

                <ul>
                    @foreach ($help_list as $question)
                        @if ($question['help_category_id'] == $category['id'])
                            <li class="p-1 {{ active_if_route_is(["help/{$question['id']}"]) }}">
                                <i class="fas fa-angle-right red-text ml-1 left"
                                    style="line-height:22px"
                                ></i>
                                <a href="/help/{{ $question['id'] }}"
                                    class="text text-hover"
                                    style="font-size:1.05em;height:auto;line-height:22px"
                                >
                                    {{ $question[_('title')] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endforeach
        </ul>
    @endisset
    @isset($help)
        <div class="col l9 pl-4">
            <h1 class="pt-5 header"><b>{{ $help->getTitle() }}</b></h1>
            <div class="divider"></div>
            <p>{!! $help->getText() !!}</p>
        </div>
    @endisset
</div>

@hasRole('admin')
    @component('comps.btns.fixed-btn')
        @slot('icon') fa-pen @endslot
        @slot('link') /master/help/{{ $help->id }}/edit @endslot
        @slot('tip') @lang('help.edit_help') @endslot
    @endcomponent
@endhasRole

@endsection
