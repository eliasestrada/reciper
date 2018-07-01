@extends('log-viewer::custom-theme._master')

@section('content')
	<div class="row">
		<div class="col s12 m4 l3">
			<div class="mb-4"> {{-- Log Menu --}}
				<ul class="collection">
					<li class="collection-header px-2">
						<h5>
							<i class="material-icons right">equalizer</i> {{ $log->date }}
						</h5>
					</li>

					@foreach($log->menu() as $levelKey => $item)
						@if ($item['count'] === 0)
							<a class="collection-item d-flex justify-content-between align-center main-dark-text">
								<span class="level-name">{{ $item['name'] }}</span>
								<span class="badge">{{ $item['count'] }}</span>
							</a>
						@else
							<a href="{{ $item['url'] }}" class="collection-item d-flex justify-content-between align-center main-dark-text {{ $level === $levelKey ? ' main-light' : ''}}">
								<span class="level-name">{{ $item['name'] }}</span>
								<span class="new badge">{{ $item['count'] }}</span>
							</a>
						@endif
					@endforeach
				</ul>
			</div>
		</div>
		<div class="col s12 m8 l9">
			<div class="mb-4"> {{-- Log Details --}}
				<div class="p-2">
					{{-- Back button --}}
					<a href="/log-viewer/logs" class="btn right">
						<i class="material-icons right">keyboard_arrow_right</i> @lang('messages.back')
					</a>
					{{-- Download button --}}
					<a href="{{ route('log-viewer::logs.download', [$log->date]) }}" class="btn" title="@lang('messages.download')">
						<i class="material-icons">file_download</i>
					</a>
					{{-- Delete button --}}
					<form action="{{ route('log-viewer::logs.delete') }}" method="POST" class="d-inline-block">
						<input type="hidden" name="_method" value="DELETE">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="date" value="{{ $log->date }}">
						<button type="submit" class="btn red" title="@lang('form.deleting')">
							<i class="material-icons">delete</i>
						</button>
					</form>
				</div>
				<ul class="collection">
					<li class="collection-item">
						<div>
							<span>@lang('logs.path_to_file'):</span> 
							{{ $log->getPath() }} <i class="material-icons left">swap_horiz</i>
						</div>
					</li>
					<li class="collection-item">
						<div>
							<span>@lang('logs.all_files'):</span> 
							{{ $entries->total() }} <i class="material-icons left">style</i>
						</div>
					</li>
					<li class="collection-item">
						<div>
							<span>@lang('logs.file_size'):</span> 
							{{ $log->size() }} <i class="material-icons left">memory</i>
						</div>
					</li>
					<li class="collection-item">
						<div>
							<span>@lang('logs.created_at'):</span> 
							{{ $log->createdAt() }} <i class="material-icons left">date_range</i>
						</div>
					</li>
					<li class="collection-item">
						<div>
							<span>@lang('logs.updated_at'):</span> 
							{{ $log->updatedAt() }} <i class="material-icons left">date_range</i>
						</div>
					</li>
				</ul>
				{{-- Search --}}
				<form action="{{ route('log-viewer::logs.search', [$log->date, $level]) }}" method="GET">
					<div class="input-field">
						<i class="material-icons prefix">search</i>
						<input id="search-input" name="query" value="{!! request('query') !!}" placeholder="@lang('pages.search_details')">
					</div>
					<button id="search-btn" class="btn">@lang('includes.search')</button>
					@if (request()->has('query'))
						<a href="{{ route('log-viewer::logs.show', [$log->date]) }}" class="btn">
							@lang('form.cancel')
						</a>
					@endif
				</form>
			</div>

			@if ($entries->hasPages()) {{-- Log Entries --}}
				<div>
					<span class="badge">
						@lang('logs.page') 
						{!! $entries->currentPage() !!} 
						@lang('logs.of') 
						{!! $entries->lastPage() !!}
					</span>
				</div>
			@endif

			<div class="row"> {{-- Log cards --}}
				@forelse($entries as $key => $entry)
					<div class="col s12">
						<div class="card">
							<div class="card-content">
								<span class="card-title activator grey-text text-darken-4">
									<div class="d-inline-block">
										{{ $entry->env }}
									</div>
									<div class="d-inline-block">
										{{ $entry->level }}
									</div>
									<div class="d-inline-block right">
										{{ $entry->datetime->format('H:i:s') }}
									</div>
									<hr />
									{{ $entry->header }}
									<i class="material-icons right">more_vert</i>
								</span>
							</div>
							<div class="card-reveal">
								<span class="card-title grey-text text-darken-4">
									{{ $entry->env }} {{ $entry->level }} {{ $entry->datetime->format('H:i:s') }}
									<i class="material-icons right">close</i>
								</span>
								<p>
									@if ($entry->hasStack())
										{!! $entry->stack() !!}
									@endif
								</p>
							</div>
						</div>
					</div>
				@empty
					<tr>
						<td class="text-center">
							<span class="badge badge-secondary">
								@lang('log-viewer::general.empty-logs')
							</span>
						</td>
					</tr>
				@endforelse
			</div>

			{!! $entries->appends(compact('query'))->render() !!}
		</div> 
	</div>
@endsection
