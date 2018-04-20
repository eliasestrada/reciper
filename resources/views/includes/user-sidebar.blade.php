@auth     
	<nav class="user-sidebar">
		<ul>
			<li class="disapear-on-big-screen">
				<a>
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -75px -25px;" class="icon-profile-menu-line"></i>
				</a>
			</li>
			<li>
				<a href="/dashboard" title="Профиль">
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) 0 -25px;" class="icon-profile-menu-line"></i>
					<span>Профиль</span>
				</a>
			</li>
			<li>
				<a href="/recipes/create" title="Добавить рецепт">
					<i class="icon-profile-menu-line" style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -75px 0px;"></i>
					<span>Новый рецепт</span>
				</a>
			</li>
			<li>
				<a href="/my_recipes" title="Мои рецепты">
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }})" class="icon-profile-menu-line"></i>
					<span>Мои рецепты</span>
				</a>
			</li>
			<li>
				<a href="/users" title="Пользователи">
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -25px -25px;" class="icon-profile-menu-line"></i>
					<span>Пользователи</span>
				</a>
			</li>
			<li>
				<a href="/statistic" title="Статистика">
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -25px 0;" class="icon-profile-menu-line"></i>
					<span>Статистика</span>
				</a>
			</li>
			<li>
				<a>
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -50px 0;" class="icon-profile-menu-line"></i>
					<span>Настройки</span>
				</a>
			</li>

			{{-- Menu Second Level --}}
			<div class="menu-second-level">
				<a href="/settings/general" title="Общие">
					<span>Общие</span>
				</a>
				<a href="/settings/photo" title="Фотография">
					<span>Фотография</span>
				</a>

				{{--  Для Админов  --}}
				@if (user()->isAdmin())
					<a href="/settings/titles" title="Заголовки">
						<span>Заголовки</span>
					</a>
				@endif
			</div>
		</ul>
		<li>
			<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Выйти">
				<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -50px -25px;" class="icon-profile-menu-line"></i>
				<span class="nav-text">Выйти</span>
			</a>
		</li>
	</nav>

	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
		@csrf
	</form>
@endauth
