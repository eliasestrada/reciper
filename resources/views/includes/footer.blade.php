<footer>
	<div class="container">
		<div class="row">

			@if (count($footer_rand_recipes) > 0)
				@foreach ($footer_rand_recipes->chunk(4) as $random_chunk)
					<div class="col-xs-6 col-sm-4 zero">
						<ul class="unstyled-list">
							<li><strong>Навигация</strong></li>
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
					<li><a href="/contact">Связь с нами</a></li>
					<li><a href="/contact">Поиск</a></li>
				</ul>
			</div>
		</div>
	</div>
</footer>