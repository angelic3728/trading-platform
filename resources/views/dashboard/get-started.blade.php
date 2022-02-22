@extends('layouts.authentication')

@section('content')
<div class="container login get-started">

    <div class="logo">
        @svg('logo-auth')
    </div>

    <div class="card">
        <div class="card-body">

            <p class="intro">Welcome to our platform {{ $activation_token->user->first_name }}! Please fill out the following form to complete your account</p>

            <hr>

            <form method="POST" action="{{ route('registration.set-password', ['token' => $activation_token->token]) }}">
                @csrf

                <div class="form-group">
                    <label for="password" class="form-label">Create Password</label>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Enter your password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Password Confirmation</label>
                    <input id="password_confirmation" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="Confirm your password" required>

                    @if ($errors->has('password_confirmation'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group mb-0">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="terms" id="terms-checkbox">
                        <label class="form-check-label" for="terms-checkbox">
                            I certify that I have read and agree to the <a href="{{ route('legal.terms-and-conditions') }}" target="_blank">Terms & Conditions</a> and <a href="{{ route('legal.privacy-policy') }}" target="_blank">Privacy Policy</a>.
                        </label>
                    </div>

                    @if ($errors->has('terms'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('terms') }}</strong>
                        </span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">
                    Continue
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
