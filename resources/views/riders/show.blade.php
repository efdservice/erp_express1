<div class="row m-1 border">
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Name</b><br/> {{@$rider->name}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Rider ID</b><br/> {{@$rider->rider_id}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Contact</b><br/> {{@$rider->personal_contact}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Rider ID</b><br/> {{@$rider->rider_id}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Vendor</b><br/> {{@$rider->vendor->name}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Company Contact</b><br/> {{@$rider->company_contact}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Nationality</b><br/> {{@$rider->nationality}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Personal Email ID</b><br/> {{@$rider->personal_email}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Email ID</b><br/> {{@$rider->email}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Visa Sponsor</b><br/> {{@$rider->visa_sponsor}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Occupation On Visa</b><br/> {{@$rider->visa_occupation}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Visa Status</b><br/> {{@$rider->visa_status}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>NF DID</b><br/> {{@$rider->NFDID}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>CDM Deposit ID</b><br/> {{@$rider->cdm_deposit_id}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Mashreq ID</b><br/> {{@$rider->mashreq_id}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Date of Joining</b><br/> {{@$rider->doj}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Project</b><br/> {{@$rider->project->name}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>DEPT</b><br/> {{@$rider->DEPT}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Ethnicity</b><br/> {{@$rider->ethnicity}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>DOB</b><br/> {{@$rider->dob}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Branded Plate Number</b><br/> {{@$rider->branded_plate_no}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Fleet Supervisor</b><br/> {{@$rider->fleet_supervisor}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Passport Handover</b><br/> {{@$rider->passport_handover}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Status</b><br/> {{App\Helpers\CommonHelper::RiderStatus(@$rider->status)}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Emirate (Hub)</b><br/> {{@$rider->emirate_hub}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Emirate ID</b><br/> {{@$rider->emirate_id}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Licence No</b><br/> {{@$rider->license_no}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>Passport</b><br/> {{@$rider->passport}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>NOON No.</b><br/> {{@$rider->noon_no}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>WPS</b><br/> {{@$rider->wps}}
    </div>
    <div class="col-md-4 border-right border-bottom" style="height: 45px;">
        <b>C3 Card</b><br/> {{@$rider->c3_card}}
    </div>
    <div class="col-md-12">
        <b>Other Details</b><br/> {{@$rider->other_details}}
    </div>

</div>
