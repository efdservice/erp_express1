
<script type="text/javascript">
    function add_new(){
        $("#modal-new").modal({backdrop: 'static', keyboard: false},'show');

           this.form.reset();
           $("table.order-list2").html('');






    }
    function upload_contract(){
        $("#contract-modal").modal({backdrop: 'static', keyboard: false},'show');

           this.form.reset();







    }

    $("#form").submit(function (e) {
        let formID='form';
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url:"{{ route('rider.store') }}",
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
                $('.data-table').DataTable().ajax.reload();
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




    //upload excelfile
    $(document).ready(function (e) {

        //$("table.order-list").html('');


        var base_url = $('#base_url').val();

        var counter = 0;

    $("#addrow").on("click", function () {
        var item_id = $('#item_id').val();
            var item_price = $('#item_price').val();
            RiderItems(item_id,item_price);
            $('#item_id').val(0);
        $('#item_price').val('');
        counter++;
    });



    $("table.order-list2").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
        counter -= 1
    });





        $("#upload-excel").on("submit",function (e){
            e.preventDefault();
            $.ajax({
                url:"{{ route('rider.import_excel') }}",
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

    $('body').on('click', '.doAction', function () {
        var  url= $(this).data("action");
        x=confirm("Are you sure want to perform this action !");
        if(!x){
            return false;
        }
        let g=$(this);
        $.ajax({
            type: "POST",
            url: url,
            success: function (data) {
                if(data==1) {
                    g.closest('tr').remove();
                    $('.data-table').DataTable().ajax.reload();
                    toastr.success('Action Performed Successfully..');
                }else{
                    toastr.error('Could not performed....!');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    function changeStatus(RID,ob){
        var base_url = $('#base_url').val();
        var url = base_url+'/rider-status';
        x=confirm("Are you sure want to perform this action !");
        if(!x){
            return false;
        }
        let g=$(this);
        var value = ob.value;

        $.ajax({
            type: "POST",
            url: url,
            data:{id:RID,status:value},
            success: function (data) {
                if(data==1) {
                    g.closest('tr').remove();
                    $('.data-table').DataTable().ajax.reload();
                    toastr.success('Action Performed Successfully..');
                }else{
                    toastr.error('Could not performed....!');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }


function RiderItems(item_id,item_price){
    var base_url = $('#base_url').val();

    var newRow = $('<tr>');

            $.get(base_url+'/item-list?item_id='+item_id+'&item_price='+item_price).done(function(data){
            newRow.append(data);
        });

      /*   alert(cols);

        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>'; */
        //newRow.append(cols);
        $("table.order-list2").append(newRow);

}



function addItemWithPrice(){
    $('#item_id').val();
    $('#ktem_price').val();


}
</script>
