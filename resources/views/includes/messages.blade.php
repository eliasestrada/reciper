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
		message += '<button class="btn-flat toast-action"><i class="material-icons">close</i></button>'
		M.toast({html: message, displayLength: 7000})
	</script>
@endif

@if (session('success'))
	<script>
		let message = '{{ @session('success') }}<button class="btn-flat toast-action"><i class="material-icons">close</i></button>'
		M.toast({html: message, displayLength: 7000})
	</script>
@endif

@if (session('error'))
	<script>
		let message = '{{ @session('error') }}<button class="btn-flat toast-action"><i class="material-icons">close</i></button>'
		M.toast({html: message, displayLength: 7000})
	</script>
@endif