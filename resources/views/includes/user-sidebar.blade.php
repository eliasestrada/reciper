@author     
	<nav class="user-sidebar">
		<ul>
			<li class="disapear-on-big-screen">
				<a>
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -75px -25px;" class="icon-profile-menu-line"></i>
				</a>
			</li>
			<li>
				<a href="/dashboard" title="Профиль">
					<i style="background: url({{ asset('/storage/uploads/' . user()->image) }});" class="icon-profile-menu-line user-icon"></i>
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
			@admin
				<li>
					<a href="/admin/statistic" title="Статистика">
						<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -25px 0;" class="icon-profile-menu-line"></i>
						<span>Статистика</span>
					</a>
				</li>
				<li>
					<a href="/admin/checklist" title="Проверочная" {{ $allunapproved }} class="red-buttons">
						<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -50px -50px;" class="icon-profile-menu-line"></i>
						<span>Проверочная</span>
					</a>
				</li>
				<li>
					<a href="/admin/feedback" title="Обратная связь" {{ $allfeedback }} class="red-buttons">
						<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) 0 -50px;" class="icon-profile-menu-line"></i>
						<span>Обратная связь</span>
					</a>
				</li>
			@endadmin
			<li>
				<a href="/notifications" title="Оповещения" {{ $notifications }} class="red-buttons">
					<i style="background: url({{ asset('/css/icons/admin-sprite.png') }}) -25px -50px;" class="icon-profile-menu-line"></i>
					<span>Оповещения</span>
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

				@admin
					<a href="/settings/titles" title="Заголовки">
						<span>Заголовки</span>
					</a>
				@endadmin
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
@endauthor
