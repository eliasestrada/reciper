@extends('layouts.app')

@section('title', trans('form.register'))

@section('content')

<div class="page container">
	<form method="POST" action="{{ route('register') }}" class="form">

		@csrf <div class="center"><h2 class="headline">@lang('form.register')</h2></div>
	
		<div class="input-field">
			<input type="text" id="name" name="name" value="{{ old('name') }}" class="validate" required>
			<label for="name">
				@lang('form.name') 
				@include('includes.tip', ['tip' => trans('form.name_desc')])
			</label>
		</div>

		<div class="input-field">
			<input type="email" id="email" name="email" value="{{ old('email') }}" class="validate" required>
			<label for="email">
				@lang('form.email')
				@include('includes.tip', ['tip' => trans('form.email_desc')])
			</label>
		</div>

		<visibility name-attr="password" id-attr="password">
			<label for="password">
				@lang('form.pwd')
				@include('includes.tip', ['tip' => trans('form.pwd_desc')])
			</label>
		</visibility>

		<visibility name-attr="password_confirmation" id-attr="password_confirmation">
			<label for="password_confirmation">
				@lang('form.pwd_confirm')
				@include('includes.tip', ['tip' => trans('form.pwd2_desc')])
		</visibility>

		@if(!empty($document))
			<blockquote class="mt-5">
				{!! trans('form.agree_to_terms', ['btn' => trans('form.register'),'terms' => '<a>dsf</a>']) !!}
			</blockquote>

			<!-- Modal Structure -->
			<div id="modal1" class="modal">
				<div class="modal-content reset">
					<h4>{{ $document->getTitle() }}</h4>
					{!! $document->text !!}
				</div>
				<div class="modal-footer">
					<a href="#!" class="modal-close waves-effect waves-green btn-flat left">
						@lang('messages.agree')
					</a>
				</div>
			</div>
		@endif

		<button type="submit" id="register-btn" class="waves-effect waves-light btn mt-3">
			<i class="material-icons left">assignment_turned_in</i>
			@lang('form.register')
		</button>
	</form>
</div>

@endsection

@section('script')
	@include('includes.js.modal')
@endsection
