@extends('layouts.authentication')

@section('content')
<div class="container login d-flex flex-column justify-content-center align-items-center" style="height:100vh;">
    <img class="m-b-30" src="{{asset('assets/images/logo/logo.png')}}" alt="logo" style="width: 250px;">
    <div class="card" style="min-width: 400px; max-height:300px;">
        <div class="card-header p-b-20"><h6><span>Reset Password</span></h6></div>

        <div class="card-body p-t-0">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email" style="margin-bottom: 10px;">{{ __('E-Mail Address') }}</label>
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