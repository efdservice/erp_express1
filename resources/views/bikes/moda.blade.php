<div class="modal fade" id="modal-new">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <form id="form">
                <input type="hidden" name="id" value="0">
            <div class="modal-header bg-gradient-gray rounded-0">
                <h4 class="modal-title">Bike Details:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Plate</label>
                        <input type="text" class="form-control form-control-sm" name="plate" placeholder="Vendor Code">
                    </div>
                    <!--col-->
                    <div class="col-md-4 form-group">
                        <label>Chassis Number</label>
                        <input type="text" class="form-control form-control-sm" name="chassis_number" placeholder="Chassis Number">
                    </div>
                    <!--col-->
                    <div class="col-md-4 form-group">
                        <label>Color</label>
                        <input type="text" class="form-control form-control-sm" name="color" placeholder="Bike Color">
                    </div>
                    <!--col-->
                    <div class="col-md-4 form-group">
                        <label>Model</label>
                        <input type="text" class="form-control form-control-sm" name="model" placeholder="Bike Model e.g 2023">
                    </div>
                    <!--col-->
                    <div class="col-md-4 form-group">
                        <label>Model Type</label>
                        <input type="text" class="form-control form-control-sm" name="model_type" placeholder="model_type">
                    </div>
                    <!--col-->
                    <div class="col-md-4 form-group">
                        <label>Engine#</label>
                        <input type="text" class="form-control form-control-sm" name="engine" placeholder="Engine Number">
                    </div>
                    <!--col-->
                    <div class="col-md-4 form-group">
                        <label>Company</label>
                        <input type="text" class="form-control form-control-sm" name="company" placeholder="Company">
                    </div>
                    <!--col-->
                    <div class="col-md-4 form-group" id="rider_select1">
                        <label>Assign to Rider</label>
                        <select class="form-control form-control-sm select2" name="RID">
                            <option value="">Select Rider</option>
                            {!! \App\Models\Rider::dropdown() !!}
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Fleet Supervisor</label>
                        <select class="form-control form-control-sm" name="fleet_supervisor">
                            <option value=""></option>
                            {!! App\Helpers\CommonHelper::get_supervisor() !!}
                        </select>
                    </div>
                    <!--col-->
                    <div class="col-md-4 form-group">
                        <label>Attach Documents</label>
                        <input type="file" multiple class="form-control form-control-sm" name="attach_documents[]">
                    </div>
                    <!--col-->
                    <div class="col-md-12 form-group">
                        <label>Note</label>
                        <input type="text" class="form-control form-control-sm" name="notes" placeholder="Note">
                    </div>
                    <!--col-->
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
