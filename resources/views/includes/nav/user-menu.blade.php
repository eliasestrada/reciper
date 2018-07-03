<li class="{{ activeIfRouteIs('users/' . user()->id) }}"> {{-- profile --}}
	<a href="/users/{{ user()->id }}" title="@lang('includes.profile')">
		<i class="left user-icon">
			<img class="user-icon-small" src="{{ asset('storage/users/' . user()->image) }}" alt="user">
		</i>
		@lang('includes.profile')
	</a>
</li>

<li class="{{ activeIfRouteIs('users/other/my-recipes') }}"> {{-- my recipes --}}
	<a href="/users/other/my-recipes" title="@lang('includes.my_recipes')">
		<i class="material-icons left">insert_drive_file</i>@lang('includes.my_recipes')
	</a>
</li>

<li class="{{ activeIfRouteIs('users') }}"> {{-- users --}}
	<a href="/users" title="@lang('includes.users')">
		<i class="material-icons left">people</i>@lang('includes.users')
	</a>
</li>

@admin
	<li class="{{ activeIfRouteIs('admin/statistic') }}"> {{-- statistic --}}
		<a href="/admin/statistic" title="@lang('includes.statistics')">
			<i class="material-icons left">insert_chart</i>@lang('includes.statistics')
		</a>
	</li>

	<li class="position-relative {{ activeIfRouteIs('admin/checklist') }}"> {{-- checklist --}}
		<a href="/admin/checklist" title="@lang('includes.checklist')" {{ $all_unapproved ?? '' }} class="small-notif-btn">
			<i class="material-icons left">search</i>@lang('includes.checklist')
		</a>
	</li>

	<li class="position-relative {{ activeIfRouteIs('admin/feedback') }}"> {{-- feedback --}}
		<a href="/admin/feedback" title="@lang('includes.feedback')" {{ $all_feedback ?? '' }} class="small-notif-btn">
			<i class="material-icons left">feedback</i>@lang('includes.feedback')
		</a>
	</li>
@endadmin

<li class="position-relative {{ activeIfRouteIs('notifications') }}"> {{-- notifications --}}
	<a href="/notifications" title="@lang('includes.notifications')" {{ $notifications ?? '' }} class="small-notif-btn">
		<i class="material-icons left">notifications</i>@lang('includes.notifications')
	</a>
</li>

<li class="{{ activeIfRouteIs('settings/general') }}"> {{-- settings/general --}}
	<a href="/settings/general" title="@lang('includes.general')" >
		<i class="material-icons left">build</i>@lang('includes.general')
	</a>
</li>

<li class="{{ activeIfRouteIs('settings/photo') }}"> {{-- settings/photo --}}
	<a href="/settings/photo" title="@lang('includes.photo')">
		<i class="material-icons left">build</i>@lang('includes.photo')
	</a>
</li>

@master
	<li class="position-relative {{ activeIfRouteIs('log-viewer/logs*') }}"> {{-- log-viewer --}}
		<a href="/log-viewer/logs" title="@lang('logs.logs')" {{ $all_logs ?? '' }} class="small-notif-btn">
			<i class="material-icons left">library_books</i>@lang('logs.logs')
		</a>
	</li>
@endmaster

<li> {{-- logout --}} {{-- This button submits logout-form --}}
	<a href="#" title="@lang('includes.logout')" onclick="$('logout-form').submit()" id="_logout_btn">
		<i class="material-icons left">power_settings_new</i>@lang('includes.logout')
	</a>
</li>

{{-- logout-form --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
	@csrf <button type="submit"></button>
</form>