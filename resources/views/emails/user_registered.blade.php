@component('mail::message')
# Новый пользователь

Новый пользователь был зарегистрирован на {{ config('app.name') }}, подтвердите регистрацию пользователя или удалите его если вы предварительно не обговаривали его регистрацию.

@component('mail::button', ['url' => 'http://localhost:3000/users'])
Перейти к пользователю
@endcomponent

Спасибо,
<br>
{{ config('app.name') }}
<br><br>
{{ date('d.m.Y') }} / {{ date('H:i') }}
@endcomponent