@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="row pt-4 pt-lg-5">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                          <div class="col">
                              <h4 class="mb-0">Transaction History</h4>
                          </div>
                          <div class="col-auto d-none d-sm-flex">
                              <form action="{{ route('transactions') }}">
                                  <div class="search">
                                      <input type="text" class="form-control" placeholder="Search" name="q" value="{{ request()->q }}">
                                      <button type="submit" class="search-icon">
                                          @svg('table.search')
                                      </button>
                                  </div>
                              </form>
                          </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Type</th>
                                    <th scope="col">Symbol</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Shares</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td class="type">{{ $transaction->type }}</td>
                                        <td class="symbol-with-company-name">
                                            {{ $transaction->stock->symbol }}
                                            <small>{{ $transaction->stock->company_name }}</small>
                                        </td>
                                        <td class="text-nowrap">{{ $transaction->stock->formatPrice($transaction->price) }}</td>
                                        <td class="text-nowrap">{{ $transaction->shares }}</td>
                                        <td class="text-nowrap">{{ $transaction->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($transactions->isEmpty())
                        <div class="table-empty">
                              @if(request()->has('q'))
                                  There are no transactions that match your search result
                              @else
                                  There are no transactions at the moment.
                              @endif
                        </div>
                    @endif
                </div>

                {{ $transactions->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
