@extends('layouts.app')

@section('content')
    <!-- Header header -->
    <header class="header">
        <div class="bg-image"></div>
        <div class="card-content">
            <h1>{{ $title }}</h1>
            <p>Lorem ipsm, dolor sit amet consectetur adipisicing elit. Adipisci eum error earum soluta voluptatum nisi laboriosam eos saepe asperiores dolorum.</p>
            <a href="{{ url('/search') }}" class="button">Искать</a>
        </div>
    </header>

    <section class="wrapper" style="min-height:auto; padding: 1rem .8rem .93rem .8rem;">
        <h2>Куховарим вместе</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe sint eligendi possimus? Unde officiis magnam laborum ipsa distinctio odio, vero dolores dicta aliquam aperiam repellendus. Perferendis officiis deserunt velit voluptas nobis sequi animi totam, accusantium, ex eius quia, natus quo?</p>
    </section>

    <!-- Cards -->
    <section id="cards" class="grid-cards">
        <ul>
            <li>
                <div class="card">
                    <a href="recipe.php">
                        <img src="{{ asset('img.jpg') }}" alt="Вермишель" title="Вермишель">
                    </a>
                    <div class="cards-content">
                        <h3>Вермишель</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum culpa neque quo eum et quasi velit voluptatum cum maiores exercitationem.</p>
                    </div>
                </div>
            </li>
            <li>
                <div class="card">
                    <a href="recipe.php">
                        <img src="{{ asset('img.jpg') }}" alt="Мясо" title="Мясо">
                    </a>
                    <div class="cards-content">
                        <h3>Мясо</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum culpa neque quo eum et quasi velit voluptatum cum maiores exercitationem.</p>
                    </div>
                </div>
            </li>
            <li>
                <div class="card">
                    <a href="recipe.php">
                        <img src="{{ asset('img.jpg') }}" alt="Зелень" title="Зелень">
                    </a>
                    <div class="cards-content">
                        <h3>Зелень</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum culpa neque quo eum et quasi velit voluptatum cum maiores exercitationem.</p>
                    </div>
                </div>
            </li>
        </ul>
    </section>

    <!-- Final -->
    <section class="wrapper" style="min-height:auto; padding: 1rem .8rem .93rem .8rem;">
        <h2 class="content-title">Какой-то текст</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe sint eligendi possimus? Unde officiis magnam laborum ipsa distinctio odio, vero dolores dicta aliquam aperiam repellendus. Perferendis officiis deserunt velit voluptas nobis sequi
            animi totam, accusantium, ex eius quia, natus quo?</p>
    </section>
@endsection