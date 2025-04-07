@component('mail::message')
<h2># Hello, {{ $user->name }}!</h2>

Welcome to our platform. We are excited to have you!
<h2>You have successsfully logged in into your Account</h2>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
