<!-- Hamburger menu -->
<div class="regular-menu" id="menu-container">
    <div id="hamburger" class="hamburger">
		<span class="lines line1"></span>
		<span class="lines line2"></span>
		<span class="lines line3"></span>
	</div>
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