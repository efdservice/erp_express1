{{-- @extends('layouts.app')
@section('title', $rider->name.' Documents')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{$rider->name}} Documents</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
 --}}
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default rounded-0">

                <div class="card-body">
                    <div class="card-title"><b>{{$rider->name}}</b> Documents
                        <br>
                        <p><b>Email:</b> {{$rider->email}}
                            <b>Phone:</b> {{$rider->phone}}
                        </p>
                    </div>


<br style="clear: both;" />
<br style="clear: both;" />
                    <form action="{{route('rider.document',$rider->id)}}" method="post" enctype="multipart/form-data" id="formajax">
                        @csrf
                        @php
                        $existing = [];
                        @endphp
                @foreach($files as $file)
                @php
                    array_push($existing,$file->type);
                @endphp
                <div class="bg-light p-2 mb-2">
                    <h5>{{App\Helpers\CommonHelper::file_types($file->type)}}</h5>
                    <div class="row">
                            <input type="hidden" name="documents[{{$file->type}}][type]" value="{{$file->type}}" />
                            <div class="col-3">
                                <label>Expiry Date</label>
                                <input type="date" name="documents[{{$file->type}}][expiry_date]" value="{{$file->expiry_date}}" class="form-control form-control-sm" />
                            </div>
                            <div class="col-3">
                                <label>Document Upload</label>
                                <input type="file" name="documents[{{$file->type}}][file_name]"  />
                            </div>
                            <div class="col-2">
                                <a href="{{ Storage::url('app/rider/'.$file->file_name)}}" class="btn btn-default" target="_blank">

                                @if($file->file_type == 'pdf')
                                    <i class="fa fa-file-pdf text-danger"></i>
                                @elseif(in_array($file->file_type,['jpeg','jpg','png']))
                                    <i class="fa fa-file-image text-primary"></i>
                                    @else
                                    <i class="fa fa-file text-info"></i>
                                    @endif

                                &nbsp;
                               View Document
                                </a>

                            </div>

                    </div>
                </div>
                @endforeach
                @foreach(App\Helpers\CommonHelper::file_types() as $key=>$value)
                @if(!in_array($key,$existing))
                <div class="bg-light p-2 mb-2">
                    <h5>{{$value}}</h5>
                    <div class="row">
                            <input type="hidden" name="documents[{{$key}}][type]" value="{{$key}}" />
                            <div class="col-3">
                                <label>Expiry Date</label>
                                <input type="date" name="documents[{{$key}}][expiry_date]" class="form-control form-control-sm" />
                            </div>
                            <div class="col-3">
                                <label>Document Upload</label>
                                <input type="file" name="documents[{{$key}}][file_name]"  />
                            </div>
                            <div class="col-3"></div>

                    </div>
                </div>
                @endif
                @endforeach
                <input type="submit" class="btn btn-primary" value="Save Documents" />
                    </form>


    </div>
</div>
        </div>
   {{--  </section>
</div>

@endsection --}}
