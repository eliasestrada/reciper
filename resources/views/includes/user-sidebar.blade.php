@author     
	<nav class="user-sidebar">
		<ul>
			<li class="disapear-on-big-screen">
				<a>
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -75px -25px;" class="icon-profile-menu-line"></i>
				</a>
			</li>
			<li class="{{ activeIfRouteIs('dashboard') }}">
				<a href="/dashboard" title="@lang('includes.profile')">
					<i style="background: url({{ asset('/storage/uploads/' . user()->image) }});" class="icon-profile-menu-line user-icon"></i>
					<span>@lang('includes.profile')</span>
				</a>
			</li>
			<li class="{{ activeIfRouteIs('recipes/create') }}">
				<a href="/recipes/create" title="@lang('includes.new_recipe')">
					<i class="icon-profile-menu-line" style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -75px 0px;"></i>
					<span>@lang('includes.new_recipe')</span>
				</a>
			</li>
			<li class="{{ activeIfRouteIs('users/my_recipes/all') }}">
				<a href="/users/my_recipes/all" title="@lang('includes.my_recipes')">
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }})" class="icon-profile-menu-line"></i>
					<span>@lang('includes.my_recipes')</span>
				</a>
			</li>
			<li class="{{ activeIfRouteIs('users') }}">
				<a href="/users" title="@lang('includes.users')">
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -25px -25px;" class="icon-profile-menu-line"></i>
					<span>@lang('includes.users')</span>
				</a>
			</li>
			@admin
				<li class="{{ activeIfRouteIs('admin/statistic') }}">
					<a href="/admin/statistic" title="@lang('includes.statistics')">
						<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -25px 0;" class="icon-profile-menu-line"></i>
						<span>@lang('includes.statistics')</span>
					</a>
				</li>
				<li class="{{ activeIfRouteIs('admin/checklist') }}">
					<a href="/admin/checklist" title="@lang('includes.checklist')" {{ $allunapproved }} class="red-buttons">
						<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -50px -50px;" class="icon-profile-menu-line"></i>
						<span>@lang('includes.checklist')</span>
					</a>
				</li>
				<li class="{{ activeIfRouteIs('admin/feedback') }}">
					<a href="/admin/feedback" title="@lang('includes.feedback')" {{ $allfeedback }} class="red-buttons">
						<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) 0 -50px;" class="icon-profile-menu-line"></i>
						<span>@lang('includes.feedback')</span>
					</a>
				</li>
			@endadmin
			<li class="{{ activeIfRouteIs('notifications') }}">
				<a href="/notifications" title="@lang('includes.notifications')" {{ $notifications }} class="red-buttons">
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -25px -50px;" class="icon-profile-menu-line"></i>
					<span>@lang('includes.notifications')</span>
				</a>
			</li>
			<li>
				<a title="@lang('includes.settings')">
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -50px 0;" class="icon-profile-menu-line"></i>
					<span>@lang('includes.settings')</span>
				</a>
			</li>

			{{-- Menu Second Level --}}
			<div class="menu-second-level">
				<a href="/settings/general" title="Общие" class="{{ activeIfRouteIs('settings/general') }}">
					<span>@lang('includes.general')</span>
				</a>
				<a href="/settings/photo" title="Фотография" class="{{ activeIfRouteIs('settings/photo') }}">
					<span>@lang('includes.photo')</span>
				</a>

				@admin
					<a href="/settings/titles" title="Заголовки" class="{{ activeIfRouteIs('settings/titles') }}">
						<span>@lang('includes.titles')</span>
					</a>
				@endadmin
			</div>
		</ul>
		<li class="{{ activeIfRouteIs('logout') }}">
			<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Выйти">
				<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -50px -25px;" class="icon-profile-menu-line"></i>
				<span class="nav-text">@lang('includes.logout')</span>
			</a>
		</li>
	</nav>

	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
		@csrf
	</form>
@endauthor
