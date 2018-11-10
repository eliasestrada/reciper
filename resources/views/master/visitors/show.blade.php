@extends('layouts.auth')

@section('title', trans('visitors.visitor') . ' ' . $visitor->id)

@section('content')

@include('includes.buttons.back', ['url' => '/master/visitors'])

<div class="page">
    <div class="center">
        <div>
            <h1 class="header mb-4">
                @lang('visitors.visitor'): <span class="red-text">{{ $visitor->id }}</span>
            </h1>
        </div>

        <table class="mt-3 responsive">
            <tbody>
                <tr> {{-- Recipes viewed --}}
                    <td>@lang('visitors.recipes_viewed'): <span class="red-text">{{ $visitor->views->count() }}</span></td>
                </tr>
                <tr> {{-- Firt visit --}}
                    <td>
                        @lang('visitors.first_visit'): <span class="red-text">{{ $visitor->created_at }}</span> ({{ time_ago($visitor->created_at) }})
                    </td>
                </tr>
                <tr> {{-- Days with us --}}
                    <td>@lang('visitors.days_with_us'): <span class="red-text">{{ $visitor->daysWithUs() }}</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
