@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Journal Vouchers</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Accounts</li>
                            <li class="breadcrumb-item active">Journal Voucher List</li>
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
                            <form id="form">
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" name="df" class="form-control form-control-sm date" placeholder="From Date">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="dt" class="form-control form-control-sm date" placeholder="To Date">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="voucher" class="form-control form-control-sm" placeholder="Searh With Voucher#">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-xs btn-primary" onclick="get_data()"><i class="fa fa-search"></i> </button>
                                </div>
                            </form>
                            </div>
                            <button class="btn btn-xs btn-dark float-right" onclick="add_new()">Add New</button>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Voucher#</th>
                                    <th>Trans Date</th>
                                    <th>Narration</th>
                                    <th>Amount</th>
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
    @include('Accounts.vouchers.journal_vouchers.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function add_new() {
            $(".select2").select2();
            $("#new").modal({backdrop: 'static', keyboard: false},'show');
            document.getElementById("form").reset();
            $("#form input[name~='id']").val(0);
            $("#new").find('.btn-success').text('Submit');
            $(".hide_row").show();
            $(".append-line").html('');
        }
        $(document).ready(function () {
            get_data();
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
        function save_rec() {
            $("#loader").show();
            var td=$(".total_dr").val();
            var tc=$(".total_cr").val();
            if(td!=tc){
                toastr.error('Dr Amount Should equal to Cr Amount!!');
                $("#loader").hide();
                return false;
            }
            $.ajax({
                url:"{{ route('journal_vouchers.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#form").serialize(),
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
        }
        //get_data();
        function get_data(page){
            $("#loader").show();
            $.ajax({
                url:"{{ url('Accounts/vouchers/get_journal_vouchers') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                data:$("#form").serialize(),
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].trans_code+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].trans_code+'</td>';
                        htmlData+='<td>'+data.data[i].trans_date+'</td>';
                        htmlData+='<td>'+data.data[i].remarks+'</td>';
                        htmlData+='<td>'+data.data[i].amount+'</td>';
                        htmlData+='<td>';
                        htmlData+=' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\''+data.data[i].trans_code+'\', \'{{ url('Accounts/vouchers/journal_vouchers') }}/'+data.data[i].trans_code+'\')"><i class="fa fa-trash"></i> </a>';
                        htmlData+=' <a  class="btn btn-info btn-xs" href="javascript:void(0)" onclick="edit(\''+data.data[i].trans_code+'\')"><i class="fa fa-edit"></i> </a>';
                        htmlData+=' <a  class="btn btn-default btn-xs" target="_blank" href="{{ url('Accounts/vouchers/journal_vouchers') }}/'+data.data[i].trans_code+'"><i class="fa fa-eye"></i> </a>';
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
            $("#loader").show();
            $(".hide_row").hide();
            $.ajax({
                url: "{{ url('Accounts/vouchers/journal_vouchers') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                        $("#form input[name~='trans_date']").val(data.result.trans_date);
                        $("#form input[name~='posting_date']").val(data.result.posting_date);
                        $("#form select[name~='payment_type']").val(data.result.payment_type);
                        $("#form select[name~='month']").val(data.result.month);
                    $("#form input[name~='id']").val(data.result.trans_code);
                    $(".append-line").html(data.htmlData);
                    $(".total_dr").val(data.result.amount);
                    $(".total_cr").val(data.result.amount);
                    $('.select2').select2();
                    $("#new").find(".btn-success").text('Update');
                    $("#loader").hide();
                }
            })
        }
        $(document).on("click",".new_line",function () {
            $(".append-line").append(`
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <select name="trans_acc_id[]" class="form-control form-control-sm select2">
                                            <option value="">Select</option>
                                            {!! \App\Models\Accounts\TransactionAccount::dropdown() !!}
                                        </select>
                                </div>
                        <div class="form-group col-md-4">
                            <textarea name="narration[]" class="form-control form-control-sm" rows="10" placeholder="Narration" style="height: 40px !important;"></textarea>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="number" name="dr_amount[]" class="form-control form-control-sm dr_amount" placeholder="Paid Amount">
                        </div>
                        <div class="form-group col-md-2">
                            <input type="number" name="cr_amount[]" class="form-control form-control-sm cr_amount" placeholder="Paid Amount">
                        </div>
                        <div class="form-group col-md-1">
                            <button type="button" class="btn btn-danger btn-xs remove"><i class="fa fa-trash"></i> </button>
                        </div>
                    </div>
`               );
            $(".select2").select2();
        });
        $(document).on("click",".remove", function () {
            $(this).closest(".row").remove();
            //
            var sum=0;
            $(".cr_amount").each(function () {
                sum+=Number($(this).val());
            });
            $(".total_cr").val(sum);
            //
            var summ=0;
            $(".dr_amount").each(function () {
                summ+=Number($(this).val());
            });
            $(".total_dr").val(summ);
        });
        $(document).on("keyup",".cr_amount", function () {
            var sum=0;
            $(".cr_amount").each(function () {
                sum+=Number($(this).val());
            });
            $(".total_cr").val(sum);
        });
        $(document).on("keyup",".dr_amount", function () {
            var sum=0;
            $(".dr_amount").each(function () {
                sum+=Number($(this).val());
            });
            $(".total_dr").val(sum);
        });

    </script>
@endsection<!-- jQuery -->
