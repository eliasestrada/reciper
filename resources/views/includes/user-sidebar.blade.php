@author     
	<nav class="user-sidebar">
		<ul>
			<li class="disapear-on-big-screen">
				<a>
					<i style="background: url(/css/icons/svg/cheveron-outline-right.svg)" class="sidebar-icon"></i>
				</a>
			</li>

			{{-- dashboard --}}
			<li class="{{ activeIfRouteIs('dashboard') }}">
				<a href="/dashboard" title="@lang('includes.profile')">
					<i style="background: url(/storage/uploads/{{ user()->image }})" class="sidebar-icon user-icon"></i>
					<span>@lang('includes.profile')</span>
				</a>
			</li>

			{{-- recipes/create --}}
			<li class="{{ activeIfRouteIs('recipes/create') }}">
				<a href="/recipes/create" title="@lang('includes.new_recipe')">
					<i class="sidebar-icon" style="background: url(/css/icons/svg/document-add.svg)"></i>
					<span>@lang('includes.new_recipe')</span>
				</a>
			</li>

			{{-- my recipes --}}
			<li class="{{ activeIfRouteIs('users/my_recipes/all') }}">
				<a href="/users/my_recipes/all" title="@lang('includes.my_recipes')">
					<i style="background: url(/css/icons/svg/document.svg)" class="sidebar-icon"></i>
					<span>@lang('includes.my_recipes')</span>
				</a>
			</li>

			{{-- users --}}
			<li class="{{ activeIfRouteIs('users') }}">
				<a href="/users" title="@lang('includes.users')">
					<i style="background: url(/css/icons/svg/user-group.svg)" class="sidebar-icon"></i>
					<span>@lang('includes.users')</span>
				</a>
			</li>

			@admin
				{{-- statistic --}}
				<li class="{{ activeIfRouteIs('admin/statistic') }}">
					<a href="/admin/statistic" title="@lang('includes.statistics')">
						<i style="background: url(/css/icons/svg/chart-bar.svg)" class="sidebar-icon"></i>
						<span>@lang('includes.statistics')</span>
					</a>
				</li>

				{{-- checklist --}}
				<li class="{{ activeIfRouteIs('admin/checklist') }}">
					<a href="/admin/checklist" title="@lang('includes.checklist')" {{ $allunapproved }} class="red-buttons">
						<i style="background: url(/css/icons/svg/search.svg)" class="sidebar-icon"></i>
						<span>@lang('includes.checklist')</span>
					</a>
				</li>

				{{-- feedback --}}
				<li class="{{ activeIfRouteIs('admin/feedback') }}">
					<a href="/admin/feedback" title="@lang('includes.feedback')" {{ $allfeedback }} class="red-buttons">
						<i style="background: url(/css/icons/svg/conversation.svg);" class="sidebar-icon"></i>
						<span>@lang('includes.feedback')</span>
					</a>
				</li>
			@endadmin

			{{-- notifications --}}
			<li class="{{ activeIfRouteIs('notifications') }}">
				<a href="/notifications" title="@lang('includes.notifications')" {{ $notifications }} class="red-buttons">
					<i style="background: url(/css/icons/svg/notifications.svg)" class="sidebar-icon"></i>
					<span>@lang('includes.notifications')</span>
				</a>
			</li>

			@admin
			{{-- logs --}}
				<li class="{{ activeIfRouteIs('logs') }}">
					<a href="/logs" title="@lang('logs.logs')">
						<i style="background: url(/css/icons/svg/information-outline.svg)" class="sidebar-icon"></i>
						<span>@lang('logs.logs')</span>
					</a>
				</li>
			@endadmin

			{{-- settings --}}
			<li class="remove-hover">
				<a>
					<i style="background: url(/css/icons/svg/cog.svg)" class="sidebar-icon"></i>
					<span class="text-white">@lang('includes.settings')</span>
				</a>
			</li>

			{{-- settings/general --}}
			<li class="{{ activeIfRouteIs('settings/general') }}">
				<a href="/settings/general" title="Общие" >
					<i style="background: url(/css/icons/svg/cheveron-right.svg)" class="sidebar-icon"></i>
					<span>@lang('includes.general')</span>
				</a>
			</li>

			{{-- settings/photo --}}
			<li class="{{ activeIfRouteIs('settings/photo') }}">
				<a href="/settings/photo" title="Фотография">
					<i style="background: url(/css/icons/svg/cheveron-right.svg)" class="sidebar-icon"></i>
					<span>@lang('includes.photo')</span>
				</a>
			</li>

			@admin
				{{-- settings/titles --}}
				<li class="{{ activeIfRouteIs('settings/titles') }}">
					<a href="/settings/titles" title="Заголовки">
						<i style="background: url(/css/icons/svg/cheveron-right.svg)" class="sidebar-icon"></i>
						<span>@lang('includes.titles')</span>
					</a>
				</li>
			@endadmin
		</ul>

		{{-- logout --}}
		<li class="{{ activeIfRouteIs('logout') }}">
			<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Выйти">
				<i style="background: url(/css/icons/svg/stand-by.svg)" class="sidebar-icon"></i>
				<span class="nav-text">@lang('includes.logout')</span>
			</a>
		</li>
	</nav>

	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
		@csrf
	</form>
@endauthor
