@extends('layouts.app')

@section('title', trans('includes.checklist'))

@section('content')

@hasRole('admin')
    <div class="page">
        <div class="center">
            <h1 class="headline">
                @lang('includes.checklist')
            </h1>
        </div>

        <ul class="tabs"> {{-- Tab 1 --}}
            <li class="tab">
                <a href="#tab-1" class="active">
                    @lang('approves.unapproved_waiting') 
                    <span class="red-text">({{ $unapproved_waiting->count() }})</span>
                </a> 
            </li>
            <li class="tab"> {{-- Tab 2 --}}
                <a href="#tab-2">
                    @lang('approves.unapproved_checking') 
                    <span class="red-text">({{ $unapproved_checking->count() }})</span>
                </a>
            </li>
        </ul>

        @for ($i = 1; $i <= 2; $i++)
            <div class="item-list unstyled-list row paper-dark" id="tab-{{ $i }}">
                @forelse ($i == 1 ? $unapproved_waiting : $unapproved_checking as $recipe)
                    <ul>
                        <li style="margin-bottom:5px" class="col s12 m6 l4 row">
                            <a href="/admin/approves/{{ $recipe->id }}" style="width:11em">
                                <img src="{{ asset("storage/images/small/$recipe->image") }}" alt="{{ $recipe->getTitle() }}" />
                            </a>

                            <div class="item-content">
                                <section>{{ str_limit($recipe->getTitle(), 45) }}</section>
                                <section>
                                    <span class="main-text">
                                        @if ($i == 1)
                                            @lang('approves.waiting_for_approves')
                                        @else
                                            @lang('approves.user_is_checking', ['user' => $recipe->approver->name])
                                        @endif
                                    </span>
                               </section>
                            </div>
                        </li>
                    </ul>
                @empty
                    @component('comps.empty')
                        @slot('text')
                            @lang('admin.no_unapproved')
                        @endslot
                    @endcomponent
                @endforelse
            </div>

            {{ $i == 1 ? $unapproved_waiting->links() : $unapproved_checking->links() }}
        @endfor
    </div>
@endhasRole

@endsection

@section('script')
    @include('includes.js.tabs')
@endsection