@extends('layouts.app')

@section('title', trans('admin.statistics'))

@section('content')

<table class="statistic-table">
	<caption>@lang('admin.statistics')</caption>
	<tr>
		<th scope="col">@lang('admin.country_and_city')</th>
		<th scope="col">@lang('admin.clicks')</th>
	</tr>
	<tr>
		<td scope="row">Рецепты</td>
		<td>{{ $allrecipes }}</td>
	</tr>
	<tr>
		<td scope="row">Посетители</td>
		<td>{{ $allvisitors }}</td>
	</tr>
	<tr>
		<td scope="row">@lang('admin.clicks')</td>
		<td>{{ $allclicks }}</td>
	</tr>
</table>

<table class="statistic-table">
	<tbody>
		<caption>@lang('admin.clicks')</caption>
		<tr>
			<th scope="col">@lang('admin.country_and_city')</th>
			<th scope="col">@lang('admin.clicks')</th>
		</tr>
	@foreach ($visitors as $visitor)
		<?php
			$geodata = $sxgeo->getCityFull($visitor->ip);
			$country = $geodata['country']['name_ru'];
			$city = $geodata['city']['name_ru'];
		?>
		<tr>
			<td scope="row">{{ $country }} / {{ $city }}</td>
			<td>{{ $visitor->clicks }}</td>
		</tr>
	@endforeach
</table>

{{ $visitors->links() }}

@endsection