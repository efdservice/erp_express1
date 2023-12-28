<div class="modal fade" id="modal-new">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <form id="form">
                <input type="hidden" name="id" value="0">
            <div class="modal-header bg-gradient-gray rounded-0">
                <h4 class="modal-title">Sim Details:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Sim Number</label>
                        <input type="text" class="form-control form-control-sm" name="sim_number" placeholder="Sim Number...">
                    </div>
                    <!--col-->
                    <div class="col-md-6 form-group">
                        <label>Sim Company</label>
                        <input type="text" class="form-control form-control-sm" name="sim_company" placeholder="Sim Company">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>EMI</label>
                        <input type="text" class="form-control form-control-sm" name="sim_emi" placeholder="Sim EMI">
                    </div>
                   {{--  <div class="col-md-6 form-group">
                        <label>Select Vendor</label>
                        <select class="form-control form-control-sm select2" name="sim_vendor">
                            <option value="">Select Vendor</option>
                            {!! \App\Models\Vendor::dropdown() !!}
                        </select>
                    </div> --}}
                    <!--col-->
                    <div class="col-md-6 form-group">
                        <label>Select Rider</label>
                        <select class="form-control form-control-sm select2" name="assign_sim">
                            <option value="">Select Rider</option>
                            {!! \App\Models\Rider::dropdown() !!}
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Fleet Supervisor</label>
                        <select class="form-control form-control-sm" name="fleet_supervisor">
                            <option value=""></option>
                            {!! App\Helpers\CommonHelper::get_supervisor() !!}
                        </select>
                    </div>
                    <!--col-->
{{--                    <div class="col-md-4 form-group">--}}
{{--                        <label>Attach Documents</label>--}}
{{--                        <input type="file" multiple class="form-control form-control-sm" name="attach_documents[]">--}}
{{--                    </div>--}}
                    <!--col-->
{{--                    <div class="col-md-12 form-group">--}}
{{--                        <label>Note</label>--}}
{{--                        <input type="text" class="form-control form-control-sm" name="notes" placeholder="Note">--}}
{{--                    </div>--}}
{{--                    <!--col-->--}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary pull-right save_rec btn-sm">Save</button>
                <button class="btn btn-primary btn-sm loader" type="button" disabled style="display: none">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Saving...
                </button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
