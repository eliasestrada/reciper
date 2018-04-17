@extends('layouts.app')

@section('title', 'Статистика')

@section('content')
	
	<table class="statistic-table">
		<caption>Статистика</caption>
		<tr>
			<th scope="col">Страна/Город</th>
			<th scope="col">Клики</th>
		</tr>
		<tr>
			<td scope="row">Рецепты</td>
			<td>{{ $allrecipes }}</td>
		</tr>
		<tr>
			<td scope="row">Посетители</td>
			<td>{{ $visitors->count() }}</td>
		</tr>
		<tr>
			<td scope="row">Клики</td>
			<td>{{ $allclicks }}</td>
		</tr>
	</table>

	<table class="statistic-table">
		<tbody>
			<caption>Клики</caption>
			<tr>
				<th scope="col">Страна / Город</th>
				<th scope="col">Клики</th>
			</tr>
		@forelse ($visitors as $visitor)
			<?php
				$geodata = $sxgeo->getCityFull($visitor->ip);
				$country = $geodata['country']['name_ru'];
				$city = $geodata['city']['name_ru'];
			?>
			<tr>
				<td scope="row">{{ $country }} / {{ $city }}</td>
				<td>{{ $visitor->clicks }}</td>
			</tr>
		@empty
			<p class="content center">У вас пока нет оповещений</p>
		@endforelse
	</table>

	{{ $visitors->links() }}

@endsection