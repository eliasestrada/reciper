@extends('layouts.app')

@section('content')
    <h2><i class="fa fa-search" aria-hidden="true"></i> Поиск</h2>
    <p>Воспользуйтесь поиском чтобы найти рецепты или категориию рецептов.</p>

    <!-- Form -->
    <form action="" method="POST" class="form">
        <input type="search" name="search" autocomplete="off" placeholder="Искать">
        <button type="submit" style="display: none;"></button>
    </form>

    <!-- Results -->
    <section class="recipes">
        <div>
            <a href="recipe.php">
                <img src="{{ asset('img.jpg') }}" alt="pasta" title="Макароны">
            </a>
            <div class="cards-content">
                <h3>Вермишель</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum culpa neque quo eum et quasi velit voluptatum cum maiores exercitationem.</p>
                <a href="#" title="link"><span class="category">Вторые блюда</span></a>
            </div>
        </div>
        <div>
            <a href="recipe.php">
                <img src="{{ asset('img.jpg') }}" alt="Мясо" title="Мясо">
            </a>
            <div class="cards-content">
                <h3>Мясо</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum culpa neque quo eum et quasi velit voluptatum cum maiores exercitationem.</p>
                <a href="#" title="link"><span class="category">Мясо</span></a>
            </div>
        </div>
    </section>
@endsection