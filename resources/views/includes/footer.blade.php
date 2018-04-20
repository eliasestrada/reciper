<footer>
	<div class="container">
		<div class="row">

			{{--  Random recipes  --}}
			@foreach ($footer_rand_recipes->chunk(4) as $random_chunk)
				<div class="col-xs-6 col-sm-4">
					<ul class="unstyled-list">
						<li><strong>Рецепты</strong></li>
						@foreach ($random_chunk as $footer_recipe)
							<li>
								<a href="/recipes/{{ $footer_recipe->id }}" title="{{ $footer_recipe->title }}">
									{{ $footer_recipe->title }}
								</a>
							</li>
						@endforeach
					</ul>
				</div>
			@endforeach

			{{--  Navigation  --}}
			<div class="col-xs-12 col-sm-4">
				<ul class="unstyled-list">
					<li><strong>Навигация</strong></li>
					<li><a href="/">Главная</a></li>
					<li><a href="/recipes">Рецепты</a></li>
					<li><a href="/contact">Обратная связь</a></li>
					<li><a href="/search">Поиск</a></li>
				</ul>
			</div>
		</div>

		<a href="/" title="На главную">
			<img src="{{ asset('favicon.png') }}" alt="Логотип" class="footer-logo">
		</a>

		<p class="footer-copyright">
			&copy; {{ date('Y') }} Delicious Food {{ optional($title_footer)->text }}
		</p>

		<p class="footer-copyright">
			Дизайн и создание: <a href="https://www.upwork.com/o/profiles/users/_~01f3e73b66ebe1e87b/" style="color:#8080ff;">Сергей Черненький</a>
		</p>
	</div>
</footer>