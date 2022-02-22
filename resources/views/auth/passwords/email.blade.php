@extends('layouts.authentication')

@section('content')
<div class="container login">

    <div class="logo">
        @svg('logo-auth')
    </div>
    
    <div class="card">
        <div class="card-header">Reset Password</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Enter your e-mail address" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">
                    Continue
                </button>
            </form>
        </div>
    </div>
    <a class="forgot-password" href="{{ route('login') }}">
        Go Back
    </a>
</div>
@endsection
