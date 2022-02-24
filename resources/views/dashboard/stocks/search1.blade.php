@extends('layouts.dashboard')
@section('title', 'Search Stocks')

@section('content')
    <div class="container">
        @if(!request()->filled('page') && !request()->filled('q'))
            <div class="row highlighted-stocks mt-4 mt-lg-5">
                <div class="col">
                    <h2 class="mt-0">Highlighted Stocks</h2>
                </div>
            </div>

            <highlighted-stocks></highlighted-stocks>
        @endif

        <div class="row {{ (request()->filled('page') || request()->filled('q')) ? 'mt-5' : '' }}">
            <div class="col">
                <div class="card mt-3">
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
                                        <a href="{{ route('stocks.show', ['symbol' => $stock->symbol]) }}">See More</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($stocks->isEmpty())
                        <div class="table-empty">
                            There are no stocks that match your search result
                        </div>
                    @endif
                </div>

                {{ $stocks->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
