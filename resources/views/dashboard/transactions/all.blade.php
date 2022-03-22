@extends('layouts.dashboard')

@section('title', 'Transaction')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')

<!-- Zero Configuration  Starts-->
<div class="col-sm-12 dashboard-content-wrapper">
    <div class="col-xl-12 container-fluid">
        <div class="d-flex justify-content-center align-items-center container-fluid" id="ad1_container">
            <a href="https://bannerboo.com/" target="_blank">
                <img src="{{asset('assets/images/pros/horizontal.png')}}" class="img-fluid" alt="">
            </a>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center" id="ad2_container">
        <ul>
            <li>
                <a href="https://bannerboo.com/" target="_blank">
                    <img src="{{asset('assets/images/pros/vertical1.png')}}" class="img-fluid" alt="">
                </a>
            </li>
        </ul>
        <a href="javascript:void(0)" onclick="hide_ad()" style="position: absolute; top:10px; right:10px;"><i class="fa fa-times fs-5"></i></a>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Transaction History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th scope="col">Symbol</th>
                            <th scope="col">Type</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Shares</th>
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
                                <small>{{ $transaction->company_name }}</small>
                            </td>
                            <td class="text-nowrap">{{ $transaction->formatPrice($transaction->price) }}</td>
                            <td class="text-nowrap">{{ $transaction->shares }}</td>
                            <td class="text-nowrap">{{ $transaction->created_at }}</td>
                            <td class="text-nowrap">{{ $transaction->wherefrom=="0"?"Stock":($transaction->wherefrom=="1"?"Fund":"Crypto") }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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