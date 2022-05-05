@component('mail::message')

<strong style="font-size: 24px;">Application Form</strong>

<div style="zoom: 1.25;">
    <h2 class="p-t-20 p-b-20 bg-danger w-full txt-white p-l-30 fw-bold" style="margin: 0 -30px;">Step 1 Customer Details</h2>
    <div class="row">
        <div class="col-md-12 m-t-15">
            <div class="row">
                <label class="col-md-2  col-sm-4 col-xs-12 col-form-label fs-6">
                    Title
                </label>
                <div class="col-md-5  col-sm-8 col-xs-12  m-checkbox-inline">
                    <label class="fs-6">
                        @if($income_item_1 == "1")
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox" checked="">
                        @else
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox">
                        @endif
                        Mr
                    </label>
                    <label class="fs-6">
                        @if($income_item_1 == "2")
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox" checked="">
                        @else
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox">
                        @endif
                        Mrs
                    </label>
                    <label class="fs-6">
                        @if($income_item_1 == "3")
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox" checked="">
                        @else
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox">
                        @endif
                        Ms
                    </label>
                    <label class="fs-6">
                        @if($income_item_1 == "4")
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox" checked="">
                        @else
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox">
                        @endif
                        Miss
                    </label>
                </div>
                <div class="col-md-5 col-sm-12">
                    <div class="row">
                        <label class="col-sm-3 col-form-label fs-6">Date of Birth</label>
                        <div class="col-sm-9">
                            <input disabled="" style="margin-bottom:5px;" class="form-control" type="date" value="{{$income_item_2}}">
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
                    <input disabled="" style="margin-bottom:5px;" type="text" class="form-control" value="{{$income_item_3}}">
                </div>
            </div>
        </div>
        <div class="col-md-12 m-t-15">
            <div class="row">
                <label class="col-md-2 col-sm-4 col-form-label fs-6">
                    Given Name(2)
                </label>
                <div class="col-md-10 col-sm-8">
                    <input disabled="" style="margin-bottom:5px;" type="text" class="form-control" value="{{$income_item_4}}">
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
                    <input disabled="" style="margin-bottom:5px;" type="text" class="form-control" value="{{$income_item_5}}">
                </div>
            </div>
        </div>
        <div class="col-md-12 m-t-15">
            <div class="row">
                <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                    Street Name
                </label>
                <div class="col-md-10 col-sm-8 col-xs-12">
                    <input disabled="" style="margin-bottom:5px;" type="text" class="form-control" value="{{$income_item_6}}">
                </div>
            </div>
        </div>
        <div class="col-md-12 m-t-15">
            <div class="row">
                <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                    Surburb
                </label>
                <div class="col-md-6 col-sm-8 col-xs-12">
                    <input disabled="" style="margin-bottom:5px;" type="text" class="form-control" value="{{$income_item_7}}">
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="row">
                        <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                            State
                        </label>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <input disabled="" style="margin-bottom:5px;" type="text" class="form-control" value="{{$income_item_8}}">
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
                    <input disabled="" style="margin-bottom:5px;" type="text" class="form-control" value="{{$income_item_9}}">
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <label class="col-md-5 col-sm-6 col-xs-12 col-form-label fs-6 text-center">
                            Country (if not AUS)
                        </label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <input disabled="" style="margin-bottom:5px;" type="text" class="form-control" value="{{$income_item_10}}">
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
                    <input disabled="" style="margin-bottom:5px;" value="{{$income_item_11}}" type="text" class="form-control">
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <label class="col-md-5 col-sm-6 col-xs-12 col-form-label fs-6 text-center">
                            Mobile
                        </label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <input disabled="" style="margin-bottom:5px;" value="{{$income_item_12}}" type="text" class="form-control">
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
                    <input disabled="" style="margin-bottom:5px;" value="{{$income_item_13}}" type="text" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-12 m-t-15">
            <div class="row">
                <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                    Customer Number
                </label>
                <div class="col-md-10 col-sm-8 col-xs-12">
                    <input disabled="" style="margin-bottom:5px;" value="{{$income_item_14}}" type="text" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <h2 class="p-t-10 p-b-10 w-full m-t-25 txt-white p-l-30 fw-bold" style="margin-top: 15px;">Joint customer details (if applicable)</h2>
    <div class="row">
        <div class="col-md-12 m-t-25">
            <div class="row">
                <label class="col-md-2  col-sm-4 col-xs-12 fs-6">
                    Title
                </label>
                <div class="col-md-5  col-sm-8 col-xs-12  m-checkbox-inline">
                    <label class="fs-6">
                        @if($income_item_15 == "1")
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox" checked="">
                        @else
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox">
                        @endif
                        Mr
                    </label>
                    <label class="fs-6">
                        @if($income_item_15 == "2")
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox" checked="">
                        @else
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox">
                        @endif
                        Mrs
                    </label>
                    <label class="fs-6">
                        @if($income_item_15 == "3")
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox" checked="">
                        @else
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox">
                        @endif
                        Ms
                    </label>
                    <label class="fs-6">
                        @if($income_item_15 == "4")
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox" checked="">
                        @else
                        <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox">
                        @endif
                        Miss
                    </label>
                </div>
                <div class="col-md-5 col-sm-12">
                    <div class="row">
                        <label class="col-sm-3 col-form-label fs-6">Date of Birth</label>
                        <div class="col-sm-9">
                            <input disabled="" style="margin-bottom:5px;" value="{{$income_item_16}}" class="form-control digits" type="date">
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
                    <input disabled="" style="margin-bottom:5px;" value="{{$income_item_17}}" type="text" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-12 m-t-15">
            <div class="row">
                <label class="col-md-2 col-sm-4 col-form-label fs-6">
                    Given Name(2)
                </label>
                <div class="col-md-10 col-sm-8">
                    <input disabled="" style="margin-bottom:5px;" value="{{$income_item_18}}" type="text" class="form-control">
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
                    <input disabled="" style="margin-bottom:5px;" value="{{$income_item_19}}" type="text" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-12 m-t-15">
            <div class="row">
                <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                    Street Name
                </label>
                <div class="col-md-10 col-sm-8 col-xs-12">
                    <input disabled="" style="margin-bottom:5px;" value="{{$income_item_20}}" type="text" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-12 m-t-15">
            <div class="row">
                <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                    Surburb
                </label>
                <div class="col-md-6 col-sm-8 col-xs-12">
                    <input disabled="" style="margin-bottom:5px;" value="{{$income_item_21}}" type="text" class="form-control">
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="row">
                        <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                            State
                        </label>
                        <div class="col-md-10 col-sm-8 col-xs-12">
                            <input disabled="" style="margin-bottom:5px;" value="{{$income_item_22}}" type="text" class="form-control">
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
                    <input disabled="" style="margin-bottom:5px;" value="{{$income_item_23}}" type="text" class="form-control">
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <label class="col-md-5 col-sm-6 col-xs-12 col-form-label fs-6 text-center">
                            Country (if not AUS)
                        </label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <input disabled="" style="margin-bottom:5px;" value="{{$income_item_24}}" type="text" class="form-control">
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
                    <input disabled="" style="margin-bottom:5px;" value="{{$income_item_25}}" type="text" class="form-control">
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <label class="col-md-5 col-sm-6 col-xs-12 col-form-label fs-6 text-center">
                            Mobile
                        </label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <input disabled="" style="margin-bottom:5px;" value="{{$income_item_26}}" type="text" class="form-control">
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
                    <input disabled="" style="margin-bottom:5px;" value="{{$income_item_27}}" type="text" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-12 m-t-15">
            <div class="row">
                <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                    Customer Number
                </label>
                <div class="col-md-10 col-sm-8 col-xs-12">
                    <input disabled="" style="margin-bottom:5px;" value="{{$income_item_28}}" type="text" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="p-t-20 p-b-20 bg-danger w-full txt-white p-l-30 fw-bold" style="margin: 25px -30px 0px -30px;">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <h2 class="txt-white" style="margin-top: 15px;"><b>Step 2</b> Term deposit set up instruction</h2>
            </div>
            <div class="col-md-6 col-xs-12">
                <h2 class="txt-white">Bank account you will use to make payment</h2>
            </div>
        </div>
    </div>
    <div class="col-md-12 m-t-15">
        <div class="row m-t-25">
            <label class="col- md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                Investment amount
            </label>
            <div class="col-md-4 col-sm-8 col-xs-12 d-flex">
                <span>$</span>
                <input disabled="" style="margin-bottom:5px;" value="{{$income_item_29}}" type="text" class="form-control" style="width: 90%;">
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <label class="col-md-5 col-sm-6 col-xs-12 col-form-label fs-6 text-center">
                        Asset ISIN
                    </label>
                    <div class="col-md-7 col-sm-6 col-xs-12">
                        <input disabled="" style="margin-bottom:5px;" value="{{$income_item_30}}" type="text" class="form-control">
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
                    @if($income_item_31 == "1")
                    <input disabled="" style="margin-bottom:5px;" value="{{$income_item_31}}" type="checkbox" checked="">
                    @else
                    <input disabled="" style="margin-bottom:5px;" value="{{$income_item_31}}" type="checkbox">
                    @endif
                    <label for="inline-1">Transfer from transaction account</label>
                </div>
            </div>
        </div>
        <div class="row m-t-20">
            <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
            </label>
            <div class="col-md-4 col-sm-12">
                <div class="checkbox checkbox-dark">
                    @if($income_item_31 == "2")
                    <input disabled="" style="margin-bottom:5px;" type="checkbox" checked="">
                    @else
                    <input disabled="" style="margin-bottom:5px;" type="checkbox">
                    @endif
                    <label for="inline-1">Transfer from savings account</label>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <label class="col-md-5 col-sm-6 col-xs-12 col-form-label fs-6 text-center">
                        (Bank Account Number)
                    </label>
                    <div class="col-md-7 col-sm-6 col-xs-12">
                        <input disabled="" style="margin-bottom:5px;" value="{{$income_item_33}}" type="text" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-t-20">
            <label class="col-md-2 col-sm-4 col-xs-12 col-form-label fs-6">
                Investment term
            </label>
            <div class="col-md-4 col-sm-8 col-xs-12">
                <input disabled="" style="margin-bottom:5px;" value="{{$income_item_34}}" type="text" class="form-control">
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <label class="col-md-5 col-sm-6 col-xs-12 col-form-label fs-6 text-center">
                        (Bank Account Number)
                    </label>
                    <div class="col-md-7 col-sm-6 col-xs-12">
                        <input disabled="" style="margin-bottom:5px;" value="{{$income_item_35}}" type="text" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-t-20">
            <label class="col-md-12 col-form-label fs-6">
                If investment term is 12 months or longer, please select the frequency of interest payments:
            </label>
            <div class="col-md-12  m-checkbox-inline">
                <label class="fs-6">
                    @if($income_item_36 == "1")
                    <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox" checked="">
                    @else
                    <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox">
                    @endif
                    Mr
                </label>
                <label class="fs-6">
                    @if($income_item_36 == "2")
                    <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox" checked="">
                    @else
                    <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox">
                    @endif
                    Mrs
                </label>
                <label class="fs-6">
                    @if($income_item_36 == "3")
                    <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox" checked="">
                    @else
                    <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox">
                    @endif
                    Ms
                </label>
                <label class="fs-6">
                    @if($income_item_36 == "4")
                    <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox" checked="">
                    @else
                    <input disabled="" style="margin-bottom:5px;" class="checkbox_animated" type="checkbox">
                    @endif
                    Miss
                </label>
            </div>
        </div>
    </div>
    <div class="p-t-20 p-b-20 bg-danger w-full txt-white p-l-30 fw-bold" style="margin: 25px -30px 0px -30px;">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <h2 class="txt-white" style="margin-top: 15px;"><b>Step 3</b> Term deposit maturity instructions</h2>
            </div>
            <div class="col-md-6 col-xs-12">
                <h2 class="txt-white">Bank account you will use to receive interest payments</h2>
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
                    @if($income_item_37 == "1")
                    <input disabled="" style="margin-bottom:5px;" type="checkbox" checked="">
                    @else
                    <input disabled="" style="margin-bottom:5px;" type="checkbox">
                    @endif
                    <label for="inline-1">I would like to receive my principal investment sum in the following bank account</label>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <input disabled="" style="margin-bottom:5px;" value="{{$income_item_38}}" type="text" class="form-control">
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
                    @if($income_item_37 == "2")
                    <input disabled="" style="margin-bottom:5px;" type="checkbox" checked="">
                    @else
                    <input disabled="" style="margin-bottom:5px;" type="checkbox">
                    @endif
                    <label for="inline-1">I would like to receive my interest payments in the following bank account</label>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <input disabled="" style="margin-bottom:5px;" value="{{$income_item_40}}" type="text" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label class="col-form-label fs-6" style="display: block;">
                Name of customer
            </label>
            <input disabled="" style="margin-bottom:5px;" value="{{$income_item_41}}" type="text" class="form-control">
            <input disabled="" style="margin-bottom:5px;" value="{{$income_item_42}}" type="text" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="col-form-label fs-6" style="display: block;">
                Name of joint customer
            </label>
            <input disabled="" style="margin-bottom:5px;" value="{{$income_item_43}}" type="text" class="form-control">
            <input disabled="" style="margin-bottom:5px;" value="{{$income_item_44}}" type="text" class="form-control">
        </div>
    </div>
    <div class="row m-t-25">
        <label class="col-md-2 col-xs-12 col-form-label fs-6">
            Date
        </label>
        <div class="col-md-4 col-sm-6 col-xs-12 col-xs-12">
            <div class="checkbox checkbox-dark">
                <input disabled="" style="margin-bottom:5px;" value="{{$income_item_45}}" class="form-control" type="date">
            </div>
        </div>
    </div>
</div>

@endcomponent