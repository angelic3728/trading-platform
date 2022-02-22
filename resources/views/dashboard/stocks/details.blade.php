@extends('layouts.dashboard')
@section('title', array_get($data, 'company_name'))

@section('content')
    <div class="container stock-details">
        <div class="row">
            <div class="col">
                <stock-chart
                    company-name="{{ array_get($data, 'company_name') }}"
                    symbol="{{ array_get($data, 'symbol') }}"
                    currency="{{ array_get($data, 'currency') }}"
                    :price="{{ array_get($data, 'price') }}"
                    exchange="{{ array_get($data, 'exchange') }}"
                    source="{{ array_get($data, 'source') }}"
                    link="{{ array_get($data, 'link') }}"
                    :change-percentage="{{ array_get($data, 'change_percentage', 'null') }}"
                />
            </div>
        </div>

        @if(array_get($data, 'source') == 'iex')
            <div class="row">
                <div class="col">
                    <h2 class="title">Stock Details</h2>
                </div>
            </div>
            @if(array_get($data, 'exchange') == 'NYSE')
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4>Company Information</h4>
                                        <p>{{ array_get($data, 'company.description', '-') }}</p>
                                    </div>

                                    <div class="col-lg-6 d-flex flex-column justify-content-between">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-4">
                                                <div class="detail">
                                                    <strong>Latest Price</strong>
                                                    <span>{{ array_get($data, 'numbers.latest_price', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>Market Cap</strong>
                                                    <span>{{ array_get($data, 'numbers.market_cap', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>P/E Ratio</strong>
                                                    <span>{{ array_get($data, 'numbers.pe_ratio', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>Exchange</strong>
                                                    <span>{{ array_get($data, 'company.exchange', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>Sector</strong>
                                                    <span>{{ array_get($data, 'company.sector', '-') }}</span>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-4">
                                                <div class="detail">
                                                    <strong>Previous Close</strong>
                                                    <span>{{ array_get($data, 'numbers.previous_close', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>Volume</strong>
                                                    <span>{{ array_get($data, 'numbers.volume', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>Latest EPS</strong>
                                                    <span>{{ array_get($data, 'numbers.latest_eps', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>Industry</strong>
                                                    <span>{{ array_get($data, 'company.industry', '-') }}</span>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-4">
                                                <div class="detail">
                                                    <strong>Institutional Price</strong>
                                                    <span>{{ array_get($data, 'numbers.institutional_price', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>AVG Total Volume</strong>
                                                    <span>{{ array_get($data, 'numbers.avg_total_volume', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>Latest EPS Date</strong>
                                                    <span>{{ array_get($data, 'numbers.latest_eps_date', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>Website</strong>
                                                    <a href="{{ array_get($data, 'company.website', '-') }}" target="_blank">{{ array_get($data, 'company.website', '-') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row link">
                                    <div class="col">
                                        <hr>
                                    </div>
                                </div>

                                <div class="row link">
                                    <div class="col text-right">
                                        <a href="{{ array_get($data, 'link') }}" target="_blank">Click here for more information about this stock</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(array_get($data, 'exchange') == 'LSE')
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4>Company Information</h4>
                                        <p>{{ array_get($data, 'company.description', '-') }}</p>
                                        <hr class="d-lg-none d-xl-none">
                                    </div>

                                    <div class="col-lg-6 d-flex flex-column justify-content-between">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="detail">
                                                    <strong>Latest Price</strong>
                                                    <span>{{ array_get($data, 'numbers.latest_price', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>AVG Total Volume</strong>
                                                    <span>{{ array_get($data, 'numbers.avg_total_volume', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>Exchange</strong>
                                                    <span>{{ array_get($data, 'company.exchange', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>Sector</strong>
                                                    <span>{{ array_get($data, 'company.sector', '-') }}</span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="detail">
                                                    <strong>Institutional Price</strong>
                                                    <span>{{ array_get($data, 'numbers.institutional_price', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>Industry</strong>
                                                    <span>{{ array_get($data, 'company.industry', '-') }}</span>
                                                </div>
                                                <div class="detail">
                                                    <strong>Website</strong>
                                                    <a href="{{ array_get($data, 'company.website', '-') }}" target="_blank">{{ array_get($data, 'company.website', '-') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row link">
                                    <div class="col">
                                        <hr>
                                    </div>
                                </div>

                                <div class="row link">
                                    <div class="col text-right">
                                        <a href="{{ array_get($data, 'link') }}" target="_blank">Click here for more information about this stock</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(array_get($data, 'exchange') == 'NYSE')
                <news symbols="{{ array_get($data, 'identifier') }}"></news>
            @endif
        @endif

    </div>
@endsection
