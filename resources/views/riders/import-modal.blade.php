<div class="modal fade" id="excel-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="upload-excel" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Upload Riders
                        <a style="font-size: 12px;" href="{{ URL::asset('public/excel_samples/rider_invoice.xlsx') }}" download>Download Sample</a> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Upload File</label>
                                <input name="file" class="form-control form-control-sm" type="file">
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="save_rec btn btn-primary save_rec">Upload</button>
                    <button class="btn btn-primary btn-sm loader" type="button" disabled style="display: none">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </button>
                    <button type="submit"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
