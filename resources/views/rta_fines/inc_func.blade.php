<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function add_new() {
        $(".select2").select2();
        $("#new").modal();
        document.getElementById("form").reset();
        $("#form input[name~='id']").val(0);
        $("#new").find('.btn-success').text('Submit');
    }
    $("#form").submit(function (e) {
        $("#loader").show();
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url:"{{ route('rta_fine.store') }}",
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
    get_data();
    function get_data(page){
        $("#loader").show();
        $.ajax({
            url:"{{ url('get_rta_fine') }}?page="+page,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:"POST",
            dataType:"JSON",
            success:function (data) {
                htmlData='';
                for(i in data.data){
                    htmlData+='<tr id="'+data.data[i].trans_code+'">';
                    htmlData+='<td>'+(Number(i)+1)+'</td>';
                    htmlData+='<td>'+data.data[i].trans_code+'</td>';
                    htmlData+='<td>'+data.data[i].trans_date+'</td>';
                    htmlData+='<td>'+data.data[i].other_detailse+'</td>';
                    htmlData+='<td>'+data.data[i].amount+'</td>';
                    if(data.data[i].attach_file==null){
                        htmlData += '<td>N/A</td>';
                    }else {
                        htmlData += '<td><a  class="btn btn-success btn-xs" href="' + data.data[i].attach_file + '" download><i class="fa fa-download"></i> Attached Document</a></td>';
                    }
                    htmlData+='<td>';
                    htmlData+=' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\''+data.data[i].trans_code+'\', \'{{ url('rta_fine') }}/'+data.data[i].trans_code+'\')"><i class="fa fa-trash"></i> </a>';
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
        $("#new").modal();
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
        $.ajax({
            url: "{{ url('Accounts/vouchers/fetch_invoices') }}/"+id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                $("#fetchRiderInv").html(data.htmlData);
            }
        })
    }
    //upload excelfile
    $(document).ready(function (e) {
        $("#upload-excel").on("submit",function (e){
            e.preventDefault();
            $.ajax({
                url:"{{ route('rta_fine.import_excel') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
                    get_data();
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

        $("#bike-plate").on("change",function () {
            let id=$(this).val();
            $.ajax({
                url: "{{ url('bike/fetch_vendor_comp') }}/"+id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $(".rider").val(data.rider);
                    $(".vendor").val(data.vendor);
                    $(".select2").select2();
                }
            })
        })
    });
</script>
