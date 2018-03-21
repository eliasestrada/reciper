@extends('layouts.user')

@section('title', 'Статистика')

@section('content')

    <h2 class="headline">Статистика</h2>

	@if (count($visitors) > 0)
		<div style="padding: 1em 0;">
			@foreach ($visitors as $visitor)
				<?php $geodata = $sxgeo->getCityFull($visitor->ip);?>
				<div class="notification">
					<h4 class="notification-title">{{ $geodata['country']['name_ru'] }} / {{ $geodata['city']['name_ru'] }}</h4>
					<p class="notification-message">Клики: <b>{{ $visitor->clicks }}</b></p>
				</div>
			@endforeach
		</div>
		{{ $visitors->links() }}
	@else
		<p class="content center">У вас пока нет оповещений</p>
	@endif

@endsection