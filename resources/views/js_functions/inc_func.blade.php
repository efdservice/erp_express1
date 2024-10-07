<script>
    $(function (){
        $("#form input[name~='id']").val(0);
        $('.select2').select2();
        //this.form.reset();
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
            let data = null;
            $.ajax({
                url:formUrl,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    for (i=0; i<Object.keys(data).length; i++){
                        $("#"+frmId+" textarea[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                        $("#"+frmId+" input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                        $("#"+frmId+" select[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                        $("#"+frmId+" input[id~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);


                    }
                    $(".select2").select2();
                    $("table.order-list").html('');
                   if(data.items){

                        Object.entries(data.items).forEach(([key, value]) => {

                        RiderItems(key,value.item_price);
                        });

                   }

                    $("#bike_mulkiya").html('');
                    $("#rta_advertising_permit").html('');

                    if(data.attach_documents){
                            let files = JSON.parse(data.attach_documents);

                                if(files.bike_mulkiya != null){
                                    $("#bike_mulkiya").html("<a href='{{ Storage::url('app/')}}"+files.bike_mulkiya+"' target='_blank'>View Document</a>");
                                }
                                if(files.rta_advertising_permit != null){
                                    $("#rta_advertising_permit").html("<a href='{{ Storage::url('app/')}}"+files.rta_advertising_permit+"' target='_blank'>View Document</a>");
                                }


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
                    toastr.error('Not Deleted....!');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

$('body').on('click', '.show-modal', function () {
  var action = $(this).data('action');
  var title = $(this).data('title');
  var size = $(this).data('size');
  if (size) {
    $('.modal-dialog').addClass('modal-' + size);
  }
  $('#modalTopbody').load(action, function () {
    $("#loader").hide();
 });

  $('#modalTopTitle').text(title);

  $('#modalTop').modal('show');
  $("#loader").show();

});

$(document).on('submit', '#formajax', function (e) {
  e.preventDefault();
  $("#loader").show();

  let formID = 'formajax';
  var action = $(this).attr('action');

  var formData = new FormData(this);
  $.ajax({
    url: action,
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    type: 'POST',
    data: formData,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function () {
      $('#' + formID)
        .find('.save_rec')
        .hide();
      $('#' + formID)
        .find('.loader')
        .show();
    },
    success: function (data) {
        $("#loader").hide();
      toastr.success('Action performed successfully.');
      $('#modalTop').modal('hide');

      if ($('#reload_page').val() == 1) {
        location.reload();
      }
      if ($('#edit_redirect').val() == 1) {
        location.href = "{{url('rider/')}}/"+data.id+"/edit";
      }
      if ($('#redirect_to').val()) {
        location.href = $('#redirect_to').val();
      }

      $('.data-table').DataTable().ajax.reload(null, false);
      get_data();
    },
    error: function (ajaxcontent) {
        $("#loader").hide();
      if (ajaxcontent.responseJSON.success == 'false') {
        //toastr.error(ajaxcontent.responseJSON.errors);
        return false;
      }
      vali = ajaxcontent.responseJSON.errors;
      $('#' + formID + ' input').css('border', '1px solid #dfdfdf');
      $('#' + formID + ' input')
        .next('span')
        .remove();

      $.each(vali, function (index, value) {
        $('#' + formID + " input[name~='" + index + "']").css('border', '1px solid red');
        //$('#' + formID + " input[name~='" + index + "']").after('<span style="color:red;">' + value + '</span>');
        $('#' + formID + " select[name~='" + index + "']")
          //.parent()
          //.find('.select2-container--default .select2-selection--single')
          .css('border', '1px solid red');
        toastr.error(value);
      });

      $('#dataTableBuilder').DataTable().ajax.reload();
    },
    complete: function () {
      $('#' + formID)
        .find('.save_rec')
        .show();
      $('#' + formID)
        .find('.loader')
        .hide();
    }
  });
});

$(document).on('submit', '#formajax2', function (e) {
  e.preventDefault();
  $("#loader").show();

  let formID = 'formajax2';
  var action = $(this).attr('action');

  var formData = new FormData(this);
  $.ajax({
    url: action,
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    type: 'POST',
    data: formData,
    contentType: false,
    cache: false,
    processData: false,
    success: function (data) {
        $("#loader").hide();
      toastr.success(data);
      if ($('#reload_page').val() == 1) {
        location.reload();
      }

    },
    error: function (ajaxcontent) {
        $("#loader").hide();
      if ($('#card').val() == 1) {
        $("#loader").hide();
      }
      if (ajaxcontent.responseJSON.success == 'false') {
        //toastr.error(ajaxcontent.responseJSON.errors);
        return false;
      }
      vali = ajaxcontent.responseJSON.errors;
      $('#' + formID + ' input').css('border', '1px solid #dfdfdf');
      $('#' + formID + ' input')
        .next('span')
        .remove();

      $.each(vali, function (index, value) {
        $('#' + formID + " input[name~='" + index + "']").css('border', '1px solid red');
        //$('#' + formID + " input[name~='" + index + "']").after('<span style="color:red;">' + value + '</span>');
        $('#' + formID + " select[name~='" + index + "']")
          //.parent()
          //.find('.select2-container--default .select2-selection--single')
          .css('border', '1px solid red');
        toastr.error(value);
      });

      $('#dataTableBuilder').DataTable().ajax.reload();
    }
  });
});


</script>
