@extends('log-viewer::custom-theme._master')

@section('content')
    <div class="mb-4">
        <h4>@lang('logs.logs')</h4>
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
                @if ($rows->count() > 0)
					@foreach($rows as $date => $row)
                    <tr>
						@foreach($row as $key => $value)
							<td class="{{ $loop->index === 0 ? 'main-light' : '' }}">
                                @if ($key == 'date')
                                    <span class="new badge transparent main-dark-text">
										{{ $value }} <br />
										{{ timeAgo($value) }}
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
                            <a href="{{ route('log-viewer::logs.show', [$date]) }}" class="btn btn-small tooltipped" data-tooltip="@lang('logs.open_file')" data-position="top">
                                <i class="material-icons">insert_drive_file</i>
							</a>
							{{-- Download button --}}
                            <a href="{{ route('log-viewer::logs.download', [$date]) }}" class="btn btn-small tooltipped" data-tooltip="@lang('logs.download_file')" data-position="top">
                                <i class="material-icons">file_download</i>
							</a>
							{{-- Delete button --}}
							<form action="{{ action('LogsController@delete') }}" method="post" class="d-inline-block tooltipped" data-tooltip="@lang('logs.delete_file')" data-position="top" onsubmit="return confirm('@lang('logs.confirm', ['date' => $date])')">
								<input type="hidden" name="_method" value="DELETE">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="date" value="{{ $date }}">
								<button type="submit" class="btn btn-small red"><i class="material-icons">delete</i></button>
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
@endsection
