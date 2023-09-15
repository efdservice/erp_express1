<div class="modal fade" id="modal-new">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-0">
            <form id="form">
                
                <input type="hidden" name="id" value="0">
            <div class="modal-header bg-gradient-gray rounded-0">
                <h4 class="modal-title">Rider Details:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
               
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label>Rider ID*</label>
                        <input type="text" class="form-control form-control-sm" name="rider_id" placeholder="Vendor Code">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Rider Name *</label>
                        <input type="text" class="form-control form-control-sm" name="name" placeholder="Vendor Name">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Rider Contact</label>
                        <input type="text" class="form-control form-control-sm" name="personal_contact" placeholder="Vendor Contact">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Vendor</label>
                        <select class="form-control form-control-sm" name="VID">
                            <option value="">Select</option>
                            {!! \App\Models\Vendor::dropdown() !!}
                        </select>
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Company Contact</label>
                        <input type="text" class="form-control form-control-sm" name="company_contact" placeholder="Company Contact">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Personal Gmail ID *</label>
                        <input type="text" class="form-control form-control-sm" name="personal_email" placeholder="Vendor Email">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Email</label>
                        <input type="text" class="form-control form-control-sm" name="email" placeholder="Person Email">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Nationality</label>
                        <select class="form-control form-control-sm" name="nationality">
                            <option value="">Select</option>
                            {!! \App\Models\Country::dropdown() !!}
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Visa Sponsor</label>
                        <input type="text" class="form-control form-control-sm" name="visa_sponsor" placeholder="Visa Sponsor">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Occupation on Visa</label>
                        <input type="text" class="form-control form-control-sm" name="visa_occupation" placeholder="Occupation on Visa" >
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Visa Status</label>
                        <input type="text" class="form-control form-control-sm" name="visa_status" placeholder="Visa Status">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>NF DID</label>
                        <input type="text" class="form-control form-control-sm" name="NFDID" placeholder="NF DID">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>CDM Deposit ID</label>
                        <input type="text" class="form-control form-control-sm" name="cdm_deposit_id" placeholder="CDM Deposit ID">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Mashreq ID</label>
                        <input type="text" class="form-control form-control-sm" name="mashreq_id" placeholder="Mashreq ID">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Date of Joining</label>
                        <input type="text" class="form-control form-control-sm date" name="doj" placeholder="Date of Joining">
                    </div>
                    <!--col-->
                   
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Project</label>
                        <select class="form-control form-control-sm" name="PID">
                            <option value="">Select Project</option>
                            {!! \App\Models\Projects::dropdown() !!}
                        </select>
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Dept</label>
                        <input type="text" class="form-control form-control-sm dat" name="DEPT" placeholder="Dept">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Ethnicity</label>
                        <select type="text" class="form-control form-control-sm" name="ethnicity">
                            <option value="">Select</option>
                            <option value="Muslim">Muslim</option>
                            <option value="non-Muslim">non-Muslim</option>
                        </select>
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>DOB</label>
                        <input type="text" class="form-control form-control-sm date" name="dob" placeholder="Date of Birth">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Branded Plate Number</label>
                        <input type="text" class="form-control form-control-sm" name="branded_plate_no" placeholder="Branded Plate Number">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Vaccine Status</label>
                        <select class="form-control form-control-sm" name="vaccine_status">
                            <option value="0">Pending</option>
                            <option value="1">Done</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Status</label>
                        <select class="form-control form-control-sm" name="status">
                            <option value="0">Deactive</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                </div>
                {{-- <div class="row bg-light mb-1">
                    <div class="col-md-3 form-group">
                        <label>Emirate (Hub)</label>
                        <input type="text" class="form-control form-control-sm" name="emirate_hub" placeholder="Emirate (Hub)">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Emirate ID</label>
                        <input type="text" class="form-control form-control-sm" name="emirate_id" placeholder="Emirate ID">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>EID EXP Date</label>
                        <input type="text" class="form-control form-control-sm date" name="emirate_exp" placeholder="EID EXP Date">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Attach Document</label>
                        <input type="file"  class="form-control form-control-sm" name="attach_eid">
                    </div>
                </div>
                <div class="row bg-light mb-1">
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Passport *</label>
                        <input type="text" class="form-control form-control-sm" name="passport" placeholder="Passport">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Passport Expiry *</label>
                        <input type="text" class="form-control form-control-sm date" name="passport_expiry" placeholder="Passport Expiry">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Attach Documents</label>
                        <input type="file" multiple class="form-control form-control-sm" name="attach_documents[]">
                    </div>
                </div>
                <div class="row bg-light mb-1">
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Licence No</label>
                        <input type="text" class="form-control form-control-sm" name="license_no" placeholder="License No">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Licence Expiry</label>
                        <input type="text" class="form-control form-control-sm date" name="license_expiry" placeholder="License Expiry">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Attach Documents</label>
                        <input type="file" multiple class="form-control form-control-sm" name="attach_documents[]">
                    </div>
                    <!--col-->
                </div> --}}
                <div class="row">
                    
                    <!--col-->
                    {{-- <div class="col-md-3 form-group">
                        <label>Attach Documents</label>
                        <input type="file" multiple class="form-control form-control-sm" name="attach_documents[]">
                    </div> --}}
                 
                    <!--col-->
                    <div class="col-md-12 form-group">
                        <label>Other Details</label>
                        <textarea style="height: 65px !important;" type="text" class="form-control form-control-sm" name="other_details" placeholder="Other Details"></textarea>
                    </div>
                    <!--col-->
                </div>
                <h3>Assign Price</h3>
                <div class="row pr-5 pl-5" >
                    <table  class="table" style="border-radius:10px;">
    <thead>
        <tr class=" bg-light">
            <td>Select Item</td>
            <td>Enter Price</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
       
        <tr class=" bg-light">
            <td class="col-sm-4">
               
                <select name="item_id" class="form-control form-control-sm" id="item_id"><option value="0">Select Item</option>
                    @php
                        $items = \App\Models\Item::all();
                    @endphp
                  @foreach($items as $item)
                        <option value="{{$item->id}}">{{$item->item_name.' - '.$item->pirce}}</option>
                   @endforeach
               </select>
            </td>
            <td class="col-sm-4">
                <label>Price: </label>
                    <input type="number" step="any" name="item_price" id="item_price" />
            </td>
            <td >
                <input type="button" class="btn btn-lg btn-dark btn-sm btn-block " style="width: 200px;background:#000;" id="addrow" value="Add Item" />
            </td>
           
            {{-- <td class="col-sm-2"><input type="button" class="ibtnDel btn btn-md btn-danger btn-xs"  value="Delete"></td> --}}
        </tr>
    </tbody>
   
</table>
<table id="myTable" class="table order-list">
</table>
                
                      {{--   @php
                            $items = \App\Models\Item::all();
                           
                        @endphp
                        @foreach ($items as $item)
                        @php
                             /* $rider_item = \App\Models\RiderItemPrice::where('item_id',$item->id)
                             ->where('RID',$); */
                        @endphp
                        
                            <div class="col-3 form-group">
                                <label>{{$item->item_name}}(Price: {{$item->pirce}})</label>                                
                            <input type="number" name="items[{{$item->id}}]" id="item-{{$item->id}}" step="any" class="form-control form-control-sm" />
                            </div>
                        @endforeach
                        </div> --}}
                
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
