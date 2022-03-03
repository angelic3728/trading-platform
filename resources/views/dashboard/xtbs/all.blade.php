@extends('layouts.dashboard')

@section('title', 'Transaction')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')

<!-- Zero Configuration  Starts-->
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Transaction History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-2">
                    <thead>
                        <tr>
                            <th scope="col">ASX CODE</th>
                            <th scope="col">BOND ISSUER</th>
                            <th scope="col">MATURITY DATE</th>
                            <th scope="col">COUPON TYPE</th>
                            <th scope="col">NEXT EX.DATE</th>
                            <th scope="col">COUPON P.A</th>
                            <th scope="col">XTB PRICE</th>
                            <th scope="col">YTM</th>
                            <th scope="col">RUNNING CURRENT YIELD</th>
                            <th scope="col">TRADING MARGIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($xtbs as $xtb)
                        <tr>
                            <td class="text-nowrap text-secondary">{{ $xtb->asx_code }}</td>
                            <td class="text-nowrap"><a href="https://xtbs.com.au/xtbs-profile/{{ $xtb->asx_code }}" target="_blank">{{ $xtb->bond_issuer }}</a></td>
                            <td class="text-nowrap text-dark">{{ $xtb->maturity_date }}</td>
                            <td class="text-nowrap text-secondary">{{ ($xtb->coupon_type == "")?$xtb->coupon_type:"-" }}</td>
                            <td class="text-nowrap text-secondary">{{ $xtb->next_ex_date }}</td>
                            <td class="text-nowrap text-info">{{ $xtb->coupon_pa }}</td>
                            <td class="text-nowrap text-success">{{ $xtb->xtb_price."$" }}</td>
                            <td class="text-nowrap text-primary">{{ ($xtb->ytm !="")?$xtb->ytm."%":"-" }}</td>
                            <td class="text-nowrap text-dark">{{ $xtb->current_yield."%" }}</td>
                            <td class="text-nowrap text-danger">{{ ($xtb->trading_margin !="")?$xtb->trading_margin."%":"-" }}</td>
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
@endpush

@endsection
