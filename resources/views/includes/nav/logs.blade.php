<nav>
	<div class="nav-wrapper main" style="z-index:15">
		<div class="px-3">
			<ul>
				<li>
					<a href="{{ route('log-viewer::dashboard') }}">
						<i class="fa fa-dashboard"></i> @lang('logs.dashboard')
					</a>
				</li>
				<li>
					<a href="{{ route('log-viewer::logs.list') }}">
						<i class="fa fa-archive"></i> @lang('logs.logs')
					</a>
				</li>
			</ul>
		</div>
	</div>
</nav>