@extends('layouts.app')
@section('content')
<style>
    .table tr:first-child>td{
    position: sticky;
    top: 0;
}
</style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Reports</li>
                            <li class="breadcrumb-item active">Rider Report</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">

                    <div class="card rounded-0">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <h3>Rider Report</h3>
                            <form id="form">
                                <div class="row">

                                    <div class="col-md-3">
                                        <label>Status</label>
                                        <select class="form-control form-control-sm select2" name="status">
                                            <option value="">Select</option>
                                            @foreach(App\Helpers\CommonHelper::RiderStatus() as $key=>$value)
                                            <option value="{{$key}}"@if(request('status')==$key)selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">

                                        <label>Biling Month</label>
                                        <input type="month" name="billing_month" value="{{request('billing_month')??date('Y-m')}}" class="form-control form-control-sm" required/>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="get_data()"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                                <!--row-->
                            </form>
                            <br>
                            <button class="btn btn-xs btn-primary float-right exportToExcel"><i class="fa fa-file-excel"> Export</i> </button>
                            <table id="table2excel" class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th >Name</th>
                                    <th>Vendor</th>
                                    <th >Designation</th>
                                    <th >Bike No</th>
                                    <th>Status</th>
                                    <th>Balance</th>

                                </tr>
                                </thead>
                                <tbody id="get_data"></tbody>
                               {{--  @foreach($riders as $row)
                                <tr>
                                    <td>{{$row->rider_id}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{@$row->vendor->name}}</td>
                                    <td >{{$row->designation}}</td>
                                    <td >{{@$row->bikes->plate}}</td>
                                    <td>{{ App\Helpers\CommonHelper::RiderStatus($row->status) }}</td>
                                    <td>@isset($row->account->id){{ App\Helpers\Account::show_bal(App\Helpers\Account::ob(date('Y-m-d'),$row->account->id)) }}@endisset</td>
                                    <td></td>


                                </tr>
                                @endforeach
 --}}
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <div class="pagination-panel"></div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ URL::asset('public/export_excel/jquery.table2excel.js') }}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();

        });
        function get_data(){
            $("#loader").show();
            $.ajax({
                url:"{{ url('reports/rider_report_data') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                data:$("#form").serialize(),
                dataType:"JSON",
                success:function (data) {
                    $("#get_data").html(data.data);
                    $("#loader").hide();
                }
            })
        }
    </script>
    <script>
        var jq = $.noConflict();
        jq(document).ready(function(){
            $(".exportToExcel").click(function () {
                jq("#table2excel").table2excel({
                    filename: "Rider_report.xls",
                    exclude: ".noExl",
                    name: "Rider Report",
                    filename: "Rider_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: true,
                });
            });
        });
    </script>
@endsection
