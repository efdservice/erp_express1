    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js" defer></script>
<script type="text/javascript">
    function add_new(){
        $("#modal-new").modal({backdrop: 'static', keyboard: false},'show');
        $("#rider_select1").show("fast");
    }

    $("#form").submit(function (e) {
        let formID='form';
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url:"{{ route('bike.store') }}",
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
            ajax: "{{ route('bike.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'rider_name', name: 'rider_name'},
                {data: 'vendor_name', name: 'vendor_name'},
                {data: 'sim_number', name: 'sim_number'},
                {data: 'plate', name: 'plate'},
                {data: 'fleet_supervisor', name: 'fleet_supervisor'},
                {data: 'project_name', name: 'project_name'},
                {data: 'bike_status', name: 'bike_status'},
                {data: 'company', name: 'company'},
                {data: 'action', name: 'action',
                    orderable: false, searchable: false
                },
            ]
        });
    });
    /*
    change rider
     */

   function bike_status() {
       var status = $('.warehouse').find(":selected").val();
       if(status == 'Active'){
        $("#rider_select").show("fast");
       }else{
        $("#rider_select").hide("fast");
       }
    }

    function change_rider() {
        var formID='rider-form';
        $.ajax({
            url:"{{ route('bike.change_rider') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            data: $("#rider-form").serialize(),
            beforeSend: function() {
                $("#"+formID).find('.save_rec').hide();
                $("#"+formID).find('.loader').show();
            },
            success:function (data) {
                $("#"+formID+ " input[name~='BID']").val(0);
                toastr.success('Operation Successfully..');
                document.getElementById(formID).reset();
                $("#change-rider").modal('hide');
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
    }

    $(document).on("click",".get-bike-id",function () {
            var id=$(this).attr("data-id");
            var rider=$(this).attr("data-rider");
            $("#rider-form input[name~='BID']").val(id);
            $("#rider-form select[name~='RID']").val(rider);


            $.ajax({
               url:'{{ url('bike/get_bike_history') }}/'+id,
               type:"GET",
               success:function (data) {
                    var htmlData='';
                    for(i in data){
                        let rider = 'No Active Rider';
                        let note = '';
                        if(data[i].rider?.name){
                            rider = data[i].rider?.name;
                        }
                        if(data[i].rider?.notes){
                            note = data[i].rider?.notes;
                        }

                        htmlData+='<tr>';
                            htmlData+='<td>'+rider+'<br/>'+note+'</td>';
                            htmlData+='<td>'+data[i].warehouse+'</td>';
                            htmlData+='<td>'+data[i].note_date+'</td>';
                            if(data[i].warehouse =='Active'){
                                htmlData+='<td><small><a href="'+$("#base_url").val()+'/bike/contract/'+data[i].id+'" target="_blank">Print Contract</a> | ';
                                    if(data[i].contract){
                                htmlData+='<a href="{{ Storage::url("app/contract/")}}'+data[i].contract+'" target="_blank">Signed Contract</a><br/>';
                                    }
                                    htmlData+='<form action="'+$("#base_url").val()+'/bike/contract_upload" method="post" enctype="multipart/form-data"><b>Upload Signed Contract</b><br/><input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"><input type="hidden" name="id" value="'+data[i].id+'" /><input type="file" name="contract" required="required" /><button type="submit"  class="border-0 bg-primary">Upload</button></form></small></td>';
                            }
                        htmlData+='</tr>';
                    }
                    $("#rider_history").html(htmlData);
               }
            });
    });




</script>
