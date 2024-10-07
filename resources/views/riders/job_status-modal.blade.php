
                <form action="{{url('riders/job_status',@$rider->id)}}" method="post" enctype="multipart/form-data" id="formajax2">
@csrf
<input type="hidden" id="reload_page" value="1" />
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Job Status <span style="color:red;">*</span></label>
                                        <select class="form-control form-control-sm select2" name="job_status">
                                            <option value="">Select</option>
                                            @foreach(App\Helpers\CommonHelper::JobStatus() as $key=>$value)
                                            <option value="{{$key}}"@if(@$result['status']==$key)selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                            </div>
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea rows="5" name="reason" class="form-control"></textarea>
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="save_rec btn btn-primary save_rec">Upload</button>
                </div>
            </form>
