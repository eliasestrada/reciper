@if (count($errors) > 0)
    <div class="message error">
    <strong>Ошибки:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li> 
            @endforeach
        </ul>
    </div>
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