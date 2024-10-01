<div class="modal fade" id="modal-new">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <form id="form">
                <input type="hidden" name="id" value="0">
            <div class="modal-header bg-gradient-gray rounded-0">
                <h4 class="modal-title">Project Details:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Project Name</label>
                        <input type="text" class="form-control form-control-sm" name="name" placeholder="Project Name...">
                    </div>
                    <!--col-->
                    <div class="col-md-6 form-group">
                        <label>Company Name</label>
                        <input type="text" class="form-control form-control-sm" name="company_name" placeholder="Company Name">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Company Email</label>
                        <input type="text" class="form-control form-control-sm" name="company_email" placeholder="Company Email">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Contact Number</label>
                        <input type="text" class="form-control form-control-sm" name="contact_number" placeholder="Contact Number">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address</label>
                        <input type="text" class="form-control form-control-sm" name="address" placeholder="Address">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Tax Number</label>
                        <input type="text" class="form-control form-control-sm" name="tax_number" placeholder="Tax Number">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Tax Percentage %</label>
                        <input type="text" class="form-control form-control-sm" name="tax_percentage" placeholder="Tax Percentage">
                    </div>


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
