@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Invoice Payment Vouchers</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Accounts</li>
                            <li class="breadcrumb-item active">Rider Pv List</li>
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
                            <form id="form2">

                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" name="df" class="form-control form-control-sm date"  placeholder="From Date">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="dt" class="form-control form-control-sm date"  placeholder="To Date">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="voucher" class="form-control form-control-sm"  placeholder="Searh With Voucher#">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-flat btn-xs btn-dark" onclick="get_data()"><i class="fas fa-search"></i> </button>
                                </div>
                            </div>
                            </form>
                            @can('pv_create')
                            <a href="javascript:void(0);" data-title="Invoice Payment Voucher" data-size="xl" data-action="{{ url('Accounts/vouchers/rider_pv/create')}}" class="btn btn-xs btn-dark float-right show-modal" {{-- onclick="add_new()" --}}>Add New</a>
                            @endcan
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Voucher#</th>
                                    <th>Trans Date</th>
                                    <th>Narration</th>
                                    <th>Amount</th>
                                    <th>Attachment</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="get_data"></tbody>
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
    @include('partials.modal')
   {{--  @include('Accounts.vouchers.rider_pv.modal') --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function add_new() {
            $(".select2").select2();
            $("#new").modal({backdrop: 'static', keyboard: false},'show');
            document.getElementById("form").reset();
            $("#form input[name~='id']").val(0);
            $("#new").find('.btn-success').text('Submit');
        }
        $(document).ready(function () {
            get_data();
            var base_url = $('#base_url').val();
            var counter = 0;

           
            $(".client_inv").on("change",function () {
                var pt=$(this).closest('form').find('.pt').val();
                if(pt==1){
                    pt='Cash';
                }else if(pt==2){
                    pt='Cheque';
                }else if(pt==3){
                    pt='Online';
                }
                var client=$(this).find("option:selected").text();
                $(this).closest('form').find('.narration').val('Paid '+pt+' to '+client);
            })
        });
        $("#form").submit(function (e) {
            $("#loader").show();
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:"{{ route('rider_pv.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success:function (data) {
                    $("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    document.getElementById("form").reset();
                    $("#new").modal('hide');
                    get_data();
                    $("#loader").hide();
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    $.each(vali, function( index, value ) {
                        $("#form input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                    });
                    $("#loader").hide();
                }
            })
        });
       // get_data();
        function get_data(page){
            $("#loader").show();
            $.ajax({
                url:"{{ url('Accounts/vouchers/get_payment_vouchers') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                data:$("#form2").serialize(),
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].trans_code+'">';
                        htmlData+='<td>'+data.data[i].id+'</td>';
                        htmlData+='<td>'+data.data[i].trans_code+'</td>';
                        htmlData+='<td>'+data.data[i].trans_date+'</td>';
                        htmlData+='<td>'+data.data[i].remarks+'</td>';
                        htmlData+='<td>'+data.data[i].amount+'</td>';
                        if(data.data[i].attach_file==null){
                            htmlData += '<td>N/A</td>';
                        }else {
                            var doc_url = "{{ Storage::url('app/voucher/')}}"+data.data[i].attach_file;
                            htmlData += '<td><a  class="btn btn-success btn-xs" href="'+doc_url+'" download><i class="fa fa-download"></i> Attached Document</a></td>';
                        }
                        htmlData+='<td>';
                        htmlData+=' <a  class="btn btn-default btn-xs" target="_blank" href="{{ url('Accounts/vouchers/rider_pv') }}/'+data.data[i].trans_code+'"><i class="fa fa-eye"></i> </a>';
                        @can('pv_edit')
                        htmlData+=' <a  class="btn btn-primary btn-xs show-modal" href="javascript:void(0);" data-size="xl" data-title="Edit Payment Voucher" data-action="{{ url('Accounts/vouchers/rider_pv/') }}/'+data.data[i].trans_code+'/edit"><i class="fa fa-edit"></i> </a>';
                        @endcan
                        @can('pv_delete')
                        htmlData+=' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\''+data.data[i].trans_code+'\', \'{{ url('Accounts/vouchers/payment_vouchers/') }}/'+data.data[i].trans_code+'\')"><i class="fa fa-trash"></i> </a>';
                        @endcan
                        htmlData+='</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                    $("#loader").hide();
                }
            })
        }
        function edit(id) {
            $("#new").modal({backdrop: 'static', keyboard: false},'show');
            $.ajax({
                url: "{{ url('Accounts/trans_accounts') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    for (i=0; i<Object.keys(data).length; i++){
                        $("#form input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                        $("#form select[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                    }
                    $('.select2').select2();
                    $("#new").find(".btn-success").text('Update');
                }
            })
        }
        /*
        fetch invoice against data
         */
        function fetch_invoices(g) {
            let id=g;
            var vt=$("#voucher_type").val();
            $.ajax({
                url: "{{ url('Accounts/vouchers/fetch_invoices') }}/"+id+'/'+vt,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $("table.order-list").html(data.htmlData);
                    $("#riderBalance").val(data.rider_balance);
                    $("#vendor_balance").val(data.vendor_balance);
                    
                }
            });
        }
        $(document).on("change","#voucher_type",function () {
            let thisVal=$(this).val();
            
            if(thisVal==5){
                $("#vendor_section").hide();
                $("#rider_section").show();
                $("table.order-list").html('');
            }else{
                $("#vendor_section").show();
                $("#rider_section").hide();
                $("table.order-list").html('');
            }
            $("#TotalAmount").html('<b>Total Amount:0.00</b>');
        });   
        
       
        
    </script>
@endsection<!-- jQuery -->
