<footer>
	<div class="container">
		<div class="row">

			@if (count($footer_rand_recipes) > 0)
				@foreach ($footer_rand_recipes->chunk(4) as $random_chunk)
					<div class="col-xs-6 col-sm-4 zero">
						<ul class="unstyled-list">
							<li><strong>Рецепты</strong></li>
							@foreach ($random_chunk as $footer_recipe)
								<li><a href="/recipes/{{ $footer_recipe->id }}" ti>{{ $footer_recipe->title }}</a></li>
							@endforeach
						</ul>
					</div>
				@endforeach
			@endif

			<div class="col-xs-12 col-sm-4 zero">
				<ul class="unstyled-list">
					<li><strong>Навигация</strong></li>
					<li><a href="/">Главная</a></li>
					<li><a href="/recipes">Рецепты</a></li>
					<li><a href="/contact">Обратная связь</a></li>
					<li><a href="/contact">Поиск</a></li>
					<a href="/" title="На главную">
						<img src="{{ asset('favicon.png') }}" alt="Логотип" class="footer-logo">
					</a>
					<br />
					<p class="footer-copyright">&copy; {{ date('Y') }} Delicious Food</p>
				</ul>
			</div>
		</div>
	</div>
</footer>