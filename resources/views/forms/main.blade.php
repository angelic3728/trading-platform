@extends('layouts.fdashboard')

@section('title', 'Forms')

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/date-picker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vector-map.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/scrollable.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/owlcarousel.css')}}">
@endpush
@section('content')
<!-- Container-fluid starts-->
<div class="container-fluid dashboard-default-sec" style="padding: 0px;">
    <div class="row dashboard-content-wrapper">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="d-flex justify-content-center align-items-center" id="ad1_container">
                        @if($ads[0])
                        <a href="{{$ads[0]['link']}}#" target="_blank">
                            <img src="{{ '/storage/'.$ads[0]['source'] }}" class="img-fluid" alt="">
                        </a>
                        @else
                        <b>No Advertising.</b>
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center" id="ad2_container">
                    <ul>
                        <li>
                            @if($ads[1])
                            <a href="{{$ads[1]['link']}}#" target="_blank">
                                <img src="{{ '/storage/'.$ads[1]['source'] }}" class="img-fluid" alt="">
                            </a>
                            @else
                            <b>No Advertising.</b>
                            @endif
                        </li>
                    </ul>
                    <a href="javascript:void(0)" onclick="hide_ad()" style="position: absolute; top:10px; right:10px;"><i class="fa fa-times fs-5"></i></a>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6 p-3">
                    <a href="{{ route('forms.equities') }}">
                        <div class="card o-hidden border-0 m-b-0" style="cursor: pointer;">
                            <div class="bg-primary b-r-4 card-body">
                                <div class="media static-top-widget">
                                    <div class="align-self-center text-center"><i data-feather="layers"></i></div>
                                    <h6 class="mb-0 m-l-10 m-t-5">Equities</h6>
                                    <div class="media-body">
                                        <i class="icon-bg" data-feather="layers"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6 p-3">
                    <a href="{{ route('forms.fixed_income') }}">
                        <div class="card o-hidden border-0 m-b-0" style="cursor: pointer;">
                            <div class="bg-secondary b-r-4 card-body">
                                <div class="media static-top-widget">
                                    <div class="align-self-center text-center"><i data-feather="shopping-bag"></i></div>
                                    <h6 class="mb-0 m-l-10 m-t-5">Fixed Income</h6>
                                    <div class="media-body">
                                        <i class="icon-bg" data-feather="shopping-bag"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6 p-3">
                    <a href="#">
                        <div class="card o-hidden border-0 m-b-0" style="cursor: pointer;">
                            <div class="bg-secondary b-r-4 card-body">
                                <div class="media static-top-widget">
                                    <div class="align-self-center text-center"><i data-feather="credit-card"></i></div>
                                    <h6 class="mb-0 m-l-10 m-t-5">Funds</h6>
                                    <div class="media-body">
                                        <i class="icon-bg" data-feather="credit-card"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6 p-3">
                    <a href="#">
                        <div class="card o-hidden border-0 m-b-0" style="cursor: pointer;">
                            <div class="bg-primary b-r-4 card-body">
                                <div class="media static-top-widget">
                                    <div class="align-self-center text-center"><i data-feather="aperture"></i></div>
                                    <h6 class="mb-0 m-l-10 m-t-5">Crypto</h6>
                                    <div class="media-body">
                                        <i class="icon-bg" data-feather="aperture"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-12 box-col-12 des-xl-100">
            <div class="row">
                <div class="col-xl-12 box-col-12 des-xl-100">
                    <div class="card">
                        <div class="card-header pb-1">
                            <div class="header-top">
                                <h5>Highlighted Stocks, Funds and Cryptos</h5>
                            </div>
                        </div>
                        <div class="card-body col-sm-12">
                            <div class="owl-carousel owl-theme" id="owl-carousel-14">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="stock_carousel">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="fund_carousel">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="bond_carousel">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="crypto_carousel">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-carousel owl-theme" id="owl-carousel-15">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel3">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel4">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel5">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel6">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel7">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel8">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel9">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel11">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel13">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel14">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel15">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="owl-carousel-16 owl-carousel owl-theme" id="highlight_carousel16">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 box-col-12 des-xl-100">
                    <div class="card news-container">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5>Recent News</h5>
                            </div>
                            <a href="/news?symbols={{implode(',', $news_symbols)}}" class="btn btn-outline-success btn-xs">See More</a>
                        </div>
                        <div class="card-body">
                            <div class="loader-box news-loader justify-content-center align-items-center w-full" style="inset:0px; position:absolute; z-index:10; display:flex; height:initial;">
                                <div class="loader-19"></div>
                            </div>
                            <div class="row news-content" style="min-height: 440px;">
                                <div class="col-xl-3 col-md-6 news-0" style="display: none;">
                                    <a href="" class="news-link-0" target="_blank">
                                        <div class="prooduct-details-box">
                                            <div class="chart-wrapper media sm:w-auto" style="text-align: center; padding:10px 0px;">
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
                                            <div class="chart-wrapper media" style="text-align: center; padding:10px 0px;">
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
                                            <div class="chart-wrapper media" style="text-align: center; padding:10px 0px;">
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
                                            <div class="chart-wrapper media" style="text-align: center; padding:10px 0px;">
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
    </div>
</div>
</div>
</div>
<!-- Container-fluid Ends-->
@push('scripts')
<script>
    var all_highlights = {!!json_encode($all_highlights) !!};
    var news_symbols = {!!json_encode($news_symbols) !!};
</script>
<script src="{{asset('assets/js/prism/prism.min.js')}}"></script>
<script src="{{asset('assets/js/clipboard/clipboard.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/js/counter/counter-custom.js')}}"></script>
<script src="{{asset('assets/js/scrollable/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/scrollable/scrollable-custom.js')}}"></script>
<script src="{{asset('assets/js/dashboard/default.js')}}"></script>
<script src="{{asset('assets/js/notify/index.js')}}"></script>
<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/custom.js')}}"></script>
@endpush
@endsection