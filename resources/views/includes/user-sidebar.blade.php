@auth     
	<nav class="user-sidebar">
		<ul>
			<li id="hide-on-big-screen">
				<a>
					<i class="icon-profile-menu-line"></i>
					<span class="nav-text">&darr; Меню</span>
				</a>
			</li>
			<li>
				<a href="/dashboard" title="Профиль">
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) 0 -25px;" class="icon-profile-menu-line"></i>
					<span class="nav-text">Профиль</span>
				</a>
			</li>
			<li>
				<a href="/recipes/create" title="Добавить рецепт">
					<i class="icon-profile-menu-line" style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -75px 0px;"></i>
					<span class="nav-text">Новый рецепт</span>
				</a>
			</li>
			<li>
				<a href="/my_recipes" title="Мои рецепты">
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }})" class="icon-profile-menu-line"></i>
					<span class="nav-text">Мои рецепты</span>
				</a>
			</li>
			<li>
				<a href="/users" title="Пользователи">
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -25px -25px;" class="icon-profile-menu-line"></i>
					<span class="nav-text">Пользователи</span>
				</a>
			</li>

			{{--  For admin  --}}
			@if (Auth::user()->admin === 1)
				<li>
					<a href="/statistic" title="Статистика">
						<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -25px 0;" class="icon-profile-menu-line"></i>
						<span class="nav-text">Статистика</span>
					</a>
				</li>
			@endif

			<li>
				<a href="/settings" title="Настройки">
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -50px 0;" class="icon-profile-menu-line"></i>
					<span class="nav-text">Настройки</span>
				</a>
			</li>
		</ul>
		<ul class="logout">
			<li>
				<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Выйти">
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -50px -25px;" class="icon-profile-menu-line"></i>
					<span class="nav-text">Выйти</span>
				</a>
			</li>  
		</ul>
	</nav>

	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
		@csrf
	</form>
@endauth
