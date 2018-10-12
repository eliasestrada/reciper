@extends('layouts.app')

@section('title', optional($feedback->recipe)->getTitle() ?? trans('feedback.feedback'))

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

        <div class="mt-3"> {{-- Delete button --}}
            <a onclick="if (confirm('@lang('contact.sure_del_feed')')) $('delete-feed').submit()" class="btn-floating red tooltipped" data-tooltip="@lang('tips.delete')">
                <i class="fas fa-trash"></i>
            </a>
        </div>
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
            <tr> {{-- Sender --}}
                <td>
                    <b>@lang('messages.sender'):</b> 
                    <a href="#">{{ $feedback->visitor->id }}</a>
                </td>
            </tr>
            <tr> {{-- Time ago --}}
                <td><b>@lang('messages.sent'):</b> {{ time_ago($feedback->created_at) }}</td>
            </tr>
            <tr> {{-- Message --}}
                <td>
                    <b>@lang('messages.message'):</b> 
                    {{ $feedback->message }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

<form action="{{ action('Admin\FeedbackController@destroy', ['id' => $feedback->id]) }}" method="post" id="delete-feed" class="hide">
    @method('delete') @csrf
</form>

@endsection