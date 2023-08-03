<div class="modal fade" id="change-rider">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-0">
            <form id="rider-form">
                <input type="hidden" name="BID" value="0">
                <div class="modal-header bg-gradient-gray rounded-0">
                    <h4 class="modal-title">Change Rider:</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Select Rider</label>
                            <select class="form-control form-control-sm select2" name="RID">
                                <option value="">--Select--</option>
                                {!! \App\Models\Rider::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Note....." name="notes"></textarea>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    <br>
                    <div class="card rounded-0">
                        <div class="card-header bg-gradient-blue"><h5>Rider History</h5></div>
                        <table class="table">
                            <tr>
                                <th>Assign Rider</th>
                                <th>Assigned Date</th>
                            </tr>
                            <tbody id="rider_history"></tbody>
                        </table>
                    </div>
                </div>
                <!--modal--body-->
                <div class="modal-footer">
                    <button type="button" onclick="change_rider()" class="btn btn-primary pull-right save_rec btn-sm">Change</button>
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
