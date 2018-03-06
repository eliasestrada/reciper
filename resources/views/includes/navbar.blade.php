<!-- Hamburger menu -->
<div class="regular-menu" id="menu-container">
    <i id="hamburger"><i class="fa fa-bars"></i></i>
</div>

<!-- Navigation menu -->
<nav id="nav-menu" class="nav-closed">
    <a href="/" title="На главную" id="logo" class="logo-closed">
        <h2>{{ config('app.name', 'Delicious Food') }}</h2>
    </a>
    <ul>
        <li><a href="/search" title="Поиск"><i class="fa fa-search"></i></a></li>
        <li><a href="/" title="На главную">Главная</a></li>
        <li><a href="/recipes" title="Рецепты">Рецепты</a></li>

		@auth
            <li>
                <a href="{{ url('/dashboard') }}">Панель</a>
            </li>

            <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Выйти <i class="fa fa-sign-out"></i>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                     @csrf
                </form>
			</li>
        @endguest
    </ul>
</nav>