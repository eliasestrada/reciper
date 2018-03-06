@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <!-- Home Header -->
    <header class="home-header">
        <div class="header-bg-image"></div>
        <div class="header-content">
            <h1>Delicious Food</h1>
            <p>Lorem ipsm, dolor sit amet consectetur adipisicing elit. Adipisci eum error earum soluta voluptatum nisi laboriosam eos saepe asperiores dolorum.</p>
            <a href="/search" class="button" style="box-shadow:none;">Искать</a>
        </div>
    </header>

    <section class="home-section">
		<h2 class="headline">Куховарим вместе</h2>
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe sint eligendi possimus? Unde officiis magnam laborum ipsa distinctio odio, vero dolores dicta aliquam aperiam repellendus. Perferendis officiis deserunt velit voluptas nobis sequi animi totam, accusantium, ex eius quia, natus quo?</p>
		</div>
    </section>

    <!-- Cards -->
    <section class="home-section recipes">
		@if (count($random_recipes) > 0)
			@foreach ($random_recipes as $random)
				<div class="home-card">
					<!-- Image -->
					<a href="/recipes/{{ $random->id }}">
						<img src="{{ asset('storage/images/'.$random->image) }}" alt="{{$random->title}}" title="{{$random->title}}">
					</a>
				</div>
			@endforeach
		@endif
    </section>

    <!-- Final -->
    <section class="home-section">
        <h2 class="headline">Какой-то текст</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe sint eligendi possimus? Unde officiis magnam laborum ipsa distinctio odio, vero dolores dicta aliquam aperiam repellendus. Perferendis officiis deserunt velit voluptas nobis sequi
            animi totam, accusantium, ex eius quia, natus quo?</p>
    </section>
@endsection