@extends('layouts.auth')

@section('title', trans('approves.checklist'))

@section('content')

@hasRole('admin')
    <div class="page">
        <div class="center mb-3">
            <h1 class="header">
                <i class="fas fa-search red-text"></i> 
                @lang('approves.checklist')
            </h1>
        </div>

        <div v-cloak>
            <tabs>
                @for ($i = 0; $i <= 2; $i++)
                    <tab 
                        name="@lang("approves.{$recipes[$i]['name']}") 
                        <span class='red-text'><b>{{ count($recipes[$i]['recipes']) }}</b></span>"
                        {{ $i === 0 ? ':selected="true"' : '' }}
                    >
                        <div class="item-list unstyled-list row px-2 paper-dark">
                            @forelse ($recipes[$i]['recipes'] as $recipe)
                                <ul>
                                    <li style="margin-bottom:5px" class="col s12 m6 l4 row">
                                        <a href="/admin/approves/{{ $recipe->id }}" style="width:11em">

                                            <img src="{{ asset("storage/small/recipes/{$recipe->image}") }}"
                                                alt="{{ $recipe->getTitle() }}"
                                            />

                                        </a>

                                        <div class="item-content">
                                            <section>{{ string_limit($recipe->getTitle(), 45) }}</section>
                                            <section>
                                                <span class="grey-text">
                                                    @if ($i == 0)
                                                        @lang('approves.waiting_for_approves')
                                                    @elseif ($i == 1)
                                                        @lang('approves.user_is_checking', [
                                                            'user' => $recipe->approver->getName()
                                                        ])
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

                        {{ $recipes[$i]['recipes']->links() }}
                    </tab>
                @endfor
            </tabs>
        </div>
    </div>
@endhasRole

@endsection