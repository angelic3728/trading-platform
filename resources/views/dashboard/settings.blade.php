@extends('layouts.dashboard')
@section('title', 'Settings')

@section('content')
<div class="container">
    <div class="row pt-4 pt-lg-5">
        <div class="col">
            <h1>Settings</h1>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 order-md-2">
            <avatar src="{{ auth()->user()->avatar_url }}" action="{{ route('settings.avatar') }}"></avatar>
        </div>

        <div class="col-md-8 mt-4 mt-md-0 order-md-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-0">Account Information</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.user') }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ auth()->user()->first_name }}" placeholder="Enter your first name" required>

                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ auth()->user()->last_name }}" placeholder="Enter your last name" required>

                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="form-label">E-mail Address</label>
                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ auth()->user()->email }}" placeholder="Enter your e-mail address" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ auth()->user()->phone }}" placeholder="Enter your phone number" required>

                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-rounded">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-0">Change Password</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.password') }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Enter an new password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-rounded">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
