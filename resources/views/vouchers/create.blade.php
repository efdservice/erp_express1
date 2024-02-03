

            {!! Form::open(['route' => 'vouchers.store', 'id'=>'formajax']) !!}


                <div class=" p-3">
                    @include('vouchers.fields')
                </div>


            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
<script>
    $(document).ready(function(){
    getTotal();
});
    $(document).on("click", ".new_line", function () {
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
`);
    $(".select2").select2();
});

</script>