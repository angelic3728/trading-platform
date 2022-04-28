@extends('layouts.authentication')

@section('title')
Login
@endsection

@push('css')
@endpush

@section('content')
<section class="login-wrapper">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="login-card">
                    <img class="m-b-30" src="{{asset('assets/images/logo/logo.png')}}" alt="logo" style="width: 280px;">
                    <form class="theme-form login-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <h4>Login</h4>
                        <h6>Welcome back! Log in to your account.</h6>
                        <div class="form-group">
                            <label>Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="icon-email"></i></span>
                                <input class="form-control" type="email" name="email" required="" placeholder="test@gmail.com" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="icon-lock"></i></span>
                                <input class="form-control" type="password" id="twc_pwd" name="password" required="" placeholder="*********" />
                                <div class="show-hide"><span class="show"> </span></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <input id="checkbox1" type="checkbox" />
                                <label for="checkbox1">Remember password</label>
                            </div>
                            <a class="link" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                        </div>
                    </form                    
                </div>                
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script>
    $(document).ready(function() {
        // set app height
        const innerHeight = window.innerHeight;
        $('body').css('height', innerHeight+"px");
        $('.login-card').css('min-height', innerHeight+"px");        
    });
</script>
@endpush

@endsection