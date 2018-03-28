<div class="profile-menu-line">

	{{--  Профиль  --}}
	<a href="/dashboard" title="Профиль" id="my-profile">
		<i style="background: url({{ asset('/css/icons/user.png') }}) center; background-size: 20px;" class="icon-profile-menu-line"></i>
	</a>

	{{--  Мои рецепты  --}}
	<a href="/my_recipes" title="Мои рецепты" id="my-resipes">
		<i style="background: url({{ asset('/css/icons/docs.png') }}) center; background-size: 20px;" class="icon-profile-menu-line"></i>
	</a>

	{{--  Авторы  --}}
	<a href="/users" title="Авторы" id="all-users">
		<i style="background: url({{ asset('/css/icons/users.png') }}) center; background-size: 30px; width: 30px;" class="icon-profile-menu-line"></i>
	</a>

	{{--  Настройки  --}}
	<a href="/settings" title="Настройки" id="settings">
		<i style="background: url({{ asset('/css/icons/gear.png') }}) center; background-size: 20px;" class="icon-profile-menu-line"></i>
	</a>
</div>