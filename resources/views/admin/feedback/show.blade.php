@extends('layouts.auth')

@section('title', optional($feedback->recipe)->getTitle() ?? trans('feedback.feedback'))

@section('content')

<div class="page">
    <div class="center">
        <h1 class="header">
            @if ($feedback->isReport(1))
                @lang('feedback.report')
            @else
                @lang('feedback.feedback')
            @endif
        </h1>

        {{-- Delete button --}}
        <div class="mt-3">
            <form action="{{ action('Admin\FeedbackController@destroy', ['id' => $feedback->id]) }}" method="post" class="d-inline-block">
                @method('delete')
                @csrf

                <button type="submit" class="btn-floating red confirm tooltipped" data-confirm="@lang('contact.sure_del_feed')" data-tooltip="@lang('forms.deleting')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
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
                    <a href="#" class="text">{{ $feedback->visitor->id }}</a>
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

@endsection