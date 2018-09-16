@extends('layouts.app')

@section('title', $feedback->recipe->getTitle())

@section('content')

<div class="page">
    <div class="center">
        <h1 class="headline">
            @if ($feedback->isReport(1))
                @lang('feedback.report')
            @else
                @lang('feedback.feedback')
            @endif
        </h1>
    </div>

    <table class="mt-2">
        <tbody>
            @if ($feedback->isReport(1))
                <tr>
                    <td>
                        <b>@lang('feedback.report_recipe'):</b> 
                        <a href="/recipes/{{ $feedback->recipe->id }}">
                            {{ $feedback->recipe->getTitle() }}
                        </a>
                    </td>
                </tr>
            @endif
            <tr>
                <td>
                    <b>@lang('messages.sender'):</b> 
                    <a href="#">{{ $feedback->visitor->id }}</a>
                </td>
            </tr>
            <tr>
                <td><b>@lang('messages.sent'):</b> {{ time_ago($feedback->created_at) }}</td>
            </tr>
            <tr>
                <td>
                    <b>@lang('messages.message'):</b> 
                    aef af faf Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi, ab?
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection