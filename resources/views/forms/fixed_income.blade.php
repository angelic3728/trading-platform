@extends('layouts.fdashboard')

@section('title', 'Forms')

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/date-picker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vector-map.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/scrollable.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/owlcarousel.css')}}">
@endpush
@section('content')
<!-- Container-fluid starts-->
<div class="container-fluid dashboard-default-sec" style="padding: 0px;">
    <div class="row dashboard-content-wrapper">
        <div class="col-xl-12">
            <div class="d-flex justify-content-center align-items-center" id="ad1_container">
                @if($ads[0])
                <a href="{{$ads[0]['link']}}#" target="_blank">
                    <img src="{{ '/storage/'.$ads[0]['source'] }}" class="img-fluid" alt="">
                </a>
                @else
                <b>No Advertising.</b>
                @endif
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center" id="ad2_container">
            <ul>
                <li>
                    @if($ads[1])
                    <a href="{{$ads[1]['link']}}#" target="_blank">
                        <img src="{{ '/storage/'.$ads[1]['source'] }}" class="img-fluid" alt="">
                    </a>
                    @else
                    <b>No Advertising.</b>
                    @endif
                </li>
            </ul>
            <a href="javascript:void(0)" onclick="hide_ad()" style="position: absolute; top:10px; right:10px;"><i class="fa fa-times fs-5"></i></a>
        </div>
        <div class="col-xl-12 box-col-12 des-xl-100">
            <div class="card">
                <div class="card-header">
                    <h2>Application Form</h2>
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <p class="fw-semibold m-t-15 m-b-5 fs-6">Please use <b>BLOCK</b> letters and a black or blue pen to complete this Application Form.</p>
                    <p class="fw-semibold m-b-5 fs-6">Please make sure that all questions are answered. Please indicate using an ‘X’ where appropriate. If a section does not apply to you, please indicate using ‘N/A’.</p>
                    <p class="fw-bold m-b-5 fs-6">List both names where account is in joint names.</p>
                    <form action="{{ route('application_form') }}" method="POST">
                        @csrf
                        <h5 class="p-t-20 p-b-20 bg-danger w-full txt-white p-l-30 fw-bold" style="margin: 0 -30px;">Step 1 Customer Details</h5>
                        <div class="row">
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2  col-sm-4 col-xs-12 col-form-label fs-6">
                                        Title
                                    </label>
                                    <div class="col-md-5  col-sm-8 col-xs-12  m-checkbox-inline">
                                        <label class="fs-6"><input name="income_item_1" class="checkbox_animated" value="1" type="radio" required>
                                            Mr
                                        </label>
                                        <label class="fs-6"><input name="income_item_1" class="checkbox_animated" value="2" type="radio" required>
                                            Mrs
                                        </label>
                                        <label class="fs-6"><input name="income_item_1" class="checkbox_animated" value="3" type="radio" required>
                                            Ms
                                        </label>
                                        <label class="fs-6"><input name="income_item_1" class="checkbox_animated" value="4" type="radio" required>
                                            Miss
                                        </label>
                                    </div>
                                    <div class="col-md-5 col-sm-12">
                                        <div class="row">
                                            <label class="col-sm-3 col-form-label fs-6">Date of Birth</label>
                                            <div class="col-sm-9">
                                                <input name="income_item_2" class="form-control digits" type="date" value="2000-01-19">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-form-label fs-6">
                                        SurName
                                    </label>
                                    <div class="col-md-10 col-sm-8">
                                        <input name="income_item_3" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-form-label fs-6">
                                        Given Name(2)
                                    </label>
                                    <div class="col-md-10 col-sm-8">
                                        <input name="income_item_4" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4">
                                        <label class="fs-6">Residential address</label><br>
                                        <span>(not a PO box)</span>
                                    </label>
                                    <div class="col-md-10 col-sm-8 m-t-5">
                                        <input name="income_item_5" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                        Street Name
                                    </label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <input name="income_item_6" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                        Surburb
                                    </label>
                                    <div class="col-md-6 col-sm-8 col-xs-12">
                                        <input name="income_item_7" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="row">
                                            <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                                State
                                            </label>
                                            <div class="col-md-10 col-sm-8 col-xs-12">
                                                <input name="income_item_8" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                        Postcode
                                    </label>
                                    <div class="col-md-4 col-sm-8 col-xs-12">
                                        <input name="income_item_9" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="row">
                                            <label class="col-md-5 col-sm-6 col-xs-12 col-form-label fs-6 text-center">
                                                Country (if not AUS)
                                            </label>
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <input name="income_item_10" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                        Phone
                                    </label>
                                    <div class="col-md-4 col-sm-8 col-xs-12">
                                        <input name="income_item_11" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="row">
                                            <label class="col-md-5 col-sm-6 col-xs-12 col-form-label fs-6 text-center">
                                                Mobile
                                            </label>
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <input name="income_item_12" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                        Email
                                    </label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <input name="income_item_13" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                        Customer Number
                                    </label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <input name="income_item_14" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="p-t-10 p-b-10 w-full m-t-25 txt-white p-l-30 fw-bold" style="margin: 0 -30px; background:#ed5c6a;">Joint customer details (if applicable)</h5>
                        <div class="row">
                            <div class="col-md-12 m-t-25">
                                <div class="row">
                                    <label class="col-md-2  col-sm-4 col-xs-12 fs-6">
                                        Title
                                    </label>
                                    <div class="col-md-5  col-sm-8 col-xs-12  m-checkbox-inline">
                                        <label class="fs-6"><input name="income_item_15" class="checkbox_animated" value="1" type="radio" required>
                                            Mr
                                        </label>
                                        <label class="fs-6"><input name="income_item_15" class="checkbox_animated" value="2" type="radio" required>
                                            Mrs
                                        </label>
                                        <label class="fs-6"><input name="income_item_15" class="checkbox_animated" value="3" type="radio" required>
                                            Ms
                                        </label>
                                        <label class="fs-6"><input name="income_item_15" class="checkbox_animated" value="4" type="radio" required>
                                            Miss
                                        </label>
                                    </div>
                                    <div class="col-md-5 col-sm-12">
                                        <div class="row">
                                            <label class="col-sm-3 col-form-label fs-6">Date of Birth</label>
                                            <div class="col-sm-9">
                                                <input name="income_item_16" class="form-control digits" type="date" value="2000-01-19">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 fs-6">
                                        SurName
                                    </label>
                                    <div class="col-md-10 col-sm-8">
                                        <input name="income_item_17" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-form-label fs-6">
                                        Given Name(2)
                                    </label>
                                    <div class="col-md-10 col-sm-8">
                                        <input name="income_item_18" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4">
                                        <label class="fs-6">Residential address</label><br>
                                        <span>(not a PO box)</span>
                                    </label>
                                    <div class="col-md-10 col-sm-8 m-t-5">
                                        <input name="income_item_19" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                        Street Name
                                    </label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <input name="income_item_20" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                        Surburb
                                    </label>
                                    <div class="col-md-6 col-sm-8 col-xs-12">
                                        <input name="income_item_21" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="row">
                                            <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                                State
                                            </label>
                                            <div class="col-md-10 col-sm-8 col-xs-12">
                                                <input name="income_item_22" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                        Postcode
                                    </label>
                                    <div class="col-md-4 col-sm-8 col-xs-12">
                                        <input name="income_item_23" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="row">
                                            <label class="col-md-5 col-sm-6 col-xs-12 col-form-label fs-6 text-center">
                                                Country (if not AUS)
                                            </label>
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <input name="income_item_24" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                        Phone
                                    </label>
                                    <div class="col-md-4 col-sm-8 col-xs-12">
                                        <input name="income_item_25" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="row">
                                            <label class="col-md-5 col-sm-6 col-xs-12 col-form-label fs-6 text-center">
                                                Mobile
                                            </label>
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <input name="income_item_26" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                        Email
                                    </label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <input name="income_item_27" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15">
                                <div class="row">
                                    <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                        Customer Number
                                    </label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <input name="income_item_28" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-t-20 p-b-20 bg-danger w-full txt-white p-l-30 fw-bold" style="margin: 25px -30px 0px -30px;">
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <h5 class="txt-white"><b>Step 2</b> Term deposit set up instruction</h5>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <h5 class="txt-white">Bank account you will use to make payment</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 m-t-15">
                            <div class="row m-t-25">
                                <label class="col- md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                    Investment amount
                                </label>
                                <div class="col-md-4 col-sm-8 col-xs-12 d-flex">
                                    <span style="padding: 3px; font-size: 20px;">$</span>
                                    <input name="income_item_29" type="text" class="form-control" style="width: 98%;">
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="row">
                                        <label class="col-md-5 col-sm-6 col-xs-12 col-form-label fs-6 text-center">
                                            Asset ISIN
                                        </label>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                            <input name="income_item_30" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                    Source of Funds
                                </label>
                                <div class="col-md-10 col-xs-12">
                                    <div class="checkbox checkbox-dark">
                                        <input name="income_item_31" id="inline-1" type="checkbox">
                                        <label for="inline-1">Transfer from transaction account</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                </label>
                                <div class="col-md-4 col-sm-12">
                                    <div class="checkbox checkbox-dark">
                                        <input name="income_item_32" id="inline-1" type="checkbox">
                                        <label for="inline-1">Transfer from savings account</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="row">
                                        <label class="col-md-5 col-sm-6 col-xs-12 col-form-label fs-6 text-center">
                                            (Bank Account Number)
                                        </label>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                            <input name="income_item_33" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                    Investment term
                                </label>
                                <div class="col-md-4 col-sm-8 col-xs-12">
                                    <input name="income_item_34" type="text" class="form-control">
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="row">
                                        <label class="col-md-5 col-sm-6 col-xs-12 col-form-label fs-6 text-center">
                                            (Bank Account Number)
                                        </label>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                            <input name="income_item_35" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <label class="col-md-12 col-form-label fs-6">
                                    If investment term is 12 months or longer, please select the frequency of interest payments:
                                </label>
                                <div class="col-md-12  m-checkbox-inline">
                                    <label class="fs-6"><input name="income_item_36" class="checkbox_animated" value="1" type="radio" required>
                                        Mr
                                    </label>
                                    <label class="fs-6"><input name="income_item_36" class="checkbox_animated" value="2" type="radio" required>
                                        Mrs
                                    </label>
                                    <label class="fs-6"><input name="income_item_36" class="checkbox_animated" value="3" type="radio" required>
                                        Ms
                                    </label>
                                    <label class="fs-6"><input name="income_item_36" class="checkbox_animated" value="4" type="radio" required>
                                        Miss
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="p-t-20 p-b-20 bg-danger w-full txt-white p-l-30 fw-bold" style="margin: 25px -30px 0px -30px;">
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <h5 class="txt-white"><b>Step 3</b> Term deposit maturity instructions</h5>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <h5 class="txt-white">Bank account you will use to receive interest payments</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 m-t-15">
                            <div class="row m-t-20">
                                <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                    1. Principal
                                </label>
                                <div class="col-md-7 col-sm-12">
                                    <div class="checkbox checkbox-dark">
                                        <input name="income_item_37" id="inline-1" type="checkbox">
                                        <label for="inline-1">I would like to receive my principal investment sum in the following bank account</label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <input name="income_item_38" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 m-t-15">
                            <div class="row m-t-20">
                                <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                                    2. Interest
                                </label>
                                <div class="col-md-7 col-sm-12">
                                    <div class="checkbox checkbox-dark">
                                        <input name="income_item_39" id="inline-1" type="checkbox">
                                        <label for="inline-1">I would like to receive my interest payments in the following bank account</label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <input name="income_item_40" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="p-t-20 p-b-20 bg-danger w-full txt-white p-l-30 fw-bold" style="margin: 25px -30px 0px -30px;">
                            <h5 class="txt-white"><b>Step 4</b> Terms and conditions</h5>
                        </div>
                        <label class="col-md-12 col-form-label fs-6">
                            1. The amount deposited is to be invested for the fixed term stated above. The interest rate applicable will be the
                            interest rate offered by HSBC,at the time of receipt of the deposit.
                        </label>
                        <label class="col-md-12 col-form-label fs-6">
                            2. If the deposit is to be reinvested on maturity the interest rate applicable will be the rate offered by HSBC,at the
                            date of reinvestment and will be fixed for the term of the investment.
                        </label>
                        <label class="col-form-label fs-6">
                            3. Interest on this deposit will commence from the date the funds are invested
                        </label>
                        <label class="col-form-label fs-6">
                            4. In accepting a fixed term deposit you agree to invest those funds with HSBC, for the nominated term. The
                            acceptance of an early redemption request will be subject to a penalty interest adjustment, calculated as a
                            percentage on the actual term of the deposit, referenced to the original maturity date.
                        </label>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label fs-6">
                                    Name of customer
                                </label>
                                <input name="income_item_41" type="text" class="form-control">
                                <input name="income_item_42" type="text" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label fs-6">
                                    Name of joint customer
                                </label>
                                <input name="income_item_43" type="text" class="form-control">
                                <input name="income_item_44" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row m-t-25">
                            <label class="col-md-2 col-xs-12 col-form-label fs-6">
                                Date
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12 col-xs-12">
                                <div class="checkbox checkbox-dark">
                                    <input name="income_item_45" class="form-control" type="date">
                                </div>
                            </div>
                        </div>
                        <h5 class="p-t-10 p-b-10 w-full m-t-25 txt-white p-l-30 fw-bold" style="margin: 0 -30px; background:#ed5c6a;">Office Use Only</h5>
                        <div class="row m-t-25">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-md-4 col-xs-12 col-form-label fs-6">
                                        Date Loaded
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input name="income_item_46" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="row m-t-20">
                                    <label class="col-md-4 col-xs-12 col-form-label fs-6">
                                        Investment type
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input name="income_item_47" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-md-4 col-xs-12 col-form-label fs-6 text-center">
                                        Deposit no.
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input name="income_item_48" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="row m-t-20">
                                    <label class="col-md-4 col-xs-12 col-form-label fs-6 text-center">
                                        Loaded by
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input name="income_item_49" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center m-t-50">
                            <input class="btn btn-primary btn-outlined btn-lg" type="submit" value="Submit">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
</div>
<!-- Container-fluid Ends-->
@push('scripts')
<script src="{{asset('assets/js/prism/prism.min.js')}}"></script>
<script src="{{asset('assets/js/clipboard/clipboard.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/js/counter/counter-custom.js')}}"></script>
<script src="{{asset('assets/js/scrollable/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/scrollable/scrollable-custom.js')}}"></script>
<script src="{{asset('assets/js/dashboard/default.js')}}"></script>
<script src="{{asset('assets/js/notify/index.js')}}"></script>
<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>
@endpush
@endsection