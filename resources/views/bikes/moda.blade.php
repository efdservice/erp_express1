<div class="modal fade" id="modal-new">
    <div class="modal-dialog modal-lg">
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
                        <label>Traffic File No.</label>
                        <input type="text" class="form-control form-control-sm" name="traffic_file_number" placeholder="Traffic File Number">
                    </div>
                    <!--col-->
                    <div class="col-md-4 form-group">
                        <label>Emirates</label>
                        <input type="text" class="form-control form-control-sm" name="emirates" placeholder="Emirates">
                    </div>
                    <!--col-->
                    <div class="col-md-4 form-group">
                        <label>Company</label>
                        <select class="form-control form-control-sm select2" name="company">
                            <option value="">Select Rider</option>
                            {!! \App\Models\LeaseCompany::dropdown() !!}
                        </select>
                    </div>
                    <!--col-->
                    {{-- <div class="col-md-4 form-group" id="rider_select1">
                        <label>Assign to Rider</label>
                        <select class="form-control form-control-sm select2" name="RID">
                            <option value="">Select Rider</option>
                            {!! \App\Models\Rider::dropdown() !!}
                        </select>
                    </div> --}}
                    <div class="col-md-4 form-group">
                        <label>Fleet Supervisor</label>
                        <select class="form-control form-control-sm" name="fleet_supervisor">
                            <option value=""></option>
                            {!! App\Helpers\CommonHelper::get_supervisor() !!}
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Code</label>
                        <input type="text" class="form-control form-control-sm" name="bike_code" placeholder="Code">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Registration Date</label>
                        <input type="date" class="form-control form-control-sm" name="registration_date" placeholder="Registration Date">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Expiry Date</label>
                        <input type="date" class="form-control form-control-sm" name="expiry_date" placeholder="Expiry Date">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Insurance Expiry</label>
                        <input type="date" class="form-control form-control-sm" name="insurance_expiry" placeholder="Insurance Expiry">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Insurance Co.</label>
                        <input type="text" class="form-control form-control-sm" name="insurance_co" placeholder="Insurance Co.">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Policy No.</label>
                        <input type="text" class="form-control form-control-sm" name="policy_no" placeholder="Policy No.">
                    </div>
                    <div class="col-md-4 form-group">&nbsp;</div>
                    <!--col-->
                    <div class="col-md-6 form-group">
                        <label>Bike Mulkiya Document</label>
                        <input type="file"  class="form-control form-control-sm" name="attach_documents[bike_mulkiya]">
                    </div>
                    <div class="col-md-6 form-group">
                        <span id="bike_mulkiya"></span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label> RTA Advertising Permit Document</label>
                        <input type="file"  class="form-control form-control-sm" name="attach_documents[rta_advertising_permit]">
                    </div>
                    <div class="col-md-6 form-group">
                        <span id="rta_advertising_permit"></span>
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
