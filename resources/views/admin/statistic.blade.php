@extends('layouts.app')

@section('title', trans('admin.statistics'))

@section('content')

<h1 class="headline mb-3">@lang('admin.statistics')</h1>

<table class="statistic-table">
	<tr>
		<th scope="col"></th>
		<th scope="col"></th>
	</tr>
	<tr>
		<td scope="row">@lang('admin.recipes')</td>
		<td>{{ $allrecipes }}</td>
	</tr>
	<tr>
		<td scope="row">@lang('admin.visitors')</td>
		<td>{{ $allvisitors }}</td>
	</tr>
</table>

<table class="statistic-table">
	<tbody>
		<caption>@lang('admin.visitors')</caption>
		<tr>
			<th scope="col">@lang('admin.country_and_city')</th>
			<th scope="col">@lang('admin.requests')</th>
		</tr>
	@foreach ($visitors as $visitor)
		<?php
			$geodata = $sxgeo->getCityFull($visitor->ip);
			$country = $geodata['country']['name_ru'];
			$city = $geodata['city']['name_ru'];
		?>
		<tr>
			<td scope="row">{{ $country }} / {{ $city }}</td>
			<td>{{ $visitor->requests }}</td>
		</tr>
	@endforeach
</table>

{{ $visitors->links() }}

@endsection