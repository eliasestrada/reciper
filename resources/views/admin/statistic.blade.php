@extends('layouts.app')

@section('title', trans('admin.statistics'))

@section('content')

<div class="container pb-5">
	<div class="center-align pt-4">
		<h1 class="headline mb-3">@lang('admin.statistics')</h1>
	</div>

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

	<div class="center-align pt-5">
		<h2 class="headline mb-3">@lang('admin.visitors')</h2>
	</div>

	<table class="statistic-table">
		<tbody>
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
</div>

{{ $visitors->links() }}

@endsection