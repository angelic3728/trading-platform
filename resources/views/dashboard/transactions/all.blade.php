@extends('layouts.dashboard')

@section('title', 'Transaction')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')

<!-- Zero Configuration  Starts-->
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
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Transaction History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive-md">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th scope="col">Symbol</th>
                            <th scope="col">Type</th>
                            <th scope="col">Company Name / Crypto Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Shares/Coin Amounts</th>
                            <th scope="col">Date</th>
                            <th scope="col">Market</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td class="type">{{ $transaction->symbol }}</td>
                            <td class="type">{{ $transaction->type }}</td>
                            <td class="symbol-with-company-name">
                                <small>{{ ($transaction->wherefrom=="2" || $transaction->wherefrom=="3")?$transaction->name:$transaction->company_name }}</small>
                            </td>
                            <td class="text-nowrap">{{ $transaction->formatPrice($transaction->price) }}</td>
                            <td class="text-nowrap">{{ $transaction->shares }}</td>
                            <td class="text-nowrap">{{ $transaction->created_at }}</td>
                            <td class="text-nowrap">{{ $transaction->wherefrom=="0"?"Stock":($transaction->wherefrom=="1"?"Fund":($transaction->wherefrom=="2"?"Bond":"Crypto")) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
<!-- Zero Configuration  Ends-->

@push('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script>
    function hide_ad() {
        $("#ad1_container").removeClass("d-flex");
        $("#ad1_container").addClass("d-none");
        $("#ad2_container").removeClass("d-flex");
        $("#ad2_container").addClass("d-none");
        $(".dashboard-content-wrapper").css("padding-right", "0px");
        $(".dashboard-content-wrapper").css("padding-top", "0px");
    }
</script>
@endpush

@endsection