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
                            <b>Rider ID</b> <span class="float-right">@isset($result){{$result['rider_id']??'not-set'}}@endisset</span>
                         </li>
                         <li class="list-group-item">
                            <b>Bike Number</b> <span class="float-right">@isset($result){{$rider->bikes->plate??'not-set'}}@endisset</span>
                         </li>
                         <li class="list-group-item">
                            <b>Date Of Joining</b> <span class="float-right">@isset($result){{$result['doj']??'not-set'}}@endisset</span>
                         </li>
                         <li class="list-group-item @if(@$result['status'] == 1) text-success @else text-danger @endif">
                            <b>Status</b> <span class="float-right">@isset($result){{App\Helpers\CommonHelper::RiderStatus($result['status'])??'not-set'}}@endisset</span>
                         </li>
                         <li class="list-group-item @if(@$result['job_status'] == 1) text-success @else text-danger @endif" >
                            <b>Job Status</b> <span class="float-right">
                                @isset($result['job_status']) <a href="javascript:void(0);" data-action="{{url('riders/job_status/'.$result['id'])}}" data-title="Change Job Status" class="btn btn-default btn-sm show-modal">Change Status</a>
                                {{App\Helpers\CommonHelper::JobStatus($result['job_status'])??'not-set'}}@endisset</span>
                               @isset($rider->jobstatus)
                                <hr/>
                                <b>Reason:</b>
                                {{$rider->jobstatus->reason??'not-set'}}
                                @endisset
                         </li>
                         <li class="list-group-item ">
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
                         <li class="nav-item"><a class="nav-link" href="{{route('rider.edit', $result['id'])}}#timeline">Timeline</a></li>
                         @can('invoices_view')
                         <li class="nav-item"><a class="nav-link" href="{{route('rider.edit', $result['id'])}}#invoices" >Invoices</a></li>
                         @endcan
{{--                          <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
 --}}                      </ul>
                   </div>
                   <div class="card-body">
                      <div class="tab-content">
                         <div class="active tab-pane" id="information">
                            @include('riders.show')
                         </div>

                         {{-- <div class="tab-pane" id="timeline">
                            @include('riders.timeline')
                         </div> --}}


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
