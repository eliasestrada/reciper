@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        <p class="message error">
            {{ $error }}
        </p>
    @endforeach
@endif

@if (session('success'))
    <p class="message success">
        {{ session('success') }}
    </p>
@endif

@if (session('error'))
    <p class="message error">
        {{ session('error') }}
    </p>
@endif