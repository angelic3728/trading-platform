@component('mail::message')

<strong>Account Opening Form:</strong>

<div class="row">
    <p class="fw-bold m-b-5">Reason For Inversting:</p>
    <div class="col">
        <label class="d-block">
            @if(acc_item_1 == "1")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            General
        </label>
        <label class="d-block">
            @if(acc_item_1 == "2")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            Education
        </label>
        <label class="d-block">
            @if(acc_item_1 == "3")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            Retirement
        </label>
        <label class="d-block">
            @if(acc_item_1 == "4")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            Specific Event(Please specify)
        </label>
        <input name="acc_item_2" class="form-control" style="max-width: 300px;" type="text" value="{{acc_item_2}}">
    </div>
    <p class="fw-bold m-t-20 m-b-5">Type of Account:</p>
    <div class="col">
        <label class="d-block">
            @if(acc_item_3 == "1")
            <input class="checkbox_animated" type="checkbox" checked="">
            @else
            <input class="checkbox_animated" type="checkbox">
            @endif
            Execution
        </label>
        <label class="d-block">
            @if(acc_item_3 == "2")
            <input type="checkbox" checked="">
            @else
            <input type="checkbox">
            @endif
            Advisory
        </label>
        <label class="d-block">
            @if(acc_item_3 == "3")
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
            <input name="acc_item_4" value="1" class="checkbox_animated" type="checkbox"> Yes
        </label>
        <label class="d-block">
            <input name="acc_item_4" value="2" class="checkbox_animated" type="checkbox"> No
        </label>
    </div>
    <p class="fw-bold m-t-20 m-b-5">Are you making any concurrent applications to other investment companies?</p>
    <div class="col">
        <label class="d-block">
            <input name="acc_item_5" value="1" class="checkbox_animated" type="checkbox"> Yes
        </label>
        <label class="d-block">
            <input name="acc_item_5" value="2" class="checkbox_animated" type="checkbox"> No
        </label>
    </div>
    <p class="fw-bold m-t-20 m-b-5">If 'Yes' to either question please give details.</p>
    <div class="col">
        <p class="m-b-0 m-t-5">Company Name/s:</p>
        <input name="acc_item_6" value="1" class="form-control" type="text" >
        <p class="m-b-0 m-t-5">Type of Plan/s:</p>
        <input name="acc_item_6" value="2" class="form-control" type="text" >
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <p class="m-b-0 m-t-5">Annual Premium Account/s:</p>
                <input name="acc_item_7" class="form-control" type="text" >
            </div>
            <div class="col-md-6 col-sm-12">
                <p class="m-b-0 m-t-5">Plan Term/s:</p>
                <input name="acc_item_8" class="form-control" type="text" >
            </div>
        </div>
    </div>
    <p class="fw-bold m-t-20 m-b-5">Please indicate which type of account you require?</p>
    <div class="col">
        <label class="d-block">
            <input name="acc_item_9" value="1" class="checkbox_animated" type="checkbox"> Single
        </label>
        <label class="d-block">
            <input name="acc_item_9" value="2" class="checkbox_animated" type="checkbox"> Joint
        </label>
        <label class="d-block">
            <input name="acc_item_9" value="3" class="checkbox_animated" type="checkbox"> Family
        </label>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p class="fw-bold m-b-5">First Applicant</p>
            <p class="fw-bold m-b-5">Are you a US* Tax Payer?</p>
            <label class="d-block">
                <input name="acc_item_10" value="1" class="checkbox_animated" type="checkbox"> Yes
            </label>
            <label class="d-block">
                <input name="acc_item_10" value="2" class="checkbox_animated" type="checkbox"> No
            </label>
            <p class="fw-bold m-t-10 m-b-5">Are you a US* Citizen?</p>
            <label class="d-block">
                <input name="acc_item_11" value="1" class="checkbox_animated" type="checkbox"> Yes
            </label>
            <label class="d-block">
                <input name="acc_item_11" value="2" class="checkbox_animated" type="checkbox"> No
            </label>
            <p class="fw-bold m-t-10 m-b-5">Will you be including a US* address or contact details in this application?</p>
            <label class="d-block">
                <input name="acc_item_12" value="1" class="checkbox_animated" type="checkbox"> Yes
            </label>
            <label class="d-block">
                <input name="acc_item_12" value="2" class="checkbox_animated" type="checkbox"> No
            </label>
            <p class="fw-bold m-t-20 m-b-5">Where do you reside for tax purposes?</p>
            <p class="fw-bold m-t-10 m-b-5">Country/Countries of Tax Residence?</p>
            <input name="acc_item_13" class="form-control" type="text" >
            <p class="fw-bold m-t-10 m-b-5">Tax Reference Number/s:</p>
            <input name="acc_item_14" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">First Applicant:</p>
            <label class="d-block">
                <input name="acc_item_15" value="1" class="checkbox_animated" type="checkbox"> Mr
            </label>
            <label class="d-block">
                <input name="acc_item_15" value="2" class="checkbox_animated" type="checkbox"> Mrs
            </label>
            <label class="d-block">
                <input name="acc_item_15" value="3" class="checkbox_animated" type="checkbox"> Miss
            </label>
            <label class="d-block">
                <input name="acc_item_15" value="4" class="checkbox_animated" type="checkbox"> Ms
            </label>
            <label class="d-block">
                <input name="acc_item_15" value="5" class="checkbox_animated" type="checkbox"> Other (Please specify)
            </label>
            <input name="acc_item_16" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Surname:</p>
            <input name="acc_item_17" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">First name:</p>
            <input name="acc_item_18" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Previous names (if applicable):</p>
            <input name="acc_item_19" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Date of birth (DD/MM/YYYY):</p>
            <input name="acc_item_20" class="form-control digits" type="date" value="2000-01-01">
            <p class="fw-bold m-t-20 m-b-5">Gender</p>
            <label class="d-block">
                <input name="acc_item_21" value="1" class="checkbox_animated" type="checkbox"> Male
            </label>
            <label class="d-block">
                <input name="acc_item_21" value="2" class="checkbox_animated" type="checkbox"> Female
            </label>
            <p class="fw-bold m-t-20 m-b-5">Marital status:</p>
            <input name="acc_item_23" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Residential address:</p>
            <input name="acc_item_24" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Correspondence address (if different):</p>
            <input name="acc_item_25" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Email:</p>
            <input name="acc_item_26" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Telephone number:</p>
            <input name="acc_item_27" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Mobile number:</p>
            <input name="acc_item_28" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Primary nationality:</p>
            <input name="acc_item_29" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Do you hold dual nationality?</p>
            <label class="d-block">
                <input name="acc_item_30" value="1" class="checkbox_animated" type="checkbox"> Yes
            </label>
            <label class="d-block">
                <input name="acc_item_30" value="2" class="checkbox_animated" type="checkbox"> No
            </label>
            <p class="fw-bold m-t-20 m-b-5">Second nationality/citizenship:</p>
            <input name="acc_item_31" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Passport/ID number of second nationality (if applicable):</p>
            <input name="acc_item_32" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Are you self employed?</p>
            <label class="d-block">
                <input name="acc_item_33" value="1" class="checkbox_animated" type="checkbox"> Yes
            </label>
            <label class="d-block">
                <input name="acc_item_33" value="2" class="checkbox_animated" type="checkbox"> No
            </label>
            <p class="fw-bold m-t-20 m-b-5">Name of employer:</p>
            <input name="acc_item_35" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Job title:</p>
            <input name="acc_item_36" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Industry sector:</p>
            <input name="acc_item_37" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Length of current employment:</p>
            <input name="acc_item_38" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">If retired please state former occupation and employer:</p>
            <textarea name="acc_item_39" class="form-control" rows="3" cols="3" ></textarea>
        </div>
        <div class="col-md-6">
            <p class="fw-bold m-b-5">Second Applicant</p>
            <p class="fw-bold m-b-5">Are you a US* Tax Payer?</p>
            <label class="d-block">
                <input name="acc_item_40" value="1" class="checkbox_animated" type="checkbox"> Yes
            </label>
            <label class="d-block">
                <input name="acc_item_40" value="2" class="checkbox_animated" type="checkbox"> No
            </label>
            <p class="fw-bold m-t-10 m-b-5">Are you a US* Citizen?</p>
            <label class="d-block">
                <input name="acc_item_42" value="1" class="checkbox_animated" type="checkbox"> Yes
            </label>
            <label class="d-block">
                <input name="acc_item_42" value="2" class="checkbox_animated" type="checkbox"> No
            </label>
            <p class="fw-bold m-t-10 m-b-5">Will you be including a US* address or contact details in this application?</p>
            <label class="d-block">
                <input name="acc_item_43" value="1" class="checkbox_animated" type="checkbox"> Yes
            </label>
            <label class="d-block">
                <input name="acc_item_43" value="2" class="checkbox_animated" type="checkbox"> No
            </label>
            <p class="fw-bold m-t-20 m-b-5">Where do you reside for tax purposes?</p>
            <p class="fw-bold m-t-10 m-b-5">Country/Countries of Tax Residence?</p>
            <input name="acc_item_44" class="form-control" type="text" >
            <p class="fw-bold m-t-10 m-b-5">Tax Reference Number/s:</p>
            <input name="acc_item_45" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Second Applicant:</p>
            <label class="d-block">
                <input name="acc_item_46" value="1" class="checkbox_animated" type="checkbox"> Mr
            </label>
            <label class="d-block">
                <input name="acc_item_46" value="2" class="checkbox_animated" type="checkbox"> Mrs
            </label>
            <label class="d-block">
                <input name="acc_item_46" value="3" class="checkbox_animated" type="checkbox"> Miss
            </label>
            <label class="d-block">
                <input name="acc_item_46" value="4" class="checkbox_animated" type="checkbox"> Ms
            </label>
            <label class="d-block">
                <input name="acc_item_46" value="5" class="checkbox_animated" type="checkbox"> Other (Please specify)
            </label>
            <input name="acc_item_47" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Surname:</p>
            <input name="acc_item_48" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">First name:</p>
            <input name="acc_item_49" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Previous names (if applicable):</p>
            <input name="acc_item_50" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Date of birth (DD/MM/YYYY):</p>
            <input name="acc_item_51" class="form-control digits" type="date" value="2000-01-01">
            <p class="fw-bold m-t-20 m-b-5">Gender</p>
            <label class="d-block">
                <input name="acc_item_52" value="1" class="checkbox_animated" type="checkbox"> Male
            </label>
            <label class="d-block">
                <input name="acc_item_52" value="2" class="checkbox_animated" type="checkbox"> Female
            </label>
            <p class="fw-bold m-t-20 m-b-5">Marital status:</p>
            <input name="acc_item_53" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Residential address:</p>
            <input name="acc_item_54" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Correspondence address (if different):</p>
            <input name="acc_item_55" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Email:</p>
            <input name="acc_item_56" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Telephone number:</p>
            <input name="acc_item_57" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Mobile number:</p>
            <input name="acc_item_58" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Primary nationality:</p>
            <input name="acc_item_59" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Do you hold dual nationality?</p>
            <label class="d-block">
                <input name="acc_item_60" value="1" class="checkbox_animated" type="checkbox"> Yes
            </label>
            <label class="d-block">
                <input name="acc_item_60" value="2" class="checkbox_animated" type="checkbox"> No
            </label>
            <p class="fw-bold m-t-20 m-b-5">Second nationality/citizenship:</p>
            <input name="acc_item_61" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Passport/ID number of second nationality (if applicable):</p>
            <input name="acc_item_62" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Are you self employed?</p>
            <label class="d-block">
                <input name="acc_item_63" value="1" class="checkbox_animated" type="checkbox"> Yes
            </label>
            <label class="d-block">
                <input name="acc_item_63" value="2" class="checkbox_animated" type="checkbox"> No
            </label>
            <p class="fw-bold m-t-20 m-b-5">Name of employer:</p>
            <input name="acc_item_64" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Job title:</p>
            <input name="acc_item_65" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Industry sector:</p>
            <input name="acc_item_66" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">Length of current employment:</p>
            <input name="acc_item_67" class="form-control" type="text" >
            <p class="fw-bold m-t-20 m-b-5">If retired please state former occupation and employer:</p>
            <textarea name="acc_item_68" class="form-control" rows="3" cols="3" ></textarea>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="m-b-5 m-t-20 fw-bold">Please choose at least 2 files. each file size must be less than 10M.</p>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <p class="fw-bold m-t-5 m-b-5">File 1</p>
                <input name="acc_item_69" class="form-control" type="file">
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <p class="fw-bold m-t-5 m-b-5">File 2</p>
                <input name="acc_item_70" class="form-control" type="file">
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <p class="fw-bold m-t-5 m-b-5">File 3</p>
                <input name="acc_item_71" class="form-control" type="file">
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <p class="fw-bold m-t-5 m-b-5">File 4</p>
                <input name="acc_item_72" class="form-control" type="file">
            </div>
        </div>
        <p class="fw-bold m-t-20 m-b-5">Please state the relationship between the account applicants:</p>
        <textarea name="acc_item_73" class="form-control" rows="5" cols="5" ></textarea>
        <p class="m-t-30">Faber Langdale is a business name of Faber Langdale Group, Faber Langdale is licensed by the Securities and Exchange Commission, National Association of Securities Dealers and the Financial Conduct Authority in the UK. Faber Langdale is a corporation providing investment products. Faber Langdale is authorised and regulated by the Securities and Exchange Commission with Reference number: SEC CIK #0001302604; and we adhere to strict regulatory requirement set out by the National Association of Securities Dealers. Registered office: Faber Langdale, 185 Hudson St, Floors 6 - 8, New York, NY 10013. Email: info@faberlangdale.com.</p>
        <div class="d-flex justify-content-center m-t-50">
            <input class="btn btn-primary btn-outlined" type="submit" value="Submit">
        </div>
    </div>
</div>

@endcomponent
@endcomponent