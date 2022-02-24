@extends('layouts.dashboard')

@section('title', 'Trade Now')

@push('css')
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}"> -->
@endpush

@section('content')

<!-- Zero Configuration  Starts-->
<div class="col-sm-12">
    <div class="card mb-3">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    @if(request()->filled('q'))
                    <h4 class="mb-0">Results ({{ $stocks->total() }})</h4>
                    @else
                    <h4 class="mb-0">All Stocks ({{ $stocks->total() }})</h4>
                    @endif
                </div>
                <div class="col-auto">
                    <form action="{{ route('stocks.search') }}">
                        <div class="search d-flex">
                            <input type="text" class="form-control" placeholder="Search" name="q" value="{{ request()->q }}">
                            <button type="submit" class="btn btn-iconsolid" href="javascript:void(0)"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Symbol</th>
                                <th scope="col">Company Name</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stocks as $stock)
                            <tr>
                                <td width="10%">{{ $stock->symbol }}</td>
                                <td>{{ $stock->company_name }}</td>
                                <td class="text-right" nowrap>
                                    <a type="button" class="btn btn-outline-success btn-xs" href="{{ route('stocks.show', ['symbol' => $stock->symbol]) }}">See More</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($stocks->isEmpty())
                    <div class="p-10 d-flex justify-content-center">
                        There are no stocks that match your search result
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end pb-3">
    {{ $stocks->appends(request()->query())->links() }}
    </div>
</div>
<!-- Zero Configuration  Ends-->

@endsection