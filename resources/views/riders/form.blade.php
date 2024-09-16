@extends('layouts.app')
@section('title', 'Rider Profile')

@section('content')
<style>
.myform .required:after {
  content: " *";
    color: red;
    font-weight: 200;
}
</style>

<div class="content-wrapper" style="min-height: 1603.43px;">
    <section class="content-header">
       <div class="container-fluid">
          <div class="row mb-2">
             <div class="col-sm-6">
                <h1>User Profile</h1>
             </div>
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                   <li class="breadcrumb-item"><a href="{{url('rider')}}">Rider</a></li>
                   <li class="breadcrumb-item active">User Profile</li>
                </ol>
             </div>
          </div>
       </div>
    </section>

    <section class="content">
       <div class="container-fluid">
          <div class="row">
             <div class="col-md-3">
                <div class="card card-primary card-outline">
                   <div class="card-body box-profile">
                    <div class="">
                        @isset($result)
<form action="{{url('riders/picture_upload/'.$result['id'])}}" method="POST" enctype="multipart/form-data" id="formajax2">
    @endisset
    @csrf
                        @php
                        if(@$result['image_name']){
                            $image_name = Storage::url('app/profile/'.$result['image_name']);
                        }else{
                            $image_name = asset('public/uploads/default.jpg');
                        }
                    @endphp
                        <img src="{{ $image_name}}" id="output" width="400"  class="profile-user-img img-fluid" />
                        @isset($result)
                        <div class="button-wrapper">
                          <label for="upload" class="btn btn-default me-2 mb-3 mt-3" tabindex="0">
                            <span class="d-none d-sm-block">Change Photo</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" name="image_name" class="account-file-input " hidden accept="image/png, image/jpeg" onchange="loadFile(event)" />
                          </label>
                          <input type="submit" class="btn btn-primary" value="Upload"/>
                        </div>
                        @endisset
                    </form>
                      </div>
                      <script>

                        var loadFile = function (event) {
                          var image = document.getElementById("output");
                          image.src = URL.createObjectURL(event.target.files[0]);
                        };


                        </script>
                      {{-- <div class="text-center">
                         <img class="profile-user-img img-fluid" src="https://placehold.co/400X400" alt="User profile picture">
                      </div> --}}
                      <h3 class="profile-username text-center">@isset($result){{$result['name']??'not-set'}}@endisset</h3>
                      <p class="text-muted text-center">@isset($result){{$result['designation']??'not-set'}}@endisset</p>
                      <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Rider ID</b> <span class="float-right">@isset($result){{$result['rider_id']??'not-set'}}@endisset</span>
                         </li>
                         <li class="list-group-item">
                            <b>Bike Number</b> <span class="float-right">@isset($result){{$rider->bikes->plate??'not-set'}}@endisset</span>
                         </li>
                         <li class="list-group-item">
                            <b>Date Of Joining</b> <a class="float-right">@isset($result){{$result['doj']??'not-set'}}@endisset</a>
                         </li>
                         <li class="list-group-item @if(@$result['status'] == 1) text-success @else text-danger @endif" >
                            <b>Status</b> <a class="float-right">@isset($result){{App\Helpers\CommonHelper::RiderStatus($result['status'])??'not-set'}}@endisset</a>
                         </li>
                         <li class="list-group-item">
                            <b>Balance</b> <a class="float-right">@isset($trans_acc_id){{App\Helpers\Account::show_bal(App\Helpers\Account::Monthly_ob(date('y-m-d'), $trans_acc_id))??'not-set'}}@endisset</a>
                         </li>
                      </ul>
                      {{-- <a href="#" class="btn btn-primary btn-block"><b>Update</b></a> --}}
                   </div>
                </div>
             {{--    <div class="card card-primary">
                   <div class="card-header">
                      <h3 class="card-title">About Me</h3>
                   </div>
                   <div class="card-body">
                      <strong><i class="fas fa-book mr-1"></i> Education</strong>
                      <p class="text-muted">
                         B.S. in Computer Science from the University of Tennessee at Knoxville
                      </p>
                      <hr>
                      <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                      <p class="text-muted">Malibu, California</p>
                      <hr>
                      <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                      <p class="text-muted">
                         <span class="tag tag-danger">UI Design</span>
                         <span class="tag tag-success">Coding</span>
                         <span class="tag tag-info">Javascript</span>
                         <span class="tag tag-warning">PHP</span>
                         <span class="tag tag-primary">Node.js</span>
                      </p>
                      <hr>
                      <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                      <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                   </div>
                </div> --}}
             </div>
             <div class="col-md-9">
                <div class="card">
                   <div class="card-header p-2">
                      <ul class="nav nav-pills">
                         <li class="nav-item"><a class="nav-link active" href="#information" data-toggle="tab">Information</a></li>
                         @can('riders_document')
                         <li class="nav-item"><a class="nav-link" href="#documents" data-toggle="tab">Documents</a></li>
                         @endcan
                         @can('invoices_view')
                         <li class="nav-item"><a class="nav-link" href="#invoices" data-toggle="tab">Invoices</a></li>
                         @endcan
{{--                          <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
 --}}                      </ul>
                   </div>
                   <div class="card-body">
                      <div class="tab-content">
                         <div class="active tab-pane" id="information">
                            @isset($result)
                            {!! Form::model($result, ['route' => ['rider.store'], 'id'=>'formajax','class'=>'myform']) !!}
                            <input type="hidden" name="id" value="{{$result['id']}}"/>
                            <input type="hidden" name="redirect_to" id="redirect_to" value="{{url('rider')}}" />

                            @else
                            {!! Form::open(['route' => 'rider.store', 'id'=>'formajax']) !!}
                            <input type="hidden" name="id" value="0">
                            {{-- <input type="hidden" name="edit_redirect" id="edit_redirect" value="1"> --}}
                            <input type="hidden" name="redirect_to" id="redirect_to" value="{{url('rider')}}" />


                            @endisset
                            @csrf



                                <div class="row">
                                    <div class="col-md-3 form-group">

                                        <label class="required">Rider ID <span style="color:red;">*</span></label>
                                        {!! Form::text('rider_id', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <!--col-->
                                    <div class="col-md-3 form-group">
                                        <label>Rider Name <span style="color:red;">*</span></label>
                                        {!! Form::text('name', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <!--col-->
                                    <div class="col-md-3 form-group">
                                        <label>Rider Contact</label>
                                        {!! Form::text('personal_contact', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Vendor <span style="color:red;">*</span></label>
                                        <select class="form-control form-control-sm select2" name="VID">
                                            <option value="">Select</option>
                                            {!! \App\Models\Vendor::dropdown(@$result['VID']) !!}
                                        </select>
                                    </div>
                                    <!--col-->
                                    <div class="col-md-3 form-group">
                                        <label>Company Contact</label>
                                        {!! Form::text('company_contact', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <!--col-->
                                    <div class="col-md-3 form-group">
                                        <label>Personal Gmail ID  <span style="color:red;">*</span></label>
                                        {!! Form::text('personal_email', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <!--col-->
                                    {{-- <div class="col-md-3 form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control form-control-sm" name="email" placeholder="Person Email">
                                    </div> --}}
                                    <!--col-->
                                    <div class="col-md-3 form-group">
                                        <label>Nationality <span style="color:red;">*</span></label>
                                        <select class="form-control form-control-sm select2" name="nationality">
                                            <option value="">Select</option>
                                            {!! \App\Models\Country::dropdown(@$result['nationality']) !!}
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Ethnicity</label>
                                        <select type="text" class="form-control form-control-sm select2" name="ethnicity">
                                            <option value="">Select</option>
                                            {!! App\Helpers\CommonHelper::get_Ethnicity(@$result['ethnicity']) !!}

                                        </select>
                                    </div>
                                    <!--col-->
                                    <div class="col-md-3 form-group">
                                        <label>DOB <span style="color:red;">*</span></label>
                                        {!! Form::date('dob', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Date of Joining <span style="color:red;">*</span></label>
                                        {!! Form::date('doj', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Project <span style="color:red;">*</span></label>
                                        <select class="form-control form-control-sm select2" name="PID">
                                            <option value="">Select</option>
                                            {!! \App\Models\Projects::dropdown(@$result['PID']) !!}
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Designation <span style="color:red;">*</span></label>
                                        <select class="form-control form-control-sm select2" name="designation">
                                            <option value="">Select</option>
                                            {!! App\Helpers\CommonHelper::Designations(@$result['designation']) !!}
                                        </select>

                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label>Visa Sponsor</label>
                                        {!! Form::text('visa_sponsor', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Occupation on Visa <span style="color:red;">*</span></label>
                                        {!! Form::text('visa_occupation', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Visa Status</label>
                                        <select class="form-control form-control-sm select2" name="visa_status">
                                            <option value="">Select</option>
                                            {!! App\Helpers\CommonHelper::VisaStatus(@$result['visa_status']) !!}
                                        </select>
                                    </div>
                                    <!--col-->
                                    {{-- <div class="col-md-3 form-group">
                                        <label>NF DID</label>
                                        <input type="text" class="form-control form-control-sm" name="NFDID" placeholder="NF DID">
                                    </div> --}}
                                    <!--col-->
                                    <div class="col-md-3 form-group">
                                        <label>CDM Deposit ID</label>
                                        {!! Form::text('cdm_deposit_id', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <!--col-->
                                    <div class="col-md-3 form-group">
                                        <label>Mashreq ID</label>
                                        {!! Form::text('mashreq_id', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <!--col-->

                                    <!--col-->

                                    <!--col-->

                                    <!--col-->
                                    {{-- <div class="col-md-3 form-group">
                                        <label>Dept</label>
                                        <input type="text" class="form-control form-control-sm dat" name="DEPT" placeholder="Dept">
                                    </div> --}}
                                    <!--col-->

                                    <!--col-->
                                    <div class="col-md-3 form-group">
                                        <label>Branded Plate Number</label>
                                        {!! Form::text('branded_plate_no', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <!--col-->
                                    <div class="col-md-3 form-group">
                                        <label>Fleet Supervisor <span style="color:red;">*</span></label>
                                        <select class="form-control form-control-sm select2" name="fleet_supervisor">
                                            <option value="">Select</option>
                                            {!! App\Helpers\CommonHelper::get_supervisor(@$result['fleet_supervisor']) !!}
                                        </select>
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label>Status <span style="color:red;">*</span></label>
                                        <select class="form-control form-control-sm select2" name="status">
                                            <option value="">Select</option>
                                            @foreach(App\Helpers\CommonHelper::RiderStatus() as $key=>$value)
                                            <option value="{{$key}}"@if(@$result['status']==$key)selected @endif>{{$value}}</option>
                                            @endforeach


                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Salary Model <span style="color:red;">*</span></label>
                                        <select class="form-control form-control-sm select2" name="salary_model">
                                            <option value="">Select</option>
                                            {!! App\Helpers\CommonHelper::SalaryModel(@$result['salary_model']) !!}
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Rider Reference <span style="color:red;">*</span></label>
                                        {!! Form::text('rider_reference', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                </div>
                                <div class="row bg-light mb-1">
                                    <div class="col-md-3 form-group">
                                        <label>Emirate (Hub) <span style="color:red;">*</span></label>
                                        <select class="form-control form-control-sm select2" name="emirate_hub">
                                            <option value="">Select</option>
                                            {!! App\Helpers\CommonHelper::EmiratesHub(@$result['emirate_hub']) !!}
                                        </select>

                                    </div>
                                    <!--col-->
                                    <div class="col-md-3 form-group">
                                        <label>Emirate ID <span style="color:red;">*</span></label>
                                        {!! Form::text('emirate_id', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>EID EXP Date <span style="color:red;">*</span></label>
                                        {!! Form::date('emirate_exp', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Licence No <span style="color:red;">*</span></label>
                                        {!! Form::text('license_no', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Licence Expiry <span style="color:red;">*</span></label>
                                        {!! Form::date('license_expiry', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Passport <span style="color:red;">*</span></label>
                                        {!! Form::text('passport', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Passport Expiry <span style="color:red;">*</span></label>
                                        {!! Form::date('passport_expiry', null, ['class' => 'form-control form-control-sm', 'maxlength' => 255]) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Passport Handover <span style="color:red;">*</span></label>
                                        <select class="form-control form-control-sm select2" name="passport_handover">
                                            <option value="">Select</option>
                                            {!! App\Helpers\CommonHelper::get_passport_handover(@$result['passport_handover']) !!}
                                        </select>
                                    </div>
                                    {{-- <div class="col-md-3 form-group">
                                        <label>NOON No. </label>
                                        <input type="text" class="form-control form-control-sm" name="noon_no" placeholder="Noon No.">
                                    </div> --}}
                                    <div class="col-md-3 form-group">
                                        <label>WPS</label>
                                        <select class="form-control form-control-sm select2" name="wps">
                                            <option value="">Select</option>
                                            {!! App\Helpers\CommonHelper::WPS(@$result['wps']) !!}
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>C3 Card</label>
                                        <select class="form-control form-control-sm select2" name="c3_card">
                                            <option value="">Select</option>
                                            {!! App\Helpers\CommonHelper::C3Card(@$result['c3_card']) !!}
                                        </select>
                                    </div>

                                    </div>

                                <div class="row">


                                    <div class="col-md-12 form-group">
                                        <label>Other Details</label>
                                        {!! Form::textarea('other_details', null, ['class' => 'form-control form-control-sm']) !!}
                                    </div>
                                    <!--col-->
                                </div>
                                <h3>Assign Price</h3>
                                <div class="row pr-5 pl-5" >
                                    <table  class="table" style="border-radius:10px;">
                    <thead>
                        <tr class=" bg-light">
                            <td>Select Item</td>
                            <td>Enter Price</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class=" bg-light">
                            <td class="col-sm-4">

                                <select name="item_id" class="form-control form-control-sm select2" id="item_id"><option value="0">Select Item</option>
                                    @php
                                        $items = \App\Models\Item::all();
                                    @endphp
                                  @foreach($items as $item)
                                        <option value="{{$item->id}}">{{$item->item_name.' - '.$item->pirce}}</option>
                                   @endforeach
                               </select>
                            </td>
                            <td class="col-sm-4">
                                <label>Price: </label>
                                    <input type="number" step="any" name="item_price" id="item_price" />
                            </td>
                            <td >
                                <input type="button" class="btn btn-lg btn-dark btn-sm btn-block " style="width: 200px;background:#000;" id="addrow" value="Add Item" />
                            </td>

                            {{-- <td class="col-sm-2"><input type="button" class="ibtnDel btn btn-md btn-danger btn-xs"  value="Delete"></td> --}}
                        </tr>
                    </tbody>

                </table>
                <table id="myTable" class="table order-list2">
                    @isset($rider_items)
                        @foreach($rider_items as $item)
                        <tr>
                            <td width="250"><label>{{@$item->item->item_name }}(Price: {{@$item->item->pirce}})</label></td>
                            <td width="130"><input type="number" name="items[{{@$item->item->id}}]" id="item-{{@$item->tem->id}}" value="{{$item->price}}" step="any" class="form-control form-control-sm" /></td>

                            <td width="300"><input type="button" class="ibtnDel btn btn-md btn-xs btn-danger "  value="Delete"></td>
                        </tr>
                        @endforeach
                    @endisset
                </table>

                                      {{--   @php
                                            $items = \App\Models\Item::all();

                                        @endphp
                                        @foreach ($items as $item)
                                        @php
                                             /* $rider_item = \App\Models\RiderItemPrice::where('item_id',$item->id)
                                             ->where('RID',$); */
                                        @endphp

                                            <div class="col-3 form-group">
                                                <label>{{$item->item_name}}(Price: {{$item->pirce}})</label>
                                            <input type="number" name="items[{{$item->id}}]" id="item-{{$item->id}}" step="any" class="form-control form-control-sm" />
                                            </div>
                                        @endforeach
                                        </div> --}}



                                <button type="submit" class="btn btn-primary pull-right btn-md">Save Information</button>
                                {{-- <button class="btn btn-primary btn-sm loader" type="button" disabled style="display: none">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Saving...
                                </button> --}}

                            </form>

                         </div>
                         </div>
                         <div class="tab-pane" id="documents">
                            @isset($rider)
                            @include('riders.document')
                            @endisset
                         </div>
                         <div class="tab-pane" id="invoices">

                            <table class="table table-hover data-table text-nowrap" style="width:100%;">
                                <thead>
                                <tr>
                                    <th>#inv</th>
                                    <th>Date</th>
                                    <th>Billing Month</th>
                                    <th>Rider</th>
                                    <th>Rider amount</th>
                                    <th>Total Qty</th>
                                    <th>Descriptions</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            @include('invoices.rider_invoices.moda')
                            @include('invoices.rider_invoices.import-modal')
                            @include('invoices.rider_invoices.inc_func')

                         </div>
                         <div class="tab-pane" id="settings">

                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </section>
 </div>
 <script>
        $(document).ready(function() {
    // Get the initial active tab from the URL
    var activeTab = window.location.hash.replace('#', '');
    // Activate the initial tab
    $('.nav-item a[href="#' + activeTab + '"]').tab('show');
    });
</script>

 @include('riders.inc_func')

@endsection
