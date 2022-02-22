@component('mail::message')
# Dear {{ $user->first_name }}

Welcome to our award winning trade platform.

Please fill out the following form to complete your account.

@component('mail::button', ['url' => route('registration.get-started', $token)])
Get Started
@endcomponent

{{ config('app.name') }}
@endcomponent
