    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js" defer></script>
<script type="text/javascript">
    function add_new(){
        $("#modal-new").modal();
    }

    $("#form").submit(function (e) {
        let formID='form';
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url:"{{ route('sim.store') }}",
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
            ajax: "{{ route('sim.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'sim_number', name: 'sim_number'},
                {data: 'sim_company', name: 'sim_company'},
                {data: 'rider_name', name: 'rider_name'},
                {data: 'rider_number', name: 'rider_number'},
                {data: 'action', name: 'action',
                    orderable: false, searchable: false
                },
            ]
        });
    });


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
            url:"{{ route('sim.change_status') }}",
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
    $(document).on("click",".get-sim-id",function () {
            var id=$(this).attr("data-id");
            $("#rider-form input[name~='sim_id']").val(id);
           

            $.ajax({
               url:'{{ url('sim/get_sim_history') }}/'+id,
               type:"GET",
               success:function (data) {
                    var htmlData='';
                    for(i in data){
                        htmlData+='<tr>';
                            htmlData+='<td>'+data[i].rider?.name+'</td>';
                            htmlData+='<td>'+data[i].status+'</td>';
                            htmlData+='<td>'+data[i].note_date+'</td>';
                            htmlData+='<td>'+data[i].notes+'</td>';
                        htmlData+='</tr>';
                    }
                    $("#rider_history").html(htmlData);
               }
            });
    });
</script>
