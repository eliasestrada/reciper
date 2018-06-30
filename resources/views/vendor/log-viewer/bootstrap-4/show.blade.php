@extends('layouts.logs')

@section('content')
    <div class="page-header mb-4">
        <h5>Log [{{ $log->date }}]</h5>
    </div>

    <div class="row">
        <div class="col l3">
            {{-- Log Menu --}}
            <div class="card mb-4">
                <div class="card-header"><i class="fa fa-fw fa-flag"></i> Levels</div>
                <div class="list-group list-group-flush log-menu">
                    @foreach($log->menu() as $levelKey => $item)
                        @if ($item['count'] === 0)
                            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center disabled">
                                <span class="level-name">{!! $item['icon'] !!} {{ $item['name'] }}</span>
                                <span class="badge empty">{{ $item['count'] }}</span>
                            </a>
                        @else
                            <a href="{{ $item['url'] }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center level-{{ $levelKey }}{{ $level === $levelKey ? ' active' : ''}}">
                                <span class="level-name">{!! $item['icon'] !!} {{ $item['name'] }}</span>
                                <span class="badge badge-level-{{ $levelKey }}">{{ $item['count'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col l8">
            {{-- Log Details --}}
            <div class="card mb-4">
                <div class="card-header">
                    Log info :
                    <div class="group-btns pull-right">
                        <a href="{{ route('log-viewer::logs.download', [$log->date]) }}" class="btn btn-sm btn-success">
                            <i class="fa fa-download"></i> DOWNLOAD
                        </a>
                        <a href="#delete-log-modal" class="btn btn-sm btn-danger" data-toggle="modal">
                            <i class="fa fa-trash-o"></i> DELETE
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-condensed mb-0">
                        <tbody>
                            <tr>
                                <td>File path :</td>
                                <td colspan="7">{{ $log->getPath() }}</td>
                            </tr>
                            <tr>
                                <td>Log entries : </td>
                                <td>
                                    <span class="badge badge-primary">{{ $entries->total() }}</span>
                                </td>
                                <td>Size :</td>
                                <td>
                                    <span class="badge badge-primary">{{ $log->size() }}</span>
                                </td>
                                <td>Created at :</td>
                                <td>
                                    <span class="badge badge-primary">{{ $log->createdAt() }}</span>
                                </td>
                                <td>Updated at :</td>
                                <td>
                                    <span class="badge badge-primary">{{ $log->updatedAt() }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{-- Search --}}
                    <form action="{{ route('log-viewer::logs.search', [$log->date, $level]) }}" method="GET">
                        <div class="form-group">
                            <div class="input-group">
                                <input id="query" name="query" class="form-control"  value="{!! request('query') !!}" placeholder="Type here to search">
                                <div class="input-group-append">
                                    @if (request()->has('query'))
                                        <a href="{{ route('log-viewer::logs.show', [$log->date]) }}" class="btn btn-secondary">
                                            <i class="fa fa-fw fa-times"></i>
                                        </a>
                                    @endif
                                    <button id="search-btn" class="btn btn-primary">
                                        <span class="fa fa-fw fa-search"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Log Entries --}}
			@if ($entries->hasPages())
				<div class="card-header">
					<span class="badge badge-info float-right">
						Page {!! $entries->currentPage() !!} of {!! $entries->lastPage() !!}
					</span>
				</div>
			@endif

			<div class="row">
				@forelse($entries as $key => $entry)
					<div class="col s12">
						<div class="card">
							<div class="card-content">
								<span class="card-title activator grey-text text-darken-4">
									{{ $entry->env }} {{ $entry->level }} {{ $entry->datetime->format('H:i:s') }} <br /><hr />
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
						<td colspan="5" class="text-center">
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

@section('modals')
    {{-- DELETE MODAL --}}
    <div id="delete-log-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="delete-log-form" action="{{ route('log-viewer::logs.delete') }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="date" value="{{ $log->date }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">DELETE LOG FILE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to <span class="badge badge-danger">DELETE</span> this log file <span class="badge badge-primary">{{ $log->date }}</span> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary mr-auto" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">DELETE FILE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            var deleteLogModal = $('div#delete-log-modal'),
                deleteLogForm  = $('form#delete-log-form'),
                submitBtn      = deleteLogForm.find('button[type=submit]');

            deleteLogForm.on('submit', function(event) {
                event.preventDefault();
                submitBtn.button('loading');

                $.ajax({
                    url:      $(this).attr('action'),
                    type:     $(this).attr('method'),
                    dataType: 'json',
                    data:     $(this).serialize(),
                    success: function(data) {
                        submitBtn.button('reset');
                        if (data.result === 'success') {
                            deleteLogModal.modal('hide');
                            location.replace("{{ route('log-viewer::logs.list') }}");
                        }
                        else {
                            alert('OOPS ! This is a lack of coffee exception !')
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(errorThrown);
                        submitBtn.button('reset');
                    }
                });

                return false;
            });

            @unless (empty(log_styler()->toHighlight()))
            $('.stack-content').each(function() {
                var $this = $(this);
                var html = $this.html().trim()
                    .replace(/({!! join(log_styler()->toHighlight(), '|') !!})/gm, '<strong>$1</strong>');

                $this.html(html);
            });
            @endunless
        });
    </script>
@endsection
