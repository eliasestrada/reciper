@extends('layouts._master')

@section('content')
    <div class="page">
        <div class="center">
            <h1 class="header pb-4"><i class="fas fa-file-code red-text"></i> @lang('logs.logs')</h1>
        </div>

        <table class="responsive-table striped highlight">
            <thead>
                <tr>
                    @foreach($headers as $key => $header)
                        <th scope="col" class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                            <span style="font-size:12px">{{ $header }}</span>
                        </th>
                    @endforeach
                    <th class="tooltipped" data-tooltip="@lang('logs.open_file')"><i class="fas fa-envelope-open-text"></i></th>
                    <th class="tooltipped" data-tooltip="@lang('logs.download_file')"><i class="fas fa-file-download"></i></th>
                    <th class="tooltipped" data-tooltip="@lang('logs.delete_file')"><i class="fas fa-trash"></i></th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($rows))
                    @foreach($rows as $date => $row)
                    <tr>
                        @foreach($row as $key => $value)
                            <td class="center">
                                @if ($key == 'date')
                                    <span style="font-size:12px">
                                        {{ $value }} <br>
                                        {{ time_ago($value) }}
                                    </span>
                                @elseif ($key == 'all')
                                    <a href="{{ route('log-viewer::logs.filter', [$date, $key]) }}">
                                        <span class="new badge">{{ $value }}</span>
                                    </a>
                                @elseif ($value == 0)
                                    <span style="font-size:12px">{{ $value }}</span>
                                @else
                                    <a href="{{ route('log-viewer::logs.filter', [$date, $key]) }}">
                                        <span class="new badge green">{{ $value }}</span>
                                    </a>
                                @endif
                            </td>
                        @endforeach

                        <td class="p-0">
                            {{-- Open button --}}
                            <a href="{{ route('log-viewer::logs.show', [$date]) }}" class="btn-floating" style="width:30px;height:30px;line-height:30px">
                                <i class="fas fa-envelope-open-text" style="font-size:1.2rem;line-height:30px"></i>
                            </a>
                        </td>
                        <td class="p-0">
                            {{-- Download button --}}
                            <a href="{{ route('log-viewer::logs.download', [$date]) }}" class="btn-floating" style="width:30px;height:30px;line-height:30px">
                                <i class="fas fa-file-download" style="font-size:1.2rem;line-height:30px"></i>
                            </a>
                        </td>
                        <td class="p-0">
                            {{-- Delete button --}}
                            <form action="{{ action('Master\LogsController@destroy') }}" method="post" class="d-inline-block">
                                
                                @csrf
                                @method('delete')

                                <input type="hidden" name="date" value="{{ $date }}">
                                <button type="submit" class="btn-floating red confirm" data-confirm="@lang('logs.confirm', ['date' => $date])" style="width:30px;height:30px;line-height:30px">
                                    <i class="fas fa-trash" style="font-size:1.2rem;line-height:30px"></i>
                                </button>
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
    
        {!! $rows->render() !!}
    </div>
@endsection
