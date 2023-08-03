<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js" defer></script>
<script type="text/javascript">
    $(function () {
       $(".select2").select2();
    });
    function add_new(){
        $("#modal-new").modal({
            backdrop: 'static',
            keyboard: false
        });
        document.getElementById('form').reset();
        $(".item_line_one").show();
        $(".rider_append").html('');
        $("#form input[name~='id']").val(0);
    }

    $("#form").submit(function (e) {
        let formID='form';
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url:"{{ route('item.store') }}",
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
            ajax: "{{ route('item.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'item_name', name: 'item_name'},
                {data: 'item_unit', name: 'item_unit'},
                {data: 'pirce', name: 'pirce'},
                {data: 'cost_price', name: 'cost_price'},
                {data: 'descriptions', name: 'descriptions'},
                {data: 'action', name: 'action',
                    orderable: false, searchable: false
                },
            ]
        });
    });
    /*
    clone rider
     */
    $(document).on("click",".rider_line",function () {
            $('.rider_append').append('<div class="row">\n' +
                '    <div class="col-md-3 form-group">\n' +
                '        <select class="form-control form-control-sm select2 selected_riders" onchange="fetch_vendor(this)" name="RID[]">\n' +
                '            <option value="">Select Rider</option>\n' +
                '            {!! \App\Models\Rider::dropdown() !!}\n' +
                '        </select>\n' +
                '    </div>\n' +
                '    <!--col-->\n' +
                '    <div class="col-md-2 form-group">\n' +
                '        <input type="text" class="form-control form-control-sm" name="price[]" placeholder="Assign Price">\n' +
                '    </div>\n' +
                '    <!--col-->\n' +
                '<div class="col-md-3 form-group">'+
                  '  <select class="form-control form-control-sm select2 select_vendor" name="VID[]">'+
                  '  <option value="">Select Vendor</option>'+
                  '  {!! \App\Models\Vendor::dropdown() !!}'+
                '</select>'+
                '</div>'+
                '<!--col-->'+
                '<div class="col-md-2 form-group">'+
                '<input type="text" class="form-control form-control-sm" name="vendor_price[]" placeholder="Assign Price">'+
                '    </div>'+
                '<!--col-->'+
                '    <div class="col-md-2 form-group">\n' +
                '        <button type="button" class="btn btn-sm btn-danger remove"><i class="fa fa-trash"></i> </button>\n' +
                '    </div>\n' +
                '    <!--col-->\n' +
                '</div>\n' +
                '<!--row-->');
        $(".select2").select2();
    })
    /*
    clone Vendor
     */
    {{--$(".vendor_line").click(function () {--}}
    {{--        $('.vendor_append').append('<div class="row">\n' +--}}
    {{--            '    <div class="col-md-5 form-group">\n' +--}}
    {{--            '        <select class="form-control form-control-sm select2" name="VID[]">\n' +--}}
    {{--            '            <option value="">Select Vendor</option>\n' +--}}
    {{--            '            {!! \App\Models\Vendor::dropdown() !!}\n' +--}}
    {{--            '        </select>\n' +--}}
    {{--            '    </div>\n' +--}}
    {{--            '    <!--col-->\n' +--}}
    {{--            '    <div class="col-md-5 form-group">\n' +--}}
    {{--            '        <input type="text" class="form-control form-control-sm" name="vendor_price[]" placeholder="Assign Price">\n' +--}}
    {{--            '    </div>\n' +--}}
    {{--            '    <!--col-->\n' +--}}
    {{--            '    <div class="col-md-2 form-group">\n' +--}}
    {{--            '        <button type="button" class="btn btn-sm btn-danger remove"><i class="fa fa-trash"></i> </button>\n' +--}}
    {{--            '    </div>\n' +--}}
    {{--            '    <!--col-->\n' +--}}
    {{--            '</div>\n' +--}}
    {{--            '<!--row-->');--}}
    {{--    $(".select2").select2();--}}
    {{--});--}}
   $(document).on("click",".remove",function () {
        $(this).closest('.row').remove();
   });
    /*
    fethc vendor against rider
     */
    {{--function fetch_vendor(g) {--}}
    {{--    let RID=$(g).val();--}}
    {{--    var g=$(g);--}}
    {{--    $.ajax({--}}
    {{--        url:"{{ route('item.fetch_vendor') }}",--}}
    {{--        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},--}}
    {{--        type:"POST",--}}
    {{--        data: {'id':RID},--}}
    {{--        success:function (data) {--}}
    {{--           g.closest('.row').find(".select_vendor").val(data.VID);--}}
    {{--           $(".select2").select2();--}}
    {{--        }--}}
    {{--    });--}}
        function fetch_rider(g) {
        let VID=$(g).val();
        var g=$(g);
        $.ajax({
            url:"{{ route('item.fetch_rider') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            data: {'id':VID},
            success:function (data) {
               $(".rider_append").html(data);
               $(".select2").select2();
                price=$("#items").find("option:selected").attr("data-price");
                var sp=price.split('~')[0];
                var cp=price.split('~')[1];
                $(".sp").val(sp);
                $(".cp").val(cp);

            }
        });
        // $(".selected_riders").each(function () {
        //         if($(this).val()==RID){
        //             alert("alredy Exist");
        //         }
        // })
    }
    /*
    edit item function
     */
    $(function () {
        $("body").on("click", ".editItem",function (){
            $('.rider_append').html('');
            $("#loader").show();
            $(".item_line_one").hide();
            let mdl=$(this).attr('data-modalID');
            var cln=$(this).attr("data-item");
            $("#"+mdl).modal({
                backdrop: 'static',
                keyboard: false
            });
            frmId=$("#"+mdl).find('form').attr('id');
            let formUrl=$(this).attr('data-action');
            $.ajax({
                url:formUrl,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    for (i=0; i<Object.keys(data.result).length; i++){
                        $("#"+frmId+" input[name~='"+Object.keys(data.result)[i]+"']").val(Object.values(data.result)[i]);
                        $("#"+frmId+" input[name~='sale_price'").val(data.result.pirce);
                        $("#"+frmId+" select[name~='"+Object.keys(data.result)[i]+"']").val(Object.values(data.result)[i]);
                    }
                    $(".select2").select2();
                },
                complete: function() {
                    if(cln=="clone"){
                        $("#form input[name~='id']").val(0);
                    }
                    $("#loader").hide();
                },
            });
        });
    });

    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('.data-table2').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('item.assign_price') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'vendors.name', name: 'vendors.name'},
                {data: 'items.item_name', name: 'items.item_name'},
                {data: 'items.pirce', name: 'items.pirce'},
                {data: 'action', name: 'action',
                    orderable: false, searchable: false
                },
            ]
        });
    });
</script>
