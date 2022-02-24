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
            <h5>Documents</h5>
            <button type="button" class="btn btn-outline-success btn-sm">Upload</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
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
    </div>
</div>
<!-- Zero Configuration  Ends-->

@push('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endpush

@endsection