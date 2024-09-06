@extends('layouts.app')
@section('title', 'Rider Profile')

@section('content')
<style>
.myform .required:after {
  content: " *";
    color: red;
    font-weight: 200;
}
@media print{
    body .content{
        font-size: 18px !important;

    }
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
             <div class="col-md-3 col-3 bg-light">
                <div class="card border">
                   <div class="card-body box-profile">
                    <div class="">

                        @php
                        if(@$result['image_name']){
                            $image_name = Storage::url('app/profile/'.$result['image_name']);
                        }else{
                            $image_name = asset('public/uploads/default.jpg');
                        }
                    @endphp
                        <img src="{{ $image_name}}" id="output" width="400"  class="profile-user-img img-fluid" />


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
                      <br/>
                      <h3 class="profile-username text-center">@isset($result){{$result['name']??'not-set'}}@endisset</h3>
                      <p class="text-muted text-center">@isset($result){{$result['designation']??'not-set'}}@endisset</p>
                      <ul class="list-group list-group-unbordered mb-3">
                         <li class="list-group-item">
                            <b>Date Of Joining</b> <span class="float-right">@isset($result){{$result['doj']??'not-set'}}@endisset</span>
                         </li>
                         <li class="list-group-item">
                            <b>Status</b> <span class="float-right">@isset($result){{App\Helpers\CommonHelper::RiderStatus($result['status'])??'not-set'}}@endisset</span>
                         </li>
                         <li class="list-group-item">
                            <b>Balance</b> <span class="float-right">@isset($rider->account->id){{App\Helpers\Account::show_bal(App\Helpers\Account::Monthly_ob(date('y-m-d'), $rider->account->id))??'not-set'}}@endisset</span>
                         </li>
                      </ul>
                      <a href="{{route('rider.edit', $result['id'])}}" class="btn btn-default btn-block"><i class="fa fa-edit"></i>&nbsp;<b>Edit</b></a>

                      <a href="javascript:void(0);" class="btn btn-default btn-block no-print" onclick="window.print();"><i class="fa fa-print"></i>&nbsp;<b>Print</b></a>
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
             <style>
                .form-group p{
                    font-weight:bold;
                }
             </style>
             <div class="col-md-9 col-9">
                <div class="card">
                   <div class="card-header p-2 no-print">
                      <ul class="nav nav-pills">
                         <li class="nav-item"><a class="nav-link active" href="#information" data-toggle="tab">Information</a></li>
                         @can('riders_document')
                         <li class="nav-item"><a class="nav-link" href="{{route('rider.edit', $result['id'])}}#documents">Documents</a></li>
                         @endcan
                         @can('invoices_view')
                         <li class="nav-item"><a class="nav-link" href="{{route('rider.edit', $result['id'])}}#invoices" >Invoices</a></li>
                         @endcan
{{--                          <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
 --}}                      </ul>
                   </div>
                   <div class="card-body">
                      <div class="tab-content">
                         <div class="active tab-pane" id="information">

                            <div class="card border">

                                <div class="card-header"><b>Personal Information</b></div>
                                    <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3 form-group col-3">

                                                    <label class="required">Rider ID </label>
                                                    <p>{{$result['rider_id']}}</p>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-3 form-group col-3">
                                                    <label>Rider Name </label>
                                                    <p>{{@$result['name']}}</p>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-3 form-group col-3">
                                                    <label>Rider Contact</label>
                                                    <p>{{@$result['personal_contact']}}</p>
                                                </div>
                                                <div class="col-md-3 form-group col-3">
                                                    <label>Vendor </label>
                                                    <p>{{@$rider->vendor->name}}</p>

                                                </div>
                                                <!--col-->
                                                <div class="col-md-3 form-group col-3">
                                                    <label>Company Contact</label>
                                                    <p>{{@$result['company_contact']}}</p>
                                                </div>
                                                <!--col-->
                                                <div class="col-md-3 form-group col-3">
                                                    <label>Personal Gmail ID  </label>
                                                    <p>{{@$result['personal_email']}}</p>
                                                </div>
                                                <!--col-->
                                                {{-- <div class="col-md-3 form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control form-control-sm" name="email" placeholder="Person Email">
                                                </div> --}}
                                                <!--col-->
                                                <div class="col-md-3 form-group col-3">
                                                    <label>Nationality </label>
                                                    <p>{{@$rider->country->name}}</p>

                                                </div>
                                                <div class="col-md-3 form-group col-3">
                                                    <label>Ethnicity</label>
                                                    <p>{{@$result['ethnicity']}}</p>

                                                </div>
                                                <!--col-->
                                                <div class="col-md-3 form-group col-3">
                                                    <label>DOB </label>
                                                    <p>{{@$result['dob']}}</p>
                                                </div>
                                            </div>

                                </div>
                            </div>

                            <div class="card border">
                                <div class="card-header"><b>Job Detail</b></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 form-group col-3">
                                            <label>Date of Joining </label>
                                            <p>{{@$result['doj']}}</p>
                                        </div>
                                        <div class="col-md-3 form-group col-3">
                                            <label>Project </label>
                                            <p>{{@$rider->project->name}}</p>

                                        </div>
                                        <div class="col-md-3 form-group col-3">
                                            <label>Designation </label>
                                            <p>{{@$result['designation']}}</p>


                                        </div>


                                        <!--col-->
                                        {{-- <div class="col-md-3 form-group">
                                            <label>NF DID</label>
                                            <input type="text" class="form-control form-control-sm" name="NFDID" placeholder="NF DID">
                                        </div> --}}
                                        <!--col-->
                                        <div class="col-md-3 form-group col-3">
                                            <label>CDM Deposit ID</label>
                                            <p>{{@$result['cdm_deposit_id']}}</p>
                                        </div>
                                        <!--col-->

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
                                        <div class="col-md-3 form-group col-3">
                                            <label>Branded Plate Number</label>
                                            <p>{{@$result['branded_plate_no']}}</p>
                                        </div>
                                        <!--col-->
                                        <div class="col-md-3 form-group col-3">
                                            <label>Fleet Supervisor </label>
                                            <p>{{@$result['fleet_supervisor']}}</p>

                                        </div>

                                        <div class="col-md-3 form-group col-3">
                                            <label>Status </label>
                                            <p>{{App\Helpers\CommonHelper::RiderStatus(@$result['status'])}}</p>

                                        </div>
                                        <div class="col-md-3 form-group col-3">
                                            <label>Salary Model </label>
                                            <p>{{@$result['salary_model']}}</p>

                                        </div>
                                        <div class="col-md-3 form-group col-3">
                                            <label>Rider Reference </label>
                                            <p>{{@$result['rider_reference']}}</p>
                                        </div>
                                        <div class="col-md-3 form-group col-3">
                                            <label>WPS</label>
                                            <p>{{@$result['wps']}}</p>

                                        </div>
                                        <div class="col-md-3 form-group col-3">
                                            <label>C3 Card</label>
                                            <p>{{$result['c3_card']}}</p>

                                        </div>
                                        <div class="col-md-12 form-group col-12">
                                            <label>Other Details</label>
                                            <p>{{@$result['other_details']}}</p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border">
                                <div class="card-header"><b>Visa & Registerations</b></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 form-group col-3">
                                            <label>Visa Sponsor</label>
                                            <p>{{@$result['visa_sponsor']}}</p>
                                        </div>
                                        <div class="col-md-3 form-group col-3">
                                            <label>Occupation on Visa </label>
                                            <p>{{@$result['visa_occupation']}}</p>
                                        </div>
                                        <div class="col-md-6 form-group col-3">
                                            <label>Visa Status</label>
                                            <p>{{@$result['visa_status']}}</p>

                                        </div>
                                            <div class="col-md-3 form-group col-3">
                                                <label>Emirate (Hub) </label>
                                                <p>{{@$result['emirate_hub']}}</p>

                                            </div>
                                            <!--col-->
                                            <div class="col-md-3 form-group col-3">
                                                <label>Emirate ID </label>
                                                <p>{{@$result['emirate_id']}}</p>
                                            </div>
                                            <div class="col-md-3 form-group col-3">
                                                <label @if(strtotime($result['emirate_exp']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>EID EXP Date </label>
                                                <p @if(strtotime($result['emirate_exp']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>{{@$result['emirate_exp']}}</p>
                                            </div>
                                            <div class="col-md-3 form-group col-3">
                                                <label>Licence No </label>
                                                <p>{{@$result['license_no']}}</p>
                                            </div>
                                            <div class="col-md-3 form-group col-3">
                                                <label @if(strtotime($result['license_expiry']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>Licence Expiry </label>
                                                <p @if(strtotime($result['license_expiry']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>{{@$result['license_expiry']}}</p>
                                            </div>
                                            <div class="col-md-3 form-group col-3">
                                                <label>Passport </label>
                                                <p>{{@$result['passport']}}</p>
                                            </div>
                                            <div class="col-md-3 form-group col-3">
                                                <label @if(strtotime($result['passport_expiry']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>Passport Expiry </label>
                                                <p @if(strtotime($result['passport_expiry']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>{{@$result['passport_expiry']}}</p>
                                            </div>
                                            <div class="col-md-3 form-group col-3">
                                                <label>Passport Handover </label>
                                                <p>{{@$result['passport_handover']}}</p>

                                            </div>
                                            {{-- <div class="col-md-3 form-group">
                                                <label>NOON No. </label>
                                                <input type="text" class="form-control form-control-sm" name="noon_no" placeholder="Noon No.">
                                            </div> --}}

                                            <div class="col-md-3 form-group col-3">
                                                <label>Mashreq ID</label>
                                                <p>{{@$result['mashreq_id']}}</p>
                                            </div>
                                    </div>
                                </div>
                            </div>

                               <div class="card border">
                                <div class="card-header"><b>Items & Prices</b></div>
                                <div class="card-body">


                                <div class="row border" >
                                    <table  class="table border" style="border-radius:10px;">
                    <thead>
                        <tr class="">
                            <th>Items</th>
                            <th>Price</th>
                        </tr>
                    </thead>

                </table>
                <table id="myTable" class="table order-list2 border">
                    @isset($rider_items)
                        @foreach($rider_items as $item)
                        <tr>
                            <td width="250"><label>{{@$item->item->item_name }}(Price: {{@$item->item->pirce}})</label></td>
                            <td width="240">{{$item->price}}</td>
                        </tr>
                        @endforeach
                    @endisset
                </table>


                         </div>
                        </div>
                    </div>
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


 @include('riders.inc_func')

@endsection
