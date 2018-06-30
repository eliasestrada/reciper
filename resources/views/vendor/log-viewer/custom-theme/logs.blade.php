@extends('log-viewer::custom-theme._master')

@section('content')
    <div class="page-header mb-4">
        <h4>@lang('logs.logs')</h4>
    </div>

    <div>
        <table>
            <thead>
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
                            <td class="{{ $key == 'date' ? 'align-left' : 'align-center' }}">
                                @if ($key == 'date')
                                    <span class="new badge transparent main-dark-text">{{ $value }}</span>
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
							{{-- Search button --}}
                            <a href="{{ route('log-viewer::logs.show', [$date]) }}" class="btn btn-small">
                                <i class="material-icons">search</i>
							</a>
							{{-- Download button --}}
                            <a href="{{ route('log-viewer::logs.download', [$date]) }}" class="btn btn-small">
                                <i class="material-icons">file_download</i>
							</a>
							{{-- Delete button --}}
							<form action="{{ route('log-viewer::logs.delete') }}" method="post" class="d-inline-block">
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
