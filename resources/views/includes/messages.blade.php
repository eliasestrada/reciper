@if (session('success'))
    @if (session('success')[0] == '<')
        <script>
            M.toast({
                html: '{!! @session('success') !!}',
                displayLength: 5000,
                classes: 'green z-depth-2'
            })
        </script>
    @else
        <script>
            M.toast({
                html: '<i class="fas fa-check left"></i>{{ @session('success') }}',
                displayLength: 5000,
                classes: 'green z-depth-2'
            })
        </script>
    @endif
@endif

@if (session('error'))
    <script>
        let message = '<i class="fas fa-exclamation left"></i>{{ @session('error') }}'
        M.toast({html: message, displayLength: 5000, classes: 'red z-depth-2'})
    </script>
@endif