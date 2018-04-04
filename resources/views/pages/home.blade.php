@extends('layouts.app')

@section('title', 'Главная')

@section('content')
	{{--  Home Header  --}}
    <header class="home-header">
		<div class="header-bg-img"></div>
		<div class="header-bg-overlay"></div>
        <div class="header-content">
            <h1>{{ $title_banner->title }}</h1>
			<h2>{{ $title_banner->text }}</h2>
			<a class="home-button" id="home-search-btn">
				<svg viewBox="0 0 250.313 250.313" width="30px" style="fill:#fff; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);">
					<path d="M244.186,214.604l-54.379-54.378c-0.289-0.289-0.628-0.491-0.93-0.76
					c10.7-16.231,16.945-35.66,16.945-56.554C205.822,46.075,159.747,0,102.911,0S0,46.075,0,102.911
					c0,56.835,46.074,102.911,102.91,102.911c20.895,0,40.323-6.245,56.554-16.945c0.269,0.301,0.47,0.64,0.759,0.929l54.38,54.38
					c8.169,8.168,21.413,8.168,29.583,0C252.354,236.017,252.354,222.773,244.186,214.604z M102.911,170.146
					c-37.134,0-67.236-30.102-67.236-67.235c0-37.134,30.103-67.236,67.236-67.236c37.132,0,67.235,30.103,67.235,67.236
					C170.146,140.044,140.043,170.146,102.911,170.146z"/>
				</svg>
			</a>

			{{--  Form  --}}
			{!! Form::open(['action' => 'PagesController@search', 'method' => 'GET', 'class' => 'header-search']) !!}
				<div class="form-group">
					{{ Form::text('for', '', ['id' => 'header-search-input', 'placeholder' => 'Введите критерии поиска...']) }}
					{{ Form::submit('', ['style' => 'display:none']) }}
				</div>
			{!! Form::close() !!}
        </div>
    </header>

    <section class="home-section">
		<h2 class="headline">{{ $title_intro->title }}</h2>
		<p>{{ $title_intro->text }}</p>
    </section>

    <!-- Cards -->
    <section class="home-section">
		@if (count($random_recipes) > 0)
			@foreach ($random_recipes->chunk(3) as $chunk)
				<div class="row">
					@foreach ($chunk as $random)
						<div class="recipe-container col-xs-12 col-sm-6 col-md-4" style="animation: appear {{ 3 + $loop->index }}s;">
							<div class="recipe">
								<a href="/recipes/{{ $random->id }}">
									<img src="{{ asset('storage/images/'.$random->image) }}" alt="{{$random->title}}" title="{{$random->title}}">
								</a>
								<div class="recipes-content">
									<!-- Title -->
									<h3>{{$random->title}}</h3>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@endforeach
		@endif
    </section>
@endsection

@section('script')
<script>
	document.getElementById('home-search-btn').addEventListener('click', () => {
		id("home-search-btn").style.display = "none"
		id("header-search-input").style.display = "block"
	
		setTimeout(() => id("header-search-input").style.opacity = "1", 500)
	})
</script>
@endsection