@extends('layouts.app')
@section('title', 'Customer Profile')

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
                <h1>Customer Profile</h1>
             </div>
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                   <li class="breadcrumb-item"><a href="{{url('projects')}}">Customers</a></li>
                   <li class="breadcrumb-item active">Customer Profile</li>
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
                      <h3 class="profile-username text-center">@isset($project){{$project->name??'not-set'}}@endisset</h3>
                      <p class="text-muted text-center">@isset($project){{$project->company_name??'not-set'}}@endisset</p>
                      <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Customer ID</b> <span class="float-right">@isset($project){{$project->id??'not-set'}}@endisset</span>
                         </li>
                         <li class="list-group-item">
                            <b>Created Date</b> <span class="float-right">@isset($project){{$project->created_at->format('d M Y')??'not-set'}}@endisset</span>
                         </li>
                         <li class="list-group-item @if($project->status == 1) text-success @else text-danger @endif">
                            <b>Status</b> <span class="float-right">Active</span>
                         </li>

                         <li class="list-group-item ">
                            <b>Balance</b> <span class="float-right">@isset($project->account->id){{App\Helpers\Account::show_bal(App\Helpers\Account::Monthly_ob(date('y-m-d'), $project->account->id))??'not-set'}}@endisset</span>
                         </li>
                      </ul>
                      <a href="#" data-toggle="tooltip" data-action="{{route('projects.edit', $project->id)}}" data-modalID="modal-new1" class="btn btn-default btn-block no-print editRec" ><i class="fa fa-edit"></i>&nbsp;<b>Edit</b></a>

                      <a href="javascript:void(0);" class="btn btn-default btn-block no-print" onclick="window.print();"><i class="fa fa-print"></i>&nbsp;<b>Print</b></a>
                   </div>
                </div>

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
                         @can('invoices_view')
                         <li class="nav-item"><a class="nav-link" href="#invoices" data-toggle="tab">Invoices</a></li>
                         @endcan
{{--                          <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
 --}}                      </ul>
                   </div>
                   <div class="card-body">
                      <div class="tab-content">
                         <div class="active tab-pane" id="information">
                            @include('projects.show')
                         </div>


                         <div class="tab-pane" id="invoices">
                            @include('projects.invoices')
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
@include('projects.moda')
@include('projects.inc_func')

@endsection
