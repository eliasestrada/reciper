@extends('log-viewer::custom-theme._master')

@section('content')
    <div class="page">
        <div class="center">
            <h1 class="headline pb-4"><i class="fas fa-file-code red-text"></i> @lang('logs.logs')</h1>
        </div>

        <div style="overflow:scroll">
            <table>
                <thead class="main-light">
                    <tr>
                        @foreach($headers as $key => $header)
                            <th scope="col" class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                <span class="new badge transparent main-dark-text">{{ $header }}</span>
                            </th>
                        @endforeach
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($rows))
                        @foreach($rows as $date => $row)
                        <tr>
                            @foreach($row as $key => $value)
                                <td class="{{ $loop->index === 0 ? 'main-light' : '' }}">
                                    @if ($key == 'date')
                                        <span class="new badge transparent main-dark-text">
                                            {{ $value }} <br>
                                            {{ time_ago($value) }}
                                        </span>
                                    @elseif ($key == 'all')
                                        <a href="{{ route('log-viewer::logs.filter', [$date, $key]) }}">
                                            <span class="new badge">{{ $value }}</span>
                                        </a>
                                    @elseif ($value == 0)
                                        <span class="new badge transparent main-dark-text">{{ $value }}</span>
                                    @else
                                        <a href="{{ route('log-viewer::logs.filter', [$date, $key]) }}">
                                            <span class="new badge green">{{ $value }}</span>
                                        </a>
                                    @endif
                                </td>
                            @endforeach
    
                            <td class="align-right">
                                {{-- Open button --}}
                                <a href="{{ route('log-viewer::logs.show', [$date]) }}" class="btn-floating tooltipped" data-tooltip="@lang('logs.open_file')" data-position="top">
                                    <i class="fas fa-envelope-open-text"></i>
                                </a>
                                {{-- Download button --}}
                                <a href="{{ route('log-viewer::logs.download', [$date]) }}" class="btn-floating tooltipped" data-tooltip="@lang('logs.download_file')">
                                    <i class="fas fa-file-download"></i>
                                </a>
                                {{-- Delete button --}}
                                <form action="{{ action('Master\LogsController@delete') }}" method="post" class="d-inline-block tooltipped" data-tooltip="@lang('logs.delete_file')">
                                    
                                    @csrf
                                    @method('delete')

                                    <input type="hidden" name="date" value="{{ $date }}">
                                    <button type="submit" class="btn-floating red" onclick="if (!confirm('@lang('logs.confirm', ['date' => $date])')) event.preventDefault()"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center">
                                <span class="badge badge-secondary">
                                    @lang('log-viewer::general.empty-logs')
                                </span>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    
        {!! $rows->render() !!}
    </div>
@endsection
