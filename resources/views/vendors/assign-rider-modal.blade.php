<div class="modal fade" id="assign-modal-new">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <form id="ar-form">
                <input type="hidden" name="id" value="0">
                <div class="modal-header rounded-0 bg-gradient-gray">
                    <h4 class="modal-title">Assign Rider to Vendor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Select Vendor</label>
                            <select class="form-control form-control-sm select2" name="VID">
                                <option value="">Select Vendor</option>
                                {!! \App\Models\Vendor::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="col-md-6 form-group">
                            <label>Select Rider</label>
                            <select class="form-control form-control-sm select2" name="RID">
                                <option value="">Select Vendor</option>
                                {!! \App\Models\Rider::dropdown() !!}
                            </select>
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
