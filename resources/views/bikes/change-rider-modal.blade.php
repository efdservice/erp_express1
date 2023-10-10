<div class="modal fade" id="change-rider">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-0">
            <form id="rider-form">
                <input type="hidden" name="BID" value="0">
                <div class="modal-header bg-gradient-gray rounded-0">
                    <h4 class="modal-title">Change Status:</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Select Rider</label>
                            <select class="form-control form-control-sm select2" name="RID" id="rider_change">
                                <option value="">--Select--</option>
                                {!! \App\Models\Rider::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Date</label>
                            <input  name="note_date" class="form-control form-control-sm date" placeholder="Date" value="{{ date('Y-m-d') }}">
                        </div>
                        <!--col-->
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Note....." name="notes"></textarea>
                        </div>
                        
                        <!--col-->
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <button type="button" onclick="change_rider()" class="btn btn-primary pull-right save_rec">Save</button>
                    <button class="btn btn-primary loader" type="button" disabled style="display: none">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Saving...
                    </button>
                        </div>
                    </div>
                    <!--row-->
                    <br>
                    <div class="card rounded-0">
                        <div class="card-header bg-gradient-dark">Latest 10 Changes</div>
                        <table class="table">
                            <tr>
                                <th>Rider</th>
                                <th>Date</th>
                                <th>Note</th>
                            </tr>
                            <tbody id="rider_history"></tbody>
                        </table>
                    </div>
                </div>
                <!--modal--body-->
                <div class="modal-footer">
                    
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
