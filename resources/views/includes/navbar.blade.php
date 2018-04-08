{{--  Hamburger menu  --}}
<div class="regular-menu" id="menu-container">
    <div id="hamburger" class="hamburger">
		<span class="lines line1"></span>
		<span class="lines line2"></span>
		<span class="lines line3"></span>
	</div>
</div>

{{--  Navigation menu  --}}
<nav id="nav-menu" class="nav-closed">
	<a href="/" title="На главную" id="logo" class="logo-closed">
		<img src="{{ asset('storage/other/logo.png') }}" alt="Логотип">
    </a>
    <ul>
        <li><a href="/" title="На главную">Главная</a></li>
		<li><a href="/recipes" title="Рецепты">Рецепты</a></li>
		<li><a href="/search" title="Поиск">Поиск</a></li>
		<li id="categories-button" class="categories-button">
			<a class="categories-title">Категории</a>
			<div class="arrow-bottom" id="arrow-bottom"></div>
			<div class="categories-menu" id="categories-menu">
				<a href="/search?for=" title="">
					<span>Блины</span>
				</a>
				<a href="/search?for=" title="">
					<span>Что-то</span>
				</a>
				<a href="/search?for=" title="">
					<span>Мясо</span>
				</a>
			</div>
		</li>
    </ul>
</nav>