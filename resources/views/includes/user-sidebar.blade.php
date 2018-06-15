@author

<nav class="user-sidebar" id="user-sidebar">
	<ul>
		{{-- Profile --}}
		<li class="{{ activeIfRouteIs('users/*') }}">
			<a href="/users/{{ user()->id }}" title="@lang('includes.profile')">
				<i class="material-icons sidebar-icon">person</i>
				<span>@lang('includes.profile')</span>
			</a>
		</li>

		{{-- recipes/create --}}
		<li class="{{ activeIfRouteIs('recipes/create') }}">
			<a href="/recipes/create" title="@lang('includes.new_recipe')">
				<i class="material-icons sidebar-icon">add</i>
				<span>@lang('includes.new_recipe')</span>
			</a>
		</li>

		{{-- my recipes --}}
		<li class="{{ activeIfRouteIs('users/other/my_recipes') }}">
			<a href="/users/other/my_recipes" title="@lang('includes.my_recipes')">
				<i class="material-icons sidebar-icon">insert_drive_file</i>
				<span>@lang('includes.my_recipes')</span>
			</a>
		</li>

		{{-- users --}}
		<li class="{{ activeIfRouteIs('users') }}">
			<a href="/users" title="@lang('includes.users')" {{ $all_new_users ?? '' }} class="small-notif-btn">
				<i class="material-icons sidebar-icon">people</i>
				<span>@lang('includes.users')</span>
			</a>
		</li>

		@admin
			{{-- statistic --}}
			<li class="{{ activeIfRouteIs('admin/statistic') }}">
				<a href="/admin/statistic" title="@lang('includes.statistics')">
					<i class="material-icons sidebar-icon">insert_chart</i>
					<span>@lang('includes.statistics')</span>
				</a>
			</li>

			{{-- checklist --}}
			<li class="{{ activeIfRouteIs('admin/checklist') }}">
				<a href="/admin/checklist" title="@lang('includes.checklist')" {{ $all_unapproved ?? '' }} class="small-notif-btn">
					<i class="material-icons sidebar-icon">search</i>
					<span>@lang('includes.checklist')</span>
				</a>
			</li>

			{{-- feedback --}}
			<li class="{{ activeIfRouteIs('admin/feedback') }}">
				<a href="/admin/feedback" title="@lang('includes.feedback')" {{ $all_feedback ?? '' }} class="small-notif-btn">
					<i class="material-icons sidebar-icon">feedback</i>
					<span>@lang('includes.feedback')</span>
				</a>
			</li>
		@endadmin

		{{-- notifications --}}
		<li class="{{ activeIfRouteIs('notifications') }}">
			<a href="/users/other/notifications" title="@lang('includes.notifications')" {{ $notifications ?? '' }} class="small-notif-btn">
				<i class="material-icons sidebar-icon">notifications</i>
				<span>@lang('includes.notifications')</span>
			</a>
		</li>

		{{-- settings/general --}}
		<li class="{{ activeIfRouteIs('settings/general') }}">
			<a href="/settings/general" title="Общие" >
				<i class="material-icons sidebar-icon">build</i>
				<span>@lang('includes.general')</span>
			</a>
		</li>

		{{-- settings/photo --}}
		<li class="{{ activeIfRouteIs('settings/photo') }}">
			<a href="/settings/photo" title="Фотография">
				<i class="material-icons sidebar-icon">build</i>
				<span>@lang('includes.photo')</span>
			</a>
		</li>
		{{-- logout --}}
		<li class="{{ activeIfRouteIs('logout') }}">
			<form id="logout-form" action="{{ route('logout') }}" method="POST">
				@csrf
				<button type="submit" class="py-2" id="logout-btn">
					<i class="material-icons sidebar-icon">power_settings_new</i>
					<span class="nav-text">@lang('includes.logout')</span>
				</button>
			</form>
		</li>
	</ul>

</nav>

@endauthor
