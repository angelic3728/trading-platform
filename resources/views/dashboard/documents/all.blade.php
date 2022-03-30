@extends('layouts.dashboard')

@section('title', 'Documents')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')

<div class="col-sm-12 dashboard-content-wrapper">
    <div class="col-xl-12">
        <div class="d-flex justify-content-center align-items-center" id="ad1_container">
            <a href="{{$ads[0]['link']}}#" target="_blank">
                <img src="{{ 'storage/'.$ads[0]['source'] }}" class="img-fluid" alt="">
            </a>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center" id="ad2_container">
        <ul>
            <li>
                <a href="{{$ads[0]['link']}}#" target="_blank">
                    <img src="{{ 'storage/'.$ads[1]['source'] }}" class="img-fluid" alt="">
                </a>
            </li>
        </ul>
        <a href="javascript:void(0)" onclick="hide_ad()" style="position: absolute; top:10px; right:10px;"><i class="fa fa-times fs-5"></i></a>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Documents</h5>
            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#documentUploadModal">Upload</button>
        </div>
        <div class="card-body">
            <div class="table-responsive-md">
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
    <div class="col-xl-12 box-col-12 des-xl-100">
        <div class="card news-container">
            <div class="card-header d-flex justify-content-between">
                <div class="header-top d-sm-flex align-items-center">
                    <h5>Recent News</h5>
                </div>
                <a href="/news?symbols={{implode(',', $news_symbols)}}" class="btn btn-outline-success btn-xs" style="line-height: 20px;">See More</a>
            </div>
            <div class="card-body">
                <div class="loader-box news-loader justify-content-center align-items-center w-full" style="inset:0px; position:absolute; z-index:10; display:flex; height:initial;">
                    <div class="loader-19"></div>
                </div>
                <div class="row news-content" style="min-height: 440px;">
                    <div class="col-xl-3 col-md-6 news-0" style="display: none;">
                        <a href="" class="news-link-0" target="_blank">
                            <div class="prooduct-details-box">
                                <div class="media" style="text-align: center; padding:10px 0px; min-height:410px;">
                                    <img class="align-self-center img-fluid news-img-0" src="" style="max-height: 180px;" alt="#">
                                    <div class="media-body">
                                        <p class="news-date-0 text-dark mb-0"></p>
                                        <h6 class="news-headline-0"></h6>
                                        <div class="summary news-summary-0"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 news-1" style="display: none;">
                        <a href="" class="news-link-1" target="_blank">
                            <div class="prooduct-details-box">
                                <div class="media" style="text-align: center; padding:10px 0px; min-height:410px;">
                                    <img class="align-self-center img-fluid news-img-1" src="" style="max-height: 180px;" alt="#">
                                    <div class="media-body">
                                        <p class="news-date-1 text-dark mb-0"></p>
                                        <h6 class="news-headline-1"></h6>
                                        <div class="summary news-summary-1"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 news-2" style="display: none;">
                        <a href="" class="news-link-2" target="_blank">
                            <div class="prooduct-details-box">
                                <div class="media" style="text-align: center; padding:10px 0px; min-height:410px;">
                                    <img class="align-self-center img-fluid news-img-2" src="" style="max-height: 180px;" alt="#">
                                    <div class="media-body">
                                        <p class="news-date-2 text-dark mb-0"></p>
                                        <h6 class="news-headline-2"></h6>
                                        <div class="summary news-summary-2"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 news-3" style="display: none;">
                        <a href="" class="news-link-3" target="_blank">
                            <div class="prooduct-details-box">
                                <div class="media" style="text-align: center; padding:10px 0px; min-height:410px;">
                                    <img class="align-self-center img-fluid news-img-3" src="" style="max-height: 180px;" alt="#">
                                    <div class="media-body">
                                        <p class="news-date-3 text-dark mb-0"></p>
                                        <h6 class="news-headline-3"></h6>
                                        <div class="summary news-summary-3"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row no-news" style="display: none;">
                    <div class="col-sm-12">
                        <div class="alert alert-light dark alert-dismissible fade show" id="zero_shares_alert" role="alert">
                            There are no recent news.
                        </div>
                    </div>
                </div>
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
                            <input type="text" id="doc_title" class="form-control" name="title" placeholder="Enter the title of the document" required>
                            <div class="invalid-feedback">Please provide a valid document title.</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea rows="3" class="form-control" name="description" placeholder="Enter an optional description"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">File</label>
                            <input type="file" class="form-control" id="doc_file" name="file" placeholder="Select your file" required>
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
        if ($('#doc_title').val().trim().length !== 0 && $('#doc_file').val() != "") {
            $(obj).attr('onclick', '');
            $(obj).html('<i class="fa fa-spin fa-spinner"></i>');
        }
    }

    function hide_ad() {
        $("#ad1_container").removeClass("d-flex");
        $("#ad1_container").addClass("d-none");
        $("#ad2_container").removeClass("d-flex");
        $("#ad2_container").addClass("d-none");
        $(".dashboard-content-wrapper").css("padding-right", "0px");
        $(".dashboard-content-wrapper").css("padding-top", "0px");
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