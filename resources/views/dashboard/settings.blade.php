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
    <!-- action="{{ route('settings.avatar') }}" -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-0">Change Your Avatar</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.avatar') }}" method="post" class="settings-avatar" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="d-block">
                            <div class="avatar-holder d-flex justify-content-center">
                                @if(File::exists('storage/'.auth()->user()->avatar))
                                <img src="{{ 'storage/'.auth()->user()->avatar }}" class="img-90 rounded-circle avatar-preview" onclick="selectFile()" />
                                @else
                                <img src="{{asset('assets/images/avtar/default.png')}}" class="img-90 rounded-circle avatar-preview" onclick="selectFile()" />
                                @endif
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="javascript:void(0)" onclick="selectFile()" data-bs-toggle="tooltip" data-bs-placement="top" title="Image must be foresuqare bigger than 50*50. jpg|jpeg|png">Change Avatar</a>
                            </div>
                            <input type="file" name="avatar" id="avatar_input" style="display: none;" />
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary float-right" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
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
        <div class="col-md-4">
            <div class="card">
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
        <div class="col-xl-12 box-col-12 des-xl-100">
            <div class="card news-container">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-top d-sm-flex align-items-center">
                        <h5>Recent News</h5>
                    </div>
                    <a href="/news?symbols={{implode(',', $news_symbols)}}" class="btn btn-outline-success btn-xs" style="line-height: 20px;">See More</a>
                </div>
                <div class="card-body">
                    <div class="loader-box news-loader justify-content-center align-items-center w-full" style="inset:0px; position:absolute; z-index:10; display:flex; height:initial;">
                        <div class="loader-19"></div>
                    </div>
                    <div class="row news-content" style="min-height: 440px;">
                        <div class="col-xl-3 col-md-6 news-0" style="display: none;">
                            <a href="" class="news-link-0" target="_blank">
                                <div class="prooduct-details-box">
                                    <div class="media" style="text-align: center; padding:10px 0px; min-height:410px;">
                                        <img class="align-self-center img-fluid news-img-0" src="" style="max-height: 180px;" alt="#">
                                        <div class="media-body">
                                            <p class="news-date-0 text-dark mb-0"></p>
                                            <h6 class="news-headline-0"></h6>
                                            <div class="summary news-summary-0"></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 news-1" style="display: none;">
                            <a href="" class="news-link-1" target="_blank">
                                <div class="prooduct-details-box">
                                    <div class="media" style="text-align: center; padding:10px 0px; min-height:410px;">
                                        <img class="align-self-center img-fluid news-img-1" src="" style="max-height: 180px;" alt="#">
                                        <div class="media-body">
                                            <p class="news-date-1 text-dark mb-0"></p>
                                            <h6 class="news-headline-1"></h6>
                                            <div class="summary news-summary-1"></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 news-2" style="display: none;">
                            <a href="" class="news-link-2" target="_blank">
                                <div class="prooduct-details-box">
                                    <div class="media" style="text-align: center; padding:10px 0px; min-height:410px;">
                                        <img class="align-self-center img-fluid news-img-2" src="" style="max-height: 180px;" alt="#">
                                        <div class="media-body">
                                            <p class="news-date-2 text-dark mb-0"></p>
                                            <h6 class="news-headline-2"></h6>
                                            <div class="summary news-summary-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 news-3" style="display: none;">
                            <a href="" class="news-link-3" target="_blank">
                                <div class="prooduct-details-box">
                                    <div class="media" style="text-align: center; padding:10px 0px; min-height:410px;">
                                        <img class="align-self-center img-fluid news-img-3" src="" style="max-height: 180px;" alt="#">
                                        <div class="media-body">
                                            <p class="news-date-3 text-dark mb-0"></p>
                                            <h6 class="news-headline-3"></h6>
                                            <div class="summary news-summary-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row no-news" style="display: none;">
                        <div class="col-sm-12">
                            <div class="alert alert-light dark alert-dismissible fade show" id="zero_shares_alert" role="alert">
                                There are no recent news.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{asset('assets/js/tooltip-init.js')}}"></script>
<script>
    function selectFile() {
        $('#avatar_input').click();
    }

    $('#avatar_input').change(function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('.avatar-preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>
@endpush
@endsection