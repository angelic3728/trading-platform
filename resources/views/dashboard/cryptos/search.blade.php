@extends('layouts.dashboard')

@section('title', 'All Cryptos')

@section('content')
<div class="col-sm-12 dashboard-content-wrapper">
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
    @if(!request()->filled('page') && !request()->filled('q'))
    <div class="card">
        <div class="card-header">
            <div class="header-top">
                <h5>Highlighted Cryptocurrencies</h5>
            </div>
        </div>
        <div class="card-body col-sm-12 crypto-contents">
            <div class="loader-box justify-content-center align-items-center w-full" style="inset:0px; position:absolute; z-index:10; display:flex;">
                <div class="loader-19"></div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="card income-card shadow shadow-showcase">
                        <div class="card-body p-0">
                            <div class="chart-content">
                                <div id="chart-timeline-dashboard1" style="min-height: 285px;">
                                </div>
                            </div>
                            <div class="d-flex-column p-2">
                                <a href="" id="h_crypto_link1">
                                    <h6 id="h_crypto_title1" class="fs-20" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"></h6>
                                </a>
                                <div class="center-content">
                                    <p class="d-sm-flex align-items-end">
                                        <span class="font-primary m-r-10 f-16 f-w-700" id="current_crypto_price1"></span>
                                        <span class="" id="current_crypto_percentage1"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card income-card shadow shadow-showcase">
                        <div class="card-body p-0">
                            <div class="chart-content">
                                <div id="chart-timeline-dashboard2" style="min-height: 285px;">
                                </div>
                            </div>
                            <div class="d-flex-column p-2">
                                <a href="" id="h_crypto_link2">
                                    <h6 id="h_crypto_title2" class="fs-20" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"></h6>
                                </a>
                                <div class="center-content">
                                    <p class="d-sm-flex align-items-end">
                                        <span class="font-primary m-r-10 f-16 f-w-700" id="current_crypto_price2"></span>
                                        <span class="" id="current_crypto_percentage2"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card income-card shadow shadow-showcase">
                        <div class="card-body p-0">
                            <div class="chart-content">
                                <div id="chart-timeline-dashboard3" style="min-height: 285px;">
                                </div>
                            </div>
                            <div class="d-flex-column p-2">
                                <a href="" id="h_crypto_link3">
                                    <h6 id="h_crypto_title3" class="fs-20" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"></h6>
                                </a>
                                <div class="center-content">
                                    <p class="d-sm-flex align-items-end">
                                        <span class="font-primary m-r-10 f-16 f-w-700" id="current_crypto_price3"></span>
                                        <span class="" id="current_crypto_percentage3"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card income-card shadow shadow-showcase">
                        <div class="card-body p-0">
                            <div class="chart-content">
                                <div id="chart-timeline-dashboard4" style="min-height: 285px;">
                                </div>
                            </div>
                            <div class="d-flex-column p-2">
                                <a href="" id="h_crypto_link4">
                                    <h6 href="#" id="h_crypto_title4" class="fs-20" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"></h6>
                                </a>
                                <div class="center-content">
                                    <p class="d-sm-flex align-items-end">
                                        <span class="font-primary m-r-10 f-16 f-w-700" id="current_crypto_price4"></span>
                                        <span class="" id="current_crypto_percentage4"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="card mb-3">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    @if(request()->filled('q') || request()->filled('ex'))
                    <h4 class="mb-2 sm:mb-0">Results ({{ $cryptos->total() }})</h4>
                    @else
                    <h4 class="mb-2 sm:mb-0">All Cryptocurrencies ({{ $cryptos->total() }})</h4>
                    @endif
                </div>
                <div class="col-auto d-flex justify-content-between">
                    <form action="{{ route('cryptos.search') }}" class="ms-3" style="min-width: 200px;">
                        <div class="search d-flex">
                            <input type="text" class="form-control" placeholder="Search" name="q" value="{{ request()->q }}">
                            <button type="submit" id="search_btn" class="btn btn-iconsolid" href="javascript:void(0)"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Symbol</th>
                            <th scope="col">Cryptocurrency Name</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cryptos as $crypto)
                        <tr>
                            <td width="10%">{{ $crypto->symbol }}</td>
                            <td>{{ $crypto->name }}</td>
                            <td width="10%" class="text-right" nowrap>
                                <a type="button" class="btn btn-outline-success btn-xs" href="{{ route('cryptos.show', ['symbol' => $crypto->symbol]) }}">See More</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($cryptos->isEmpty())
                <div class="p-10 d-flex justify-content-center">
                    There are no cryptos that match your search result
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end pb-3">
        {{ $cryptos->appends(request()->query())->links() }}
    </div>
    <div class="col-xl-12 box-col-12 des-xl-100 mt-3">
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
                    <div class="col-xl-3 col-md-6 des-xl-50 news-0" style="display: none;">
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
                    <div class="col-xl-3 col-md-6 des-xl-50 news-1" style="display: none;">
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
                    <div class="col-xl-3 col-md-6 des-xl-50 news-2" style="display: none;">
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
                    <div class="col-xl-3 col-md-6 des-xl-50 news-3" style="display: none;">
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
@push('scripts')
<script src="{{asset('assets/js/pages/cryptos/custom.js')}}"></script>
<script>
    if ("{{session('error')}}" == "unknown") {
        $.notify('<i class="fa fa-bell-o"></i>The crypto data is not providing right now.', {
            type: 'theme',
            allow_dismiss: true,
            delay: 2000,
            showProgressbar: false,
            timer: 300
        });
    }
</script>
@endpush
@endsection