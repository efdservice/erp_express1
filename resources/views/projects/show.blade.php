
<div class="card border">

    <div class="card-header"><b>Customer Information</b>
    <a href="{{route('projects.show',$project->id)}}" class="float-right">Refresh
    </a>
    </div>
        <div class="card-body">
                <div class="row">
                    <div class="col-md-3 form-group col-3">

                        <label class="required">ID </label>
                        <p>{{$project->id}}</p>
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group col-3">
                        <label>Name </label>
                        <p>{{$project->name}}</p>
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group col-3">
                        <label>Company Name</label>
                        <p>{{$project->company_name}}</p>
                    </div>
                    <div class="col-md-3 form-group col-3">
                        <label>Company email </label>
                        <p>{{$project->company_email}}</p>

                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group col-3">
                        <label>Company Contact</label>
                        <p>{{$project->company_number}}</p>
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group col-3">
                        <label>Address</label>
                        <p>{{$project->address}}</p>
                    </div>
                    <div class="col-md-3 form-group col-3">
                        <label>TAX Number</label>
                        <p>{{$project->tax_number}}</p>
                    </div>
                    <div class="col-md-3 form-group col-3">
                        <label>TAX Percentage</label>
                        <p>{{$project->tax_percentage}}</p>
                    </div>

    </div>
</div>
</div>
