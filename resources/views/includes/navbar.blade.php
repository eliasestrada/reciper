<!-- Hamburger menu -->
<div class="regular-menu" id="menu-container">
    <i id="hamburger"><i class="fa fa-bars"></i></i>
</div>

<!-- Navigation menu -->
<nav id="nav-menu" class="nav-closed">
	<a href="/" title="На главную" id="logo" class="logo-closed">
		<img src="{{ asset('storage/other/logo.png') }}" alt="Логотип">
    </a>
    <ul>
        <li><a href="/search" title="Поиск"><i class="fa fa-search"></i></a></li>
        <li><a href="/" title="На главную">Главная</a></li>
        <li><a href="/recipes" title="Рецепты">Рецепты</a></li>

		@auth
            <li>
                <a href="{{ url('/dashboard') }}">Профиль</a>
            </li>
        @endguest
    </ul>
</nav>