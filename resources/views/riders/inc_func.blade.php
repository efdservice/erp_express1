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


    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('rider.index') }}",
            columns: [
                {data: 'rider_id', name: 'rider_id'},
                {data: 'name', name: 'name'},
                {data: 'personal_contact', name: 'personal_contact'},
                {data: 'personal_email', name: 'personal_email'},
                {data: 'passport', name: 'passport'},
                {data: 'license_no', name: 'license_no'},
                {data: 'action', name: 'action',
                    orderable: false, searchable: false
                },
            ]
        });
    });

    //upload excelfile
    $(document).ready(function (e) {
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


</script>
