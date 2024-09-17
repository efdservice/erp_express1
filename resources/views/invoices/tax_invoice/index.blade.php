
                <form action="{{url('invoices/tax_invoice')}}" method="post" enctype="multipart/form-data" target="_blank">
@csrf

    <div class="row mb-5">

        <div class="col-md-4">
            <label>Project</label>
            <select class="form-control form-control-sm select2" name="PID">
             {!! App\Models\Projects::dropdown() !!}
            </select>
        </div>
        <div class="col-md-4">
            <label>Biling Month</label>
                <input type="month" value="{{date('Y-m')}}" name="billing_month" class="form-control form-control-sm" />
        </div>

    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="save_rec btn btn-primary save_rec">Generate Tax Invoice</button>
                </div>
            </form>
