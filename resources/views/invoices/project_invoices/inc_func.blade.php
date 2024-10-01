    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js" defer></script>
<script type="text/javascript">
    function add_new(){
        $(".item:first-child").show();
        $("#modal-new").modal({backdrop: 'static', keyboard: false},'show');
        $(".append-line").html('');
       document.getElementById("form").reset();
       $("#form input[name~='id']").val(0);
       $(".select2").select2();
    }

    $("#form").submit(function (e) {
        let formID='form';
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url:"{{ route('project_invoices.store') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $("#"+formID).find('.save_rec').hide();
                $("#"+formID).find('.loader').show();
            },
            success:function (data) {
                $("#"+formID+ " input[name~='id']").val(0);
                toastr.success('Operation Successfully..');
                document.getElementById(formID).reset();
                $("#modal-new").modal('hide');
                $('.data-table').DataTable().ajax.reload(null,false);
            },error:function(ajaxcontent) {
                if(ajaxcontent.responseJSON.success=='false'){
                    toastr.error(ajaxcontent.responseJSON.errors);
                    return false;
                }
                vali=ajaxcontent.responseJSON.errors;
                $.each(vali, function( index, value ) {
                    $("#"+formID+ " input[name~='" + index + "']").css('border', '1px solid red');
                    $("#"+formID+ " select[name~='" + index + "']").parent().find('.select2-container--default .select2-selection--single').css('border','1px solid red');
                    toastr.error(value);
                });
            },
            complete: function() {
                $("#"+formID).find('.save_rec').show();
                $("#"+formID).find('.loader').hide();
            },
        })
    });


    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: "{{ route('getProjectInvoices') }}?rider_id={{request('rider_id')??request()->segment(2)}}",
            columns: [
                {data: 'inv_no', name: 'inv_no'},
                {data: 'inv_date', name: 'inv_date'},
                {data: 'billing_month', name: 'billing_month'},
                {data: 'project_name', name: 'project_name'},
                {data: 'total_amount', name: 'total_amount'},
/*                 {data: 'vendor_total', name: 'vendor_total'},
 */                {data: 'total_qty', name: 'total_qty'},
                {data: 'descriptions', name: 'descriptions'},
                {data: 'action', name: 'action',
                    orderable: false, searchable: false
                },
            ]
        });
    });
    // add new line item
    $(document).on("click",".new_line_item",function () {
            $(".append-line").append('<div class="row item">\n' +
                '    <div class="col-md-3 form-group">\n' +
                '        <select class="form-control form-control-sm select2" name="item_id[]" onchange="search_price(this)">\n' +
                '            <option value="">---Select---</option>\n' +
                '            {!! \App\Models\Item::dropdown() !!}\n' +
                '        </select>\n' +
                '    </div>\n' +
                '    <!--col-->\n' +
                '    <div class="col-md-1 form-group">\n' +
                '        <input type="text" class="form-control form-control-sm qty" name="qty[]" placeholder="0" value="1">\n' +
                '    </div>\n' +
                '    <!--col-->\n' +
                '    <div class="col-md-1 form-group">\n' +
                '        <input type="text" class="form-control form-control-sm rate" name="rate[]" placeholder="0" value="0">\n' +
                '    </div>\n' +
                '    <!--col-->\n' +
                '    <div class="col-md-1 form-group">\n' +
                '        <input type="text" class="form-control form-control-sm discount" name="discount[]" placeholder="0" value="0">\n' +
                '    </div>\n' +
                '    <!--col-->\n' +
                '    <div class="col-md-1 form-group">\n' +
                '        <input type="text" class="form-control form-control-sm tax" name="tax[]" placeholder="0" value="0">\n' +
                '    </div>\n' +
                '    <!--col-->\n' +
                '    <div class="col-md-1 form-group">\n' +
                '        <input type="text" class="form-control form-control-sm amount" name="amount[]" placeholder="0" value="0">\n' +
                '    </div>\n' +
                '    <!--col-->\n' +
                '    <div class="col-md-1 form-group">\n' +
                '        <button type="button" class="btn btn-sm btn-danger remove"><i class="fa fa-trash"></i> </button>\n' +
                '    </div>\n' +
                '    <!--col-->\n' +
                '</div>\n' +
                '<!--row-->');
            $(".select2").select2();
    });
    $(document).on("change",".item",function () {
            let qty=$(this).find(".qty").val();
            let rate=$(this).find(".rate").val();
            let discount=$(this).find(".discount").val();
            let tax=$(this).find(".tax").val();

            let amount=Number(qty)*Number(rate)-Number(discount)+Number(tax);
            $(this).find(".amount").val(amount);
            sub_total();
    });

    function sub_total() {
        var sum=0;
        $(".amount").each(function () {
            sum += Number($(this).val());
        });
        $("#sub_total").val(Number(sum).toFixed(2));
    }
    $(document).on("click",".remove",function () {
            $(this).parents(".row").remove();
    });

   function search_price(g) {
       /* RID=$("#RID").val(); */
       item_id=$(g).val();
       $.ajax({
           url:"{{ url('invoices/get_item_price/') }}/"+item_id,
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           type:"GET",
           dataType:"JSON",
           success:function (data) {


               $(g).closest(".row").find(".rate").val(data.pirce);
               let qty=$(g).closest('.row').find(".qty").val();
               let rate=$(g).closest('.row').find('.rate').val();
               let discount=$(g).closest('.row').find(".discount").val();
               let tax = Number(rate*0.05).toFixed(2);
               $(g).closest(".row").find(".tax").val(tax);
               //let tax=$(g).closest('.row').find(".tax").val();
               let amount=Number(qty)*Number(rate)-Number(discount)+Number(tax);
               $(g).closest('.row').find(".amount").val(Number(amount).toFixed(2));
               sub_total();
           }
       })
   }
   //edit invoice
    $(function () {
    $("body").on("click", ".editRiderInvRec",function (){
        let mdl=$(this).attr('data-modalID');
        $("#"+mdl).modal();
        frmId=$("#"+mdl).find('form').attr('id');
        let formUrl=$(this).attr('data-action');
        $(".append-line").html('');
        $.ajax({
            url:formUrl,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                $(".item:first-child").hide();
                for (i=0; i<Object.keys(data.result).length; i++){
                    $(frmId+" input[name~='"+Object.keys(data.result)[i]+"']").val(Object.values(data.result)[i]);
                    $(frmId+" select[name~='"+Object.keys(data.result)[i]+"']").val(Object.values(data.result)[i]);
                    $(frmId+" textarea[name~='"+Object.keys(data.result)[i]+"']").val(Object.values(data.result)[i]);

                    if(Object.keys(data.result)[i]=='billing_month'){
                        var b_month = Object.values(data.result)[i];
                         var b= b_month.split('-01');

                        $("#billing_month").val(b[0]);
                    }
                }
                $(".append-line").append(data.html);
                $(".select2").select2();
            }
        })
    });
    })

    //upload excelfile
    $(document).ready(function (e) {
        $("#upload-excel").on("submit",function (e){
            e.preventDefault();
            $.ajax({
                url:"{{ route('invoices.import_excel') }}",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend : function()
                {
                    $("#upload-excel").find('.save_rec').hide();
                    $("#upload-excel").find('.loader').show();
                },
                success: function(data)
                {
                    toastr.success('Operation Successfully..');
                    $('.data-table').DataTable().ajax.reload();
                    $("#excel-modal").modal('hide');
                },error:function(ajaxcontent) {
                    if(ajaxcontent.responseJSON.success=='false'){
                        toastr.error(ajaxcontent.responseJSON.errors);
                        return false;
                    }
                    vali=ajaxcontent.responseJSON.errors;
                    $.each(vali, function( index, value ) {
                        $("#excel-form input[name~='" + index + "']").css('border', '1px solid red');
                        $("#excel-form select[name~='" + index + "']").parent().find('.select2-container--default .select2-selection--single').css('border','1px solid red');
                        toastr.error(value);
                    });
                },
                complete: function() {
                    $("#upload-excel").find('.save_rec').show();
                    $("#upload-excel").find('.loader').hide();
                },
            });
        });
    });
</script>
