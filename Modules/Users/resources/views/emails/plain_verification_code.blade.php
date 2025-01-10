

@component('mail::message')
    # Email Verification Code

    Your email verification code is: **{{ $code }}**

    Please use this code to verify your email address.

    Thank you for joining us!

    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endcomponent
