<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        <header>
            <div class="container h-100">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <a class="navbar-brand" href="{{ route('overview') }}">
                        @svg('logo-dashboard')
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item {{ request()->route()->named('overview') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('overview') }}">Overview</a>
                            </li>
                            <li class="nav-item {{ request()->route()->named('transactions') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('transactions') }}">Transactions</a>
                            </li>
                            <li class="nav-item {{ request()->route()->named('documents.index') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('documents.index') }}">Documents</a>
                            </li>
                            <li class="nav-item {{ request()->route()->named('stocks.search') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('stocks.search') }}">Trade Now</a>
                            </li>
                            <li class="nav-item d-lg-none d-xl-none {{ request()->route()->named('settings') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('settings') }}">Account Settings</a>
                            </li>
                            <li class="nav-item d-lg-none d-xl-none">
                                <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                            </li>
                        </ul>
                        <div class="justify-content-end align-items-center d-none d-lg-flex">
                            <header-search></header-search>

                            <div class="dropdown">
                                <div class="avatar dropdown-toggle" id="navigation-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ auth()->user()->avatar_url }}" />
                                </div>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navigation-dropdown">
                                    <a class="dropdown-item" href="{{ route('settings') }}">Account Setttings</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        @isset($widget_stocks)
            <widget>
                @foreach($widget_stocks as $stock)
                    <widget-stock
                        symbol="{{ $stock->get('symbol') }}"
                        company-name="{{ $stock->get('company_name') }}"
                        currency="{{ $stock->get('currency') }}"
                        :price="{{ $stock->get('price') }}"
                        :change-percentage="{{ $stock->get('change_percentage') }}"
                        :chart="{{ json_encode($stock->get('chart')) }}">
                    </widget-stock>
                @endforeach
            </widget>
        @endisset

        <main>
            @yield('content')
        </main>

        @include('layouts.components.footer')

        {{-- Modals --}}
        <upload-document-modal></upload-document-modal>
        <trade-modal></trade-modal>

    </div>

    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
</body>
</html>
