<script>
    $(function (){
        $("#form input[name~='id']").val(0);
        $('.select2').select2();
        this.form.reset();
        $("table.order-list").html('');
        
    })
    // function save_rec(formUrl,formID){
    //     formData=$("#"+formID).serialize();
    //     let mdl=$("#"+formID).closest('.modal');
    //     let frmId=$("#"+formID);
    //     $.ajax({
    //         url:formUrl,
    //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //         type:"POST",
    //         dataType:"JSON",
    //         data:formData,
    //         beforeSend: function() {
    //             $("#"+formID).find('.save_rec').hide();
    //             $("#"+formID).find('.loader').show();
    //         },
    //         success:function (data) {
    //             $("#"+formID+ " input[name~='id']").val(0);
    //             toastr.success('Operation Successfully..');
    //             document.getElementById(formID).reset();
    //             mdl.modal('hide');
    //             $('.data-table').DataTable().ajax.reload();
    //         },error:function(ajaxcontent) {
    //             if(ajaxcontent.responseJSON.success=='false'){
    //                 toastr.error(ajaxcontent.responseJSON.errors);
    //                 return false;
    //             }
    //             vali=ajaxcontent.responseJSON.errors;
    //             $.each(vali, function( index, value ) {
    //                 $("#"+formID+ " input[name~='" + index + "']").css('border', '1px solid red');
    //                 $("#"+formID+ " select[name~='" + index + "']").parent().find('.select2-container--default .select2-selection--single').css('border','1px solid red');
    //                 toastr.error(value);
    //             });
    //         },
    //         complete: function() {
    //             $("#"+formID).find('.save_rec').show();
    //             $("#"+formID).find('.loader').hide();
    //         },
    //     })
    // }
    //edit any simple cured
    $(function (){
        $("input").on('focus',function (){
            $(this).css('border','1px solid #ced4da');
        });
        $(".select2").on('change',function (){
            $(this).parent().find('.select2-container--default .select2-selection--single').css('border','1px solid #ced4da')
        });
        $("body").on("click", ".editRec",function (){
            let mdl=$(this).attr('data-modalID');
            $("#"+mdl).modal();
            frmId=$("#"+mdl).find('form').attr('id');
            let formUrl=$(this).attr('data-action');
            $.ajax({
                url:formUrl,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    for (i=0; i<Object.keys(data).length; i++){
                        $("#"+frmId+" input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                        $("#"+frmId+" select[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                        $("#"+frmId+" input[id~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                    }
                    $(".select2").select2();
                    $("table.order-list").html('');
                   if(data.items){
                   
                    /* data.items.forEach(item =>{
                        RiderItems(item['item_id'],item['item_price']);
                    }); */
                    Object.entries(data.items).forEach(([key, value]) => {
  
                        RiderItems(key,value.item_price);
                        });
                        
                    
                   }
                }
            })
        });
    });
    $('body').on('click', '.deleteRecord', function () {
        var  url= $(this).data("action");
        x=confirm("Are You sure want to delete !");
        if(!x){
            return false;
        }
        let g=$(this);
        $.ajax({
            type: "DELETE",
            url: url,
            success: function (data) {
                if(data==1) {
                    g.closest('tr').remove();
                    toastr.success('Deleted Successfully..');
                }else{
                    toastr.error('not Delted....!');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
   
</script>
