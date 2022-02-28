@extends('layouts.dashboard')

@section('title', 'Documents')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')

<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Documents</h5>
            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#documentUploadModal">Upload</button>
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
    <div class="modal fade" id="documentUploadModal" tabindex="-1" role="dialog" aria-labelledby="Buy Shares Modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buy Shares</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('api.documents.store') }}" method="post" id="upload_doc_form" enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="doc_title">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter the title of the document" required>
                            <div class="invalid-feedback">Please provide a valid document title.</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea rows="3" class="form-control" name="description" placeholder="Enter an optional description"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">File</label>
                            <input type="file" class="form-control" name="file" placeholder="Select your file" required>
                            <div class="invalid-feedback">Please choose your document file</div>
                        </div>
                        <input type="submit" class="d-none" id="submit_form_btn">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" onclick="upload(this)">Upload</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{asset('assets/js/notify/bootstrap-notify.min.js')}}"></script>
<script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
<script>
    function upload(obj) {
        $("#submit_form_btn").click();
        $(obj).attr('onclick', '');
        $(obj).html('<i class="fa fa-spin fa-spinner"></i>');
    }
    if ("{{Session::has('uploaded')}}")
        $.notify('<i class="fa fa-bell-o"></i>{{ Session::get("uploaded") }}', {
            type: 'theme',
            allow_dismiss: true,
            delay: 2000,
            showProgressbar: false,
            timer: 300
        });
</script>
@endpush

@endsection