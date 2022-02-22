@extends('layouts.dashboard')

@section('title', 'Dashboard')

@push('breadcrumb')
<li class="breadcrumb-item">Pages</li>
<li class="breadcrumb-item active">Sample Page</li>
@endpush

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/date-picker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vector-map.css')}}">
@endpush
@section('content')
@yield('breadcrumb-list')
<!-- Container-fluid starts-->
<div class="container-fluid dashboard-default-sec">
    <div class="row">
        <div class="col-xl-5 box-col-12 des-xl-100">
            <div class="row">
                <div class="col-xl-12 col-md-6 box-col-6 des-xl-50">
                    <div class="card profile-greeting">
                        <div class="card-header">
                            <div class="header-top">
                                <div class="setting-list bg-primary position-unset">
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center p-t-0">
                            <h3 class="font-light">Wellcome Back, John!!</h3>
                            <p class="font-light"> Your account manager is available from 05:00am to 17:00pm Monday to Friday.</p>
                            <p class="font-light">If you need to speak to somebody outside of these ours, please</p>
                            <a class="btn btn-light" href="#">click here</a>
                        </div>
                        <div class="confetti">
                            <div class="confetti-piece"></div>
                            <div class="confetti-piece"></div>
                            <div class="confetti-piece"></div>
                            <div class="confetti-piece"></div>
                            <div class="confetti-piece"></div>
                            <div class="confetti-piece"></div>
                            <div class="confetti-piece"></div>
                            <div class="confetti-piece"></div>
                            <div class="confetti-piece"></div>
                            <div class="confetti-piece"></div>
                            <div class="confetti-piece"></div>
                            <div class="confetti-piece"></div>
                            <div class="confetti-piece"></div>
                            <div class="code-box-copy">
                                <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#profile-greeting" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-3 col-sm-6 box-col-3 des-xl-25 rate-sec">
                    <div class="card income-card card-primary">
                        <div class="card-body text-center">
                            <div class="round-box">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 448.057 448.057" style="enable-background:new 0 0 448.057 448.057;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M404.562,7.468c-0.021-0.017-0.041-0.034-0.062-0.051c-13.577-11.314-33.755-9.479-45.069,4.099                                            c-0.017,0.02-0.034,0.041-0.051,0.062l-135.36,162.56L88.66,11.577C77.35-2.031,57.149-3.894,43.54,7.417                                            c-13.608,11.311-15.471,31.512-4.16,45.12l129.6,155.52h-40.96c-17.673,0-32,14.327-32,32s14.327,32,32,32h64v144                                            c0,17.673,14.327,32,32,32c17.673,0,32-14.327,32-32v-180.48l152.64-183.04C419.974,38.96,418.139,18.782,404.562,7.468z"></path>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M320.02,208.057h-16c-17.673,0-32,14.327-32,32s14.327,32,32,32h16c17.673,0,32-14.327,32-32                                            S337.694,208.057,320.02,208.057z"></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <h5>8,50,49</h5>
                            <p>Our Annual Income</p><a class="btn-arrow arrow-primary" href="javascript:void(0)"><i class="toprightarrow-primary fa fa-arrow-up me-2"></i>95.54% </a>
                            <div class="parrten">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 448.057 448.057" style="enable-background:new 0 0 448.057 448.057;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M404.562,7.468c-0.021-0.017-0.041-0.034-0.062-0.051c-13.577-11.314-33.755-9.479-45.069,4.099                                            c-0.017,0.02-0.034,0.041-0.051,0.062l-135.36,162.56L88.66,11.577C77.35-2.031,57.149-3.894,43.54,7.417                                            c-13.608,11.311-15.471,31.512-4.16,45.12l129.6,155.52h-40.96c-17.673,0-32,14.327-32,32s14.327,32,32,32h64v144                                            c0,17.673,14.327,32,32,32c17.673,0,32-14.327,32-32v-180.48l152.64-183.04C419.974,38.96,418.139,18.782,404.562,7.468z"></path>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M320.02,208.057h-16c-17.673,0-32,14.327-32,32s14.327,32,32,32h16c17.673,0,32-14.327,32-32                                            S337.694,208.057,320.02,208.057z"> </path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-3 col-sm-6 box-col-3 des-xl-25 rate-sec">
                    <div class="card income-card card-secondary">
                        <div class="card-body text-center">
                            <div class="round-box">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M96,100.16                                            c50.315,35.939,80.124,94.008,80,155.84c0.151,61.839-29.664,119.919-80,155.84C11.45,325.148,11.45,186.851,96,100.16z M256,480                                            c-49.143,0.007-96.907-16.252-135.84-46.24C175.636,391.51,208.14,325.732,208,256c0.077-69.709-32.489-135.434-88-177.6                                            c80.1-61.905,191.9-61.905,272,0c-98.174,75.276-116.737,215.885-41.461,314.059c11.944,15.577,25.884,29.517,41.461,41.461                                            C353.003,463.884,305.179,480.088,256,480z M416,412v-0.16c-86.068-61.18-106.244-180.548-45.064-266.616                                            c12.395-17.437,27.627-32.669,45.064-45.064C500.654,186.871,500.654,325.289,416,412z"></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <h5>2,03,59</h5>
                            <p>our Annual losses</p><a class="btn-arrow arrow-secondary" href="javascript:void(0)"><i class="toprightarrow-secondary fa fa-arrow-up me-2"></i>90.54% </a>
                            <div class="parrten">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M96,100.16                                            c50.315,35.939,80.124,94.008,80,155.84c0.151,61.839-29.664,119.919-80,155.84C11.45,325.148,11.45,186.851,96,100.16z M256,480                                            c-49.143,0.007-96.907-16.252-135.84-46.24C175.636,391.51,208.14,325.732,208,256c0.077-69.709-32.489-135.434-88-177.6                                            c80.1-61.905,191.9-61.905,272,0c-98.174,75.276-116.737,215.885-41.461,314.059c11.944,15.577,25.884,29.517,41.461,41.461                                            C353.003,463.884,305.179,480.088,256,480z M416,412v-0.16c-86.068-61.18-106.244-180.548-45.064-266.616                                            c12.395-17.437,27.627-32.669,45.064-45.064C500.654,186.871,500.654,325.289,416,412z"></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7 box-col-12 des-xl-100 dashboard-sec">
            <div class="card income-card">
                <div class="card-header">
                    <div class="header-top d-sm-flex align-items-center">
                        <h5>Sales overview</h5>
                        <div class="center-content">
                            <p class="d-sm-flex align-items-center"><span class="font-primary m-r-10 f-w-700">$859.25k</span><i class="toprightarrow-primary fa fa-arrow-up m-r-10"></i>86% More than last year</p>
                        </div>
                        <div class="setting-list">
                            <ul class="list-unstyled setting-option">
                                <li>
                                    <div class="setting-primary"><i class="icon-settings"></i></div>
                                </li>
                                <li><i class="view-html fa fa-code font-primary"></i></li>
                                <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                                <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                                <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                                <li><i class="icofont icofont-error close-card font-primary"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="chart-timeline-dashbord"></div>
                    <div class="code-box-copy">
                        <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#yearly-overview" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 box-col-12 des-xl-100">
            <div class="row">
                <div class="col-xl-12 recent-order-sec">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="pull-left">My Portfolio</h5>
                        </div>
                        <div class="card-body">
                            <div class="tabbed-card">
                                <ul class="pull-right nav nav-tabs border-tab nav-success" id="top-tabdanger" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="top-home-danger" data-bs-toggle="tab" href="#top-homedanger" role="tab" aria-controls="top-homedanger" aria-selected="false"><i class="icofont icofont-ui-home"></i>Stocks</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-top-danger" data-bs-toggle="tab" href="#top-profiledanger" role="tab" aria-controls="top-profiledanger" aria-selected="true">
                                            <i class="icofont icofont-man-in-glasses"></i>Mutual Funds
                                        </a>
                                        <div class="material-border"></div>
                                    </li>
                                </ul>
                                <div class="tab-content" id="top-tabContentdanger">
                                    <div class="tab-pane fade" id="top-homedanger" role="tabpanel" aria-labelledby="top-home-tab">
                                        <div class="table-responsive">
                                            <!-- <h5>Recent Orders</h5> -->
                                            <table class="table table-bordernone">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Date</th>
                                                        <th>Quantity</th>
                                                        <th>Value</th>
                                                        <th>Rate</th>
                                                        <th>
                                                            <!-- <div class="setting-list">
                                                                <ul class="list-unstyled setting-option">
                                                                    <li>
                                                                        <div class="setting-primary"><i class="icon-settings"> </i></div>
                                                                    </li>
                                                                    <li><i class="view-html fa fa-code font-primary"></i></li>
                                                                    <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                                                                    <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                                                                    <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                                                                    <li><i class="icofont icofont-error close-card font-primary"></i></li>
                                                                </ul>
                                                            </div> -->
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="media"><img class="img-fluid rounded-circle" src="{{asset('assets/images/dashboard/product-1.png')}}" alt="" data-original-title="" title="">
                                                                <div class="media-body"><a href="#"><span>Yellow New Nike shoes</span></a></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p>16 August</p>
                                                        </td>
                                                        <td>
                                                            <p>54146</p>
                                                        </td>
                                                        <td><img class="img-fluid" src="{{asset('assets/images/dashboard/graph-1.png')}}" alt="" data-original-title="" title=""></td>
                                                        <td>
                                                            <p>$210326</p>
                                                        </td>
                                                        <td>
                                                            <p>Done</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="media"><img class="img-fluid rounded-circle" src="{{asset('assets/images/dashboard/product-2.png')}}" alt="" data-original-title="" title="">
                                                                <div class="media-body"><a href="#"><span>Sony Brand New Headphone</span></a></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p>2 October</p>
                                                        </td>
                                                        <td>
                                                            <p>32015</p>
                                                        </td>
                                                        <td><img class="img-fluid" src="{{asset('assets/images/dashboard/graph-2.png')}}" alt="" data-original-title="" title=""></td>
                                                        <td>
                                                            <p>$548526</p>
                                                        </td>
                                                        <td>
                                                            <p>Done</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="media"><img class="img-fluid rounded-circle" src="{{asset('assets/images/dashboard/product-3.png')}}" alt="" data-original-title="" title="">
                                                                <div class="media-body"><a href="#"><span>Beautiful Golden Tree plant</span></a></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p>21 March</p>
                                                        </td>
                                                        <td>
                                                            <p>12548</p>
                                                        </td>
                                                        <td><img class="img-fluid" src="{{asset('assets/images/dashboard/graph-3.png')}}" alt="" data-original-title="" title=""></td>
                                                        <td>
                                                            <p>$589565</p>
                                                        </td>
                                                        <td>
                                                            <p>Done</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="media"><img class="img-fluid rounded-circle" src="{{asset('assets/images/dashboard/product-4.png')}}" alt="" data-original-title="" title="">
                                                                <div class="media-body"><a href="#"><span>Marco M Kely Handbeg</span></a></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p>31 December</p>
                                                        </td>
                                                        <td>
                                                            <p>15495</p>
                                                        </td>
                                                        <td><img class="img-fluid" src="{{asset('assets/images/dashboard/graph-4.png')}}" alt="" data-original-title="" title=""></td>
                                                        <td>
                                                            <p>$125424 </p>
                                                        </td>
                                                        <td>
                                                            <p>Done</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="media"><img class="img-fluid rounded-circle" src="{{asset('assets/images/dashboard/product-5.png')}}" alt="" data-original-title="" title="">
                                                                <div class="media-body"><a href="#"><span>Being Human Branded T-Shirt </span></a></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p>26 January</p>
                                                        </td>
                                                        <td>
                                                            <p>56625</p>
                                                        </td>
                                                        <td><img class="img-fluid" src="{{asset('assets/images/dashboard/graph-5.png')}}" alt="" data-original-title="" title=""></td>
                                                        <td>
                                                            <p>$112103</p>
                                                        </td>
                                                        <td>
                                                            <p>Done</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- <div class="code-box-copy">
                                        <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#recent-order" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                                    </div> -->
                                    <div class="tab-pane fade active show" id="top-profiledanger" role="tabpanel" aria-labelledby="profile-top-tab">
                                        <div class="table-responsive">
                                            <!-- <h5>Recent Orders</h5> -->
                                            <table class="table table-bordernone">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Date</th>
                                                        <th>Quantity</th>
                                                        <th>Value</th>
                                                        <th>Rate</th>
                                                        <th>
                                                            <!-- <div class="setting-list">
                                                                <ul class="list-unstyled setting-option">
                                                                    <li>
                                                                        <div class="setting-primary"><i class="icon-settings"> </i></div>
                                                                    </li>
                                                                    <li><i class="view-html fa fa-code font-primary"></i></li>
                                                                    <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                                                                    <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                                                                    <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                                                                    <li><i class="icofont icofont-error close-card font-primary"></i></li>
                                                                </ul>
                                                            </div> -->
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="media"><img class="img-fluid rounded-circle" src="{{asset('assets/images/dashboard/product-1.png')}}" alt="" data-original-title="" title="">
                                                                <div class="media-body"><a href="#"><span>Yellow New Nike shoes</span></a></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p>16 August</p>
                                                        </td>
                                                        <td>
                                                            <p>54146</p>
                                                        </td>
                                                        <td><img class="img-fluid" src="{{asset('assets/images/dashboard/graph-1.png')}}" alt="" data-original-title="" title=""></td>
                                                        <td>
                                                            <p>$210326</p>
                                                        </td>
                                                        <td>
                                                            <p>Done</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="media"><img class="img-fluid rounded-circle" src="{{asset('assets/images/dashboard/product-2.png')}}" alt="" data-original-title="" title="">
                                                                <div class="media-body"><a href="#"><span>Sony Brand New Headphone</span></a></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p>2 October</p>
                                                        </td>
                                                        <td>
                                                            <p>32015</p>
                                                        </td>
                                                        <td><img class="img-fluid" src="{{asset('assets/images/dashboard/graph-2.png')}}" alt="" data-original-title="" title=""></td>
                                                        <td>
                                                            <p>$548526</p>
                                                        </td>
                                                        <td>
                                                            <p>Done</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="media"><img class="img-fluid rounded-circle" src="{{asset('assets/images/dashboard/product-3.png')}}" alt="" data-original-title="" title="">
                                                                <div class="media-body"><a href="#"><span>Beautiful Golden Tree plant</span></a></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p>21 March</p>
                                                        </td>
                                                        <td>
                                                            <p>12548</p>
                                                        </td>
                                                        <td><img class="img-fluid" src="{{asset('assets/images/dashboard/graph-3.png')}}" alt="" data-original-title="" title=""></td>
                                                        <td>
                                                            <p>$589565</p>
                                                        </td>
                                                        <td>
                                                            <p>Done</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="media"><img class="img-fluid rounded-circle" src="{{asset('assets/images/dashboard/product-4.png')}}" alt="" data-original-title="" title="">
                                                                <div class="media-body"><a href="#"><span>Marco M Kely Handbeg</span></a></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p>31 December</p>
                                                        </td>
                                                        <td>
                                                            <p>15495</p>
                                                        </td>
                                                        <td><img class="img-fluid" src="{{asset('assets/images/dashboard/graph-4.png')}}" alt="" data-original-title="" title=""></td>
                                                        <td>
                                                            <p>$125424 </p>
                                                        </td>
                                                        <td>
                                                            <p>Done</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="media"><img class="img-fluid rounded-circle" src="{{asset('assets/images/dashboard/product-5.png')}}" alt="" data-original-title="" title="">
                                                                <div class="media-body"><a href="#"><span>Being Human Branded T-Shirt </span></a></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p>26 January</p>
                                                        </td>
                                                        <td>
                                                            <p>56625</p>
                                                        </td>
                                                        <td><img class="img-fluid" src="{{asset('assets/images/dashboard/graph-5.png')}}" alt="" data-original-title="" title=""></td>
                                                        <td>
                                                            <p>$112103</p>
                                                        </td>
                                                        <td>
                                                            <p>Done</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-50 box-col-6 des-xl-50">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5>Growth Overview</h5>
                                <div class="center-content">
                                    <p class="d-flex align-items-center"><i class="toprightarrow-primary fa fa-arrow-up me-2"></i>80% Growth</p>
                                </div>
                                <div class="setting-list">
                                    <ul class="list-unstyled setting-option">
                                        <li>
                                            <div class="setting-primary"><i class="icon-settings"> </i></div>
                                        </li>
                                        <li><i class="view-html fa fa-code font-primary"></i></li>
                                        <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                                        <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                                        <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                                        <li><i class="icofont icofont-error close-card font-primary"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div id="chart-dashbord"></div>
                            <div class="code-box-copy">
                                <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#sell-overview" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-50 box-col-6 des-xl-50">
                    <div class="card latest-update-sec">
                        <div class="card-header">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5>Latest activity</h5>
                                <div class="center-content">
                                    <ul class="week-date">
                                        <li class="font-primary">Today</li>
                                        <li>Month </li>
                                    </ul>
                                </div>
                                <div class="setting-list">
                                    <ul class="list-unstyled setting-option">
                                        <li>
                                            <div class="setting-primary"><i class="icon-settings"></i></div>
                                        </li>
                                        <li><i class="view-html fa fa-code font-primary"></i></li>
                                        <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                                        <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                                        <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                                        <li><i class="icofont icofont-error close-card font-primary"> </i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordernone">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="media">
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve">
                                                        <g>
                                                            <g>
                                                                <path d="M506.35,80.699c-7.57-7.589-19.834-7.609-27.43-0.052L331.662,227.31l-42.557-42.557c-7.577-7.57-19.846-7.577-27.423,0                                                      L89.076,357.36c-7.577,7.57-7.577,19.853,0,27.423c3.782,3.788,8.747,5.682,13.712,5.682c4.958,0,9.93-1.894,13.711-5.682                                                      l158.895-158.888l42.531,42.524c7.57,7.57,19.808,7.577,27.397,0.032l160.97-160.323                                                      C513.881,100.571,513.907,88.288,506.35,80.699z"></path>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <path d="M491.96,449.94H38.788V42.667c0-10.712-8.682-19.394-19.394-19.394S0,31.955,0,42.667v426.667                                                      c0,10.712,8.682,19.394,19.394,19.394H491.96c10.712,0,19.394-8.682,19.394-19.394C511.354,458.622,502.672,449.94,491.96,449.94z                                                      "></path>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <path d="M492.606,74.344H347.152c-10.712,0-19.394,8.682-19.394,19.394s8.682,19.394,19.394,19.394h126.061v126.067                                                      c0,10.705,8.682,19.394,19.394,19.394S512,249.904,512,239.192V93.738C512,83.026,503.318,74.344,492.606,74.344z"></path>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                    <div class="media-body"><span>Google project Apply Review</span>
                                                        <p>Complete in 3 Hours</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a href="#" target="_blank">Edit</a></td>
                                            <td><a href="#" target="_blank">Delete</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="media">
                                                    <svg enable-background="new 0 0 512 512" viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="m362 91v-60h-212v60h-150v390h512c0-16.889 0-372.29 0-390zm-182-30h152v30h-152zm302 390h-452v-202.844l90 36v46.844h90v-30h92v30h90v-46.844l90-36zm-302-150h-30v-60h30zm152-60h30v60h-30c0-7.259 0-52.693 0-60zm150-25.156-90 36v-40.844h-90v60h-92v-60h-90v40.844l-90-36c0-14.163 0-84.634 0-94.844h452z"></path>
                                                    </svg>
                                                    <div class="media-body"><span>Business Logo Create</span>
                                                        <p>Complete in 2 Days</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a href="#" target="_blank">Edit</a></td>
                                            <td><a href="#" target="_blank">Delete</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="media">
                                                    <svg enable-background="new 0 0 512 512" viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                                        <g>
                                                            <path d="m345.622 126.038c-50.748-45.076-130.482-46.914-183.244 3.903-21.262 20.478-35.375 47.381-39.737 75.754-5.454 35.471 2.872 70.834 23.444 99.576 56.271 78.616 49.132 141.058 49.915 145.691 0 16.435 6.211 31.795 17.491 43.253 11.289 11.469 26.386 17.785 42.509 17.785 33.084 0 60-26.916 60-60 .686-4.269-6.11-72.81 47.676-143.691 17.875-23.557 27.324-51.673 27.324-81.309 0-38.547-16.54-75.347-45.378-100.962zm-89.622 355.962c-16.486 0-29.462-13.096-29.975-30h59.975c0 16.542-13.458 30-30 30zm83.777-191.826c-30.015 39.554-47.946 84.707-52.569 131.826h-62.57c-4.961-45.331-23.43-91.26-54.157-134.19-15.985-22.333-22.444-49.876-18.188-77.556 7.293-47.43 49.733-88.262 103.846-88.262 58.661 0 104.861 47.891 104.861 105.008 0 23.032-7.339 44.877-21.223 63.174z"></path>
                                                            <path d="m256 62c8.284 0 15-6.716 15-15v-32c0-8.284-6.716-15-15-15s-15 6.716-15 15v32c0 8.284 6.716 15 15 15z"></path>
                                                            <path d="m419.385 149.99 25.98-15c7.174-4.142 9.632-13.316 5.49-20.49-4.142-7.175-13.316-9.633-20.49-5.49l-25.98 15c-7.174 4.142-9.632 13.316-5.49 20.49 4.162 7.21 13.349 9.613 20.49 5.49z"></path>
                                                            <path d="m92.615 304.01-25.98 15c-7.174 4.142-9.632 13.316-5.49 20.49 4.163 7.21 13.35 9.613 20.49 5.49l25.98-15c7.174-4.142 9.632-13.316 5.49-20.49-4.141-7.175-13.316-9.632-20.49-5.49z"></path>
                                                            <path d="m338.5 84.105c7.141 4.124 16.33 1.716 20.49-5.49l15-25.98c4.142-7.174 1.684-16.348-5.49-20.49-7.174-4.144-16.349-1.685-20.49 5.49l-15 25.98c-4.142 7.175-1.684 16.348 5.49 20.49z"></path>
                                                            <path d="m153.01 78.615c4.163 7.21 13.35 9.613 20.49 5.49 7.174-4.142 9.632-13.316 5.49-20.49l-15-25.98c-4.142-7.174-13.315-9.633-20.49-5.49-7.174 4.142-9.632 13.316-5.49 20.49z"></path>
                                                            <path d="m445.365 319.01-25.98-15c-7.175-4.143-16.349-1.684-20.49 5.49-4.142 7.174-1.684 16.348 5.49 20.49l25.98 15c7.141 4.124 16.33 1.716 20.49-5.49 4.143-7.174 1.685-16.348-5.49-20.49z"></path>
                                                            <path d="m107.615 124.01-25.98-15c-7.175-4.144-16.348-1.684-20.49 5.49s-1.684 16.348 5.49 20.49l25.98 15c7.141 4.124 16.33 1.716 20.49-5.49 4.143-7.174 1.685-16.348-5.49-20.49z"></path>
                                                            <path d="m466 212h-30c-8.284 0-15 6.716-15 15s6.716 15 15 15h30c8.284 0 15-6.716 15-15s-6.716-15-15-15z"></path>
                                                            <path d="m91 227c0-8.284-6.716-15-15-15h-30c-8.284 0-15 6.716-15 15s6.716 15 15 15h30c8.284 0 15-6.716 15-15z"></path>
                                                            <path d="m275.394 216.394-19.394 19.393-19.394-19.393c-5.857-5.858-15.355-5.858-21.213 0s-5.858 15.355 0 21.213l25.607 25.606v53.787c0 8.284 6.716 15 15 15s15-6.716 15-15v-53.787l25.606-25.606c5.858-5.858 5.858-15.355 0-21.213-5.857-5.859-15.355-5.859-21.212 0z"></path>
                                                        </g>
                                                    </svg>
                                                    <div class="media-body"><span>Business Project Research</span>
                                                        <p>Due in 1 hour</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a href="#" target="_blank">Edit</a></td>
                                            <td><a href="#" target="_blank">Delete</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="media">
                                                    <svg enable-background="new 0 0 512 512" viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                                        <g>
                                                            <path d="m512 390v-390h-512v390h241v32h-15c-41.355 0-75 33.645-75 75v15h210v-15c0-41.355-33.645-75-75-75h-15v-32zm-226 62c19.556 0 36.239 12.539 42.43 30h-144.86c6.191-17.461 22.874-30 42.43-30zm-256-92v-330h452v330c-12.164 0-438.947 0-452 0z"></path>
                                                            <path d="m136 180c24.813 0 45-20.187 45-45s-20.187-45-45-45-45 20.187-45 45 20.187 45 45 45zm0-60c8.271 0 15 6.729 15 15s-6.729 15-15 15-15-6.729-15-15 6.729-15 15-15z"></path>
                                                            <path d="m184.568 197.848c-28.678-24.39-60.953-16.827-61.054-16.833-35.639 5.799-62.514 38.985-62.514 77.196v41.789h150v-45c0-22.034-9.634-42.865-26.432-57.152zm-3.568 72.152h-90v-11.789c0-23.666 16.049-44.122 37.332-47.584 13.509-2.198 26.578 1.38 36.801 10.074 10.083 8.577 15.867 21.078 15.867 34.299z"></path>
                                                            <path d="m241 270h120v30h-120z"></path>
                                                            <path d="m241 210h210v30h-210z"></path>
                                                            <path d="m241 150h210v30h-210z"></path>
                                                            <path d="m331 90h120v30h-120z"></path>
                                                            <path d="m241 90h60v30h-60z"></path>
                                                            <path d="m391 270h60v30h-60z"></path>
                                                        </g>
                                                    </svg>
                                                    <div class="media-body"><span>Recruitment in IT Depertment</span>
                                                        <p>Complete in 3 Hours</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a href="#" target="_blank">Edit</a></td>
                                            <td><a href="#" target="_blank">Delete</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="media">
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                        <g>
                                                            <g>
                                                                <path d="M256,0C114.848,0,0,114.848,0,256s114.848,256,256,256s256-114.848,256-256S397.152,0,256,0z M256,480                                                      C132.48,480,32,379.52,32,256S132.48,32,256,32s224,100.48,224,224S379.52,480,256,480z"></path>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <path d="M340.688,292.688L272,361.376V96h-32v265.376l-68.688-68.688l-22.624,22.624l96,96c3.12,3.12,7.216,4.688,11.312,4.688                                                      s8.192-1.568,11.312-4.688l96-96L340.688,292.688z"></path>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                    <div class="media-body"><span>Submit Riverfront Project</span>
                                                        <p>Complete in 2 Days</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a href="#" target="_blank">Edit</a></td>
                                            <td><a href="#" target="_blank">Delete </a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="code-box-copy">
                                <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#latest-update-sec" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 box-col-12 des-xl-100">
            <div class="row">
                <div class="col-xl-12 box-col-6 des-xl-50">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5>User Activations</h5>
                                <div class="center-content">
                                    <p>Yearly User 24.65k</p>
                                </div>
                                <div class="setting-list">
                                    <ul class="list-unstyled setting-option">
                                        <li>
                                            <div class="setting-primary"><i class="icon-settings"></i></div>
                                        </li>
                                        <li><i class="view-html fa fa-code font-primary"></i></li>
                                        <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                                        <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                                        <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                                        <li><i class="icofont icofont-error close-card font-primary"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div id="user-activation-dash-2"></div>
                            <div class="code-box-copy">
                                <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#user-activations" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 box-col-6 des-xl-50">
                    <div class="card trasaction-sec">
                        <div class="card-header">
                            <div class="header-top d-sm-flex align-items-center">
                                <h5>Transaction</h5>
                                <div class="center-content">
                                    <p>5878 Suceessfull Transaction</p>
                                </div>
                                <div class="setting-list">
                                    <ul class="list-unstyled setting-option">
                                        <li>
                                            <div class="setting-secondary"><i class="icon-settings"> </i></div>
                                        </li>
                                        <li><i class="view-html fa fa-code font-secondary"></i></li>
                                        <li><i class="icofont icofont-maximize full-card font-secondary"></i></li>
                                        <li><i class="icofont icofont-minus minimize-card font-secondary"></i></li>
                                        <li><i class="icofont icofont-refresh reload-card font-secondary"></i></li>
                                        <li><i class="icofont icofont-error close-card font-secondary"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="transaction-totalbal">
                            <h2> $2,09,352k <span class="ms-3"> <a class="btn-arrow arrow-secondary" href="javascript:void(0)"><i class="toprightarrow-secondary fa fa-arrow-up me-2"></i>98.54%</a></span></h2>
                            <p>Total Balance</p>
                        </div>
                        <div class="card-body p-0">
                            <div id="chart-3dash"></div>
                            <div class="code-box-copy">
                                <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#transaction" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- Container-fluid Ends-->
@push('scripts')
<script src="{{asset('assets/js/chart/chartist/chartist.js')}}"></script>
<script src="{{asset('assets/js/chart/chartist/chartist-plugin-tooltip.js')}}"></script>
<script src="{{asset('assets/js/chart/knob/knob.min.js')}}"></script>
<script src="{{asset('assets/js/chart/knob/knob-chart.js')}}"></script>
<script src="{{asset('assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<script src="{{asset('assets/js/chart/apex-chart/stock-prices.js')}}"></script>
<script src="{{asset('assets/js/prism/prism.min.js')}}"></script>
<script src="{{asset('assets/js/clipboard/clipboard.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/js/counter/counter-custom.js')}}"></script>
<script src="{{asset('assets/js/custom-card/custom-card.js')}}"></script>
<script src="{{asset('assets/js/notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('assets/js/vector-map/jquery-jvectormap-2.0.2.min.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-us-aea-en.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-uk-mill-en.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-au-mill.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-in-mill.js')}}"></script>
<script src="{{asset('assets/js/vector-map/map/jquery-jvectormap-asia-mill.js')}}"></script>
<script src="{{asset('assets/js/dashboard/default.js')}}"></script>
<script src="{{asset('assets/js/notify/index.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
@endpush
@endsection