@component('mail::message')

<strong>Account Opening Form:</strong>

<div class="row">
    <p class="fw-bold m-b-5">Reason For Inversting:</p>
    <div class="col">
        <label class="d-block">
            @if($acc_item_1 == "1")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            General
        </label>
        <label class="d-block">
            @if($acc_item_1 == "2")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            Education
        </label>
        <label class="d-block">
            @if($acc_item_1 == "3")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            Retirement
        </label>
        <label class="d-block">
            @if($acc_item_1 == "4")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            Specific Event(Please specify)
        </label>
        <input name="$acc_item_2" class="form-control" style="max-width: 300px;" type="text" value="{{$acc_item_2}}">
    </div>
    <p class="fw-bold m-t-20 m-b-5">Type of Account:</p>
    <div class="col">
        <label class="d-block">
            @if($acc_item_3 == "1")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            Execution
        </label>
        <label class="d-block">
            @if($acc_item_3 == "2")
            <input type="checkbox" checked="">
            @else
            <input type="checkbox">
            @endif
            Advisory
        </label>
        <label class="d-block">
            @if($acc_item_3 == "3")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            Discretionary
        </label>
    </div>
    <p class="fw-bold m-t-20 m-b-5">Have you surrendered a similar investment product in the last 12 months?</p>
    <div class="col">
        <label class="d-block">
            @if($acc_item_4 == "1")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            Yes
        </label>
        <label class="d-block">
            @if($acc_item_4 == "2")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            No
        </label>
    </div>
    <p class="fw-bold m-t-20 m-b-5">Are you making any concurrent applications to other investment companies?</p>
    <div class="col">
        <label class="d-block">
            @if($acc_item_5 == "1")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            Yes
        </label>
        <label class="d-block">
            @if($acc_item_5 == "2")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            No
        </label>
    </div>
    <p class="fw-bold m-t-20 m-b-5">If 'Yes' to either question please give details.</p>
    <div class="col">
        <p class="m-b-0 m-t-5">Company Name/s:</p>
        <input type="text" value="{{$acc_item_6}}">
        <p class="m-b-0 m-t-5">Type of Plan/s:</p>
        <input type="text" value="{{$acc_item_22}}">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <p class="m-b-0 m-t-5">Annual Premium Account/s:</p>
                <input type="text" value="{{$acc_item_7}}">
            </div>
            <div class="col-md-6 col-sm-12">
                <p class="m-b-0 m-t-5">Plan Term/s:</p>
                <input type="text" value="{{$acc_item_8}}">
            </div>
        </div>
    </div>
    <p class="fw-bold m-t-20 m-b-5">Please indicate which type of account you require?</p>
    <div class="col">
        <label class="d-block">
            @if($acc_item_9 == "1")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            Single
        </label>
        <label class="d-block">
            @if($acc_item_9 == "2")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            Joint
        </label>
        <label class="d-block">
            @if($acc_item_9 == "3")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            Family
        </label>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p class="fw-bold m-b-5">First Applicant</p>
            <p class="fw-bold m-b-5">Are you a US* Tax Payer?</p>
            <label class="d-block">
                @if($acc_item_10 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Yes
            </label>
            <label class="d-block">
                @if($acc_item_10 == "2")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                No
            </label>
            <p class="fw-bold m-t-10 m-b-5">Are you a US* Citizen?</p>
            <label class="d-block">
                @if($acc_item_11 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Yes
            </label>
            <label class="d-block">
                @if($acc_item_11 == "2")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                No
            </label>
            <p class="fw-bold m-t-10 m-b-5">Will you be including a US* address or contact details in this application?</p>
            <label class="d-block">
                @if($acc_item_12 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Yes
            </label>
            <label class="d-block">
                @if($acc_item_12 == "2")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                No
            </label>
            <p class="fw-bold m-t-20 m-b-5">Where do you reside for tax purposes?</p>
            <p class="fw-bold m-t-10 m-b-5">Country/Countries of Tax Residence?</p>
            <input type="text" value="{{$acc_item_13}}">
            <p class="fw-bold m-t-10 m-b-5">Tax Reference Number/s:</p>
            <input type="text" value="{{$acc_item_14}}">
            <p class="fw-bold m-t-20 m-b-5">First Applicant:</p>
            <label class="d-block">
                @if($acc_item_15 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Mr
            </label>
            <label class="d-block">
                @if($acc_item_15 == "2")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Mrs
            </label>
            <label class="d-block">
                @if($acc_item_15 == "3")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Miss
            </label>
            <label class="d-block">
                @if($acc_item_15 == "4")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Ms
            </label>
            <label class="d-block">
                @if($acc_item_15 == "5")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Other (Please specify)
            </label>
            <input type="text" value="{{$acc_item_16}}">
            <p class="fw-bold m-t-20 m-b-5">Surname:</p>
            <input type="text" value="{{$acc_item_17}}">
            <p class="fw-bold m-t-20 m-b-5">First name:</p>
            <input type="text" value="{{$acc_item_18}}">
            <p class="fw-bold m-t-20 m-b-5">Previous names (if applicable):</p>
            <input type="text" value="{{$acc_item_19}}">
            <p class="fw-bold m-t-20 m-b-5">Date of birth (DD/MM/YYYY):</p>
            <input type="date" value="{{$acc_item_20}}">
            <p class="fw-bold m-t-20 m-b-5">Gender</p>
            <label class="d-block">
                @if($acc_item_21 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Male
            </label>
            <label class="d-block">
                @if($acc_item_21 == "2")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Female
            </label>
            <p class="fw-bold m-t-20 m-b-5">Marital status:</p>
            <input type="text" value="{{$acc_item_23}}">
            <p class="fw-bold m-t-20 m-b-5">Residential address:</p>
            <input type="text" value="{{$acc_item_24}}">
            <p class="fw-bold m-t-20 m-b-5">Correspondence address (if different):</p>
            <input class="form-control" type="text" value="{{$acc_item_25}}">
            <p class="fw-bold m-t-20 m-b-5">Email:</p>
            <input type="text" value="{{$acc_item_26}}">
            <p class="fw-bold m-t-20 m-b-5">Telephone number:</p>
            <input type="text" value="{{$acc_item_27}}">
            <p class="fw-bold m-t-20 m-b-5">Mobile number:</p>
            <input type="text" value="{{$acc_item_28}}">
            <p class="fw-bold m-t-20 m-b-5">Primary nationality:</p>
            <input type="text" value="{{$acc_item_29}}">
            <p class="fw-bold m-t-20 m-b-5">Do you hold dual nationality?</p>
            <label class="d-block">
                @if($acc_item_30 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Yes
            </label>
            <label class="d-block">
                @if($acc_item_30 == "2")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                No
            </label>
            <p class="fw-bold m-t-20 m-b-5">Second nationality/citizenship:</p>
            <input type="text" value="{{$acc_item_31}}">
            <p class="fw-bold m-t-20 m-b-5">Passport/ID number of second nationality (if applicable):</p>
            <input type="text" value="{{$acc_item_32}}">
            <p class="fw-bold m-t-20 m-b-5">Are you self employed?</p>
            <label class="d-block">
                @if($acc_item_33 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Yes
            </label>
            <label class="d-block">
                @if($acc_item_33 == "2")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                No
            </label>
            <p class="fw-bold m-t-20 m-b-5">Name of employer:</p>
            <input type="text" value="{{$acc_item_35}}">
            <p class="fw-bold m-t-20 m-b-5">Job title:</p>
            <input type="text" value="{{$acc_item_36}}">
            <p class="fw-bold m-t-20 m-b-5">Industry sector:</p>
            <input type="text" value="{{$acc_item_37}}">
            <p class="fw-bold m-t-20 m-b-5">Length of current employment:</p>
            <input type="text" value="{{$acc_item_38}}">
            <p class="fw-bold m-t-20 m-b-5">If retired please state former occupation and employer:</p>
            <textarea value="{{$acc_item_39}}"></textarea>
        </div>
        <div class="col-md-6">
            <p class="fw-bold m-b-5">Second Applicant</p>
            <p class="fw-bold m-b-5">Are you a US* Tax Payer?</p>
            <label class="d-block">
                @if($acc_item_40 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Yes
            </label>
            <label class="d-block">
                @if($acc_item_40 == "2")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                No
            </label>
            <p class="fw-bold m-t-10 m-b-5">Are you a US* Citizen?</p>
            <label class="d-block">
                @if($acc_item_42 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Yes
            </label>
            <label class="d-block">
                @if($acc_item_42 == "2")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                No
            </label>
            <p class="fw-bold m-t-10 m-b-5">Will you be including a US* address or contact details in this application?</p>
            <label class="d-block">
                @if($acc_item_43 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Yes
            </label>
            <label class="d-block">
                @if($acc_item_43 == "2")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                No
            </label>
            <p class="fw-bold m-t-20 m-b-5">Where do you reside for tax purposes?</p>
            <p class="fw-bold m-t-10 m-b-5">Country/Countries of Tax Residence?</p>
            <input type="text" value="{{$acc_item_44}}">
            <p class="fw-bold m-t-10 m-b-5">Tax Reference Number/s:</p>
            <input type="text" value="{{$acc_item_45}}">
            <p class="fw-bold m-t-20 m-b-5">Second Applicant:</p>
            <label class="d-block">
                @if($acc_item_46 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Mr
            </label>
            <label class="d-block">
                @if($acc_item_46 == "2")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Mrs
            </label>
            <label class="d-block">
                @if($acc_item_46 == "3")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Miss
            </label>
            <label class="d-block">
                @if($acc_item_46 == "4")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Ms
            </label>
            <label class="d-block">
                @if($acc_item_46 == "5")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Other (Please specify)
            </label>
            <input type="text" value="{{$acc_item_47}}">
            <p class="fw-bold m-t-20 m-b-5">Surname:</p>
            <input type="text" value="{{$acc_item_48}}">
            <p class="fw-bold m-t-20 m-b-5">First name:</p>
            <input type="text" value="{{$acc_item_49}}">
            <p class="fw-bold m-t-20 m-b-5">Previous names (if applicable):</p>
            <input type="text" value="{{$acc_item_50}}">
            <p class="fw-bold m-t-20 m-b-5">Date of birth (DD/MM/YYYY):</p>
            <input type="date" value="{{$acc_item_51}}">
            <p class="fw-bold m-t-20 m-b-5">Gender</p>
            <label class="d-block">
                @if($acc_item_52 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Male
            </label>
            <label class="d-block">
                @if($acc_item_52 == "2")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Female
            </label>
            <p class="fw-bold m-t-20 m-b-5">Marital status:</p>
            <input type="text" value="{{$acc_item_53}}">
            <p class="fw-bold m-t-20 m-b-5">Residential address:</p>
            <input type="text" value="{{$acc_item_54}}">
            <p class="fw-bold m-t-20 m-b-5">Correspondence address (if different):</p>
            <input type="text" value="{{$acc_item_55}}">
            <p class="fw-bold m-t-20 m-b-5">Email:</p>
            <input type="text" value="{{$acc_item_56}}">
            <p class="fw-bold m-t-20 m-b-5">Telephone number:</p>
            <input type="text" value="{{$acc_item_57}}">
            <p class="fw-bold m-t-20 m-b-5">Mobile number:</p>
            <input type="text" value="{{$acc_item_58}}">
            <p class="fw-bold m-t-20 m-b-5">Primary nationality:</p>
            <input type="text" value="{{$acc_item_59}}">
            <p class="fw-bold m-t-20 m-b-5">Do you hold dual nationality?</p>
            <label class="d-block">
                @if($acc_item_60 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Yes
            </label>
            <label class="d-block">
                @if($acc_item_60 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                No
            </label>
            <p class="fw-bold m-t-20 m-b-5">Second nationality/citizenship:</p>
            <input type="text" value="{{$acc_item_61}}">
            <p class="fw-bold m-t-20 m-b-5">Passport/ID number of second nationality (if applicable):</p>
            <input type="text" value="{{$acc_item_62}}">
            <p class="fw-bold m-t-20 m-b-5">Are you self employed?</p>
            <label class="d-block">
                @if($acc_item_63 == "1")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                Yes
            </label>
            <label class="d-block">
                @if($acc_item_63 == "2")
                <input class="checkbox_animated" type="checkbox" checked="">
                @else
                <input class="checkbox_animated" type="checkbox">
                @endif
                No
            </label>
            <p class="fw-bold m-t-20 m-b-5">Name of employer:</p>
            <input type="text" value="{{$acc_item_64}}">
            <p class="fw-bold m-t-20 m-b-5">Job title:</p>
            <input type="text" value="{{$acc_item_65}}">
            <p class="fw-bold m-t-20 m-b-5">Industry sector:</p>
            <input type="text" value="{{$acc_item_66}}">
            <p class="fw-bold m-t-20 m-b-5">Length of current employment:</p>
            <input type="text" value="{{$acc_item_67}}">
            <p class="fw-bold m-t-20 m-b-5">If retired please state former occupation and employer:</p>
            <textarea value="{{$acc_item_68}}"></textarea>
        </div>
        <p class="fw-bold m-t-20 m-b-5">Please state the relationship between the account applicants:</p>
        <textarea value="{{$acc_item_73}}"></textarea>
        <p class="m-t-30">Faber Langdale is a business name of Faber Langdale Group, Faber Langdale is licensed by the Securities and Exchange Commission, National Association of Securities Dealers and the Financial Conduct Authority in the UK. Faber Langdale is a corporation providing investment products. Faber Langdale is authorised and regulated by the Securities and Exchange Commission with Reference number: SEC CIK #0001302604; and we adhere to strict regulatory requirement set out by the National Association of Securities Dealers. Registered office: Faber Langdale, 185 Hudson St, Floors 6 - 8, New York, NY 10013. Email: info@faberlangdale.com.</p>
        <div class="d-flex justify-content-center m-t-50">
            <input class="btn btn-primary btn-outlined" type="submit" value="Submit">
        </div>
    </div>
</div>

@endcomponent
