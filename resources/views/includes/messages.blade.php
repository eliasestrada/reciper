@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
    <script>
        let message = '<i class="fas fa-exclamation left"></i>'
    </script>
        <script>
            message += '{{ $error }} <br>'
        </script>
    @endforeach
    <script>
        M.toast({html: message, displayLength: 10000, classes: 'red z-depth-2'})
    </script>
@endif

@if (session('success'))
    <script>
        let message = '<i class="fas fa-check left"></i>{{ @session('success') }}'
        M.toast({html: message, displayLength: 10000, classes: 'green z-depth-2'})
    </script>
@endif


@if (session('status'))
    <script>
        let message = '<i class="fas fa-check left"></i>{{ session('status') }}'
        M.toast({html: message, displayLength: 10000, classes: 'main z-depth-2'})
    </script>
@endif

@if (session('error'))
    <script>
        let message = '<i class="fas fa-exclamation left"></i>{{ @session('error') }}'
        M.toast({html: message, displayLength: 10000, classes: 'red z-depth-2'})
    </script>
@endif