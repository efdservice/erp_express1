<div class="modal fade" id="modal-new">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <form id="form">
                <input type="hidden" name="id" value="0">
            <div class="modal-header rounded-0 bg-gradient-gray">
                <h4 class="modal-title">Vendor Details:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Vendor Code</label>
                        <input type="text" class="form-control form-control-sm" name="code" placeholder="Vendor Code" disabled>
                    </div>
                    <!--col-->
                    <div class="col-md-6 form-group">
                        <label>Vendor Name</label>
                        <input type="text" class="form-control form-control-sm" name="name" placeholder="Vendor Name">
                    </div>
                    <!--col-->
                    <div class="col-md-6 form-group">
                        <label>Vendor Contact</label>
                        <input type="text" class="form-control form-control-sm" name="contact" placeholder="Vendor Contact">
                    </div>
                    <!--col-->
                    <div class="col-md-6 form-group">
                        <label>Email</label>
                        <input type="text" class="form-control form-control-sm" name="email" placeholder="Vendor Email">
                    </div>
                    <!--col-->
                    <div class="col-md-6 form-group">
                        <label>Attach Documents</label>
                        <input type="file" multiple class="form-control form-control-sm" name="attach_documents[]">
                    </div>
                    <!--col-->
                    <div class="col-md-12 form-group">
                        <label>Address</label>
                        <input type="text" class="form-control form-control-sm" name="vendor_address" placeholder="Vendor Address">
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
