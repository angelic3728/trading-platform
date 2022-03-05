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
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
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
                            <td class="type">{{ $transaction->type }}</td>
                            <td class="symbol-with-company-name">
                                {{ $transaction->symbol }}
                                <small>{{ $transaction->company_name }}</small>
                            </td>
                            <td class="text-nowrap">{{ $transaction->formatPrice($transaction->price) }}</td>
                            <td class="text-nowrap">{{ $transaction->shares }}</td>
                            <td class="text-nowrap">{{ $transaction->created_at }}</td>
                            <td class="text-nowrap">{{ $transaction->is_fund=="1"?"Mutual Fund":"Stock" }}</td>
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