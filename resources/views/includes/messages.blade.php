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
		M.toast({html: message, displayLength: 7000})
	</script>
@endif

@if (session('success'))
	<script>
		let message = '{{ @session('success') }}'
		M.toast({html: message, displayLength: 7000})
	</script>
@endif

@if (session('error'))
	<script>
		let message = '{{ @session('error') }}'
		M.toast({html: message, displayLength: 7000})
	</script>
@endif