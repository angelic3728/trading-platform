@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row pt-4 pt-lg-5">
        <div class="col">
            <h1>Overview</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <portfolio></portfolio>
        </div>

        <div class="col-lg-4">
            @if(isset($account_manager))
                <div class="card account-manager" id="account-manager">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="mb-0">Account Manager</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="name">
                            <img src="{{ $account_manager->avatar_url }}" alt=""> {{ $account_manager->first_name }} {{ $account_manager->last_name }}
                        </div>
                        <div class="details">
                          <li><strong>E-mail Address:</strong> {{ $account_manager->email }}</li>
                          <li><strong>Phone Number:</strong> {{ $account_manager->phone }}</li>
                          <li><strong>Availability:</strong> {{ array_get($account_manager->extra, 'availability', 'Unknown') }}</li>
                        </div>
                    </div>
                </div>
            @else
                <div id="account-manager"></div>
            @endif

            <div class="card balance" id="balance">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-0">Cash On Account</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <strong>Balance:</strong> {{ auth()->user()->getBalance() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row highlighted-stocks">
        <div class="col">
            <h2>Highlighted Stocks</h2>
        </div>
    </div>

    <highlighted-stocks></highlighted-stocks>

    @if($documents->isNotEmpty())
        <div class="row highlighted-stocks">
            <div class="col">
                <h2>Recent Documents</h2>
            </div>
        </div>

        <div class="card recent-documents" id="recent-documents">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Type</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Provided by</th>
                            <th scope="col">Date</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $document)
                            <tr>
                                <td class="type">{{ $document->type }}</td>
                                <td width="20%" class="title">{{ $document->title }}</td>
                                <td width="40%" class="description">{{ $document->description }}</td>
                                <td class="text-nowrap">{{ $document->provider->first_name }} {{ $document->provider->last_name }}</td>
                                <td class="text-nowrap">{{ $document->created_at }}</td>
                                <td class="text-right">
                                    <a href="{{ route('documents.download', ['id' => $document->id]) }}" target="_blank">Download</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <news :symbols="{{ json_encode($news_symbols) }}"></news>
</div>
@endsection
