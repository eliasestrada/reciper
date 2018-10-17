@extends('layouts.auth')

@section('title', trans('approves.checklist'))

@section('content')

@hasRole('admin')
    <div class="page">
        <div class="center mb-3">
            <h1 class="header"><i class="fas fa-search red-text"></i> @lang('approves.checklist')</h1>
        </div>

        <div v-cloak>
            <tabs>
                @for ($i = 1; $i <= 3; $i++)
                    <tab 
                        @if ($i == 1)
                            name="@lang('approves.unapproved_waiting') 
                            <span class='red-text'><b>{{ $unapproved_waiting->count() }}</b></span>"
                            :selected="true"
                        @elseif($i == 2)
                            name="@lang('approves.unapproved_checking') 
                            <span class='red-text'><b>{{ $unapproved_checking->count() }}</b></span>"
                        @elseif($i == 3)
                            name="@lang('approves.my_approves') 
                            <span class='red-text'><b>{{ $my_approves->count() }}</b></span>"
                        @endif
                    >
                        <div class="item-list unstyled-list row px-2 paper-dark" id="tab-{{ $i }}">
                            @forelse ($i == 1 ? $unapproved_waiting : ($i == 2 ? $unapproved_checking : $my_approves) as $recipe)
                                <ul>
                                    <li style="margin-bottom:5px" class="col s12 m6 l4 row">
                                        <a href="/admin/approves/{{ $recipe->id }}" style="width:11em">
                                            <img src="{{ asset("storage/recipes/small/$recipe->image") }}" alt="{{ $recipe->getTitle() }}" />
                                        </a>

                                        <div class="item-content">
                                            <section>{{ str_limit($recipe->getTitle(), 45) }}</section>
                                            <section>
                                                <span class="main-text">
                                                    @if ($i == 1)
                                                        @lang('approves.waiting_for_approves')
                                                    @elseif ($i == 2)
                                                        @lang('approves.user_is_checking', ['user' => $recipe->approver->getName()])
                                                    @endif
                                                </span>
                                        </section>
                                        </div>
                                    </li>
                                </ul>
                            @empty
                                @if ($i !== 3)
                                    @component('comps.empty')
                                        @slot('text')
                                            @lang('admin.no_unapproved')
                                        @endslot
                                    @endcomponent
                                @endif
                            @endforelse
                        </div>

                        {{ $i == 1 ? $unapproved_waiting->links() : $unapproved_checking->links() }}
                    </tab>
                @endfor
            </tabs>
        </div>
    </div>
@endhasRole

@endsection