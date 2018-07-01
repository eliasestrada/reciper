@isset($errors)
	@if (count($errors) > 0)
		@foreach ($errors->all() as $error)
		<script>
			let message = ''
		</script>
			<script>
				message += '{{ $error }} <br />'
			</script>
		@endforeach
		<script>
			M.toast({html: message, displayLength: 10000, classes: 'red'})
		</script>
	@endif
@endisset

@if (session('success'))
	<script>
		let message = '{{ @session('success') }}'
		M.toast({html: message, displayLength: 10000, classes: 'green'})
	</script>
@endif

@if (session('error'))
	<script>
		let message = '{{ @session('error') }}'
		M.toast({html: message, displayLength: 10000, classes: 'red'})
	</script>
@endif