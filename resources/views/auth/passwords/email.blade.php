@extends('layouts.authentication')

@section('content')
<div class="container login d-flex justify-content-center" style="padding: 10rem 0px;">
    <div class="card mt-30" style="min-width: 400px;">
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
                <div class="d-flex justify-content-between">
                    <a class="forgot-password m-t-15" href="{{ route('login') }}">
                        Go Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Continue
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection