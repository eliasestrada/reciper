@if (count($errors) > 0)
	<div class="message error message-public">
	<strong>Ошибки:</strong>
		<ul class="unstyled-list">
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li> 
			@endforeach
		</ul>
	</div>
@endif

@if (session('success'))
	<p class="message success message-public">{{ session('success') }}</p>
@endif

@if (session('error'))
	<p class="message error message-public">{{ session('error') }}</p>
@endif