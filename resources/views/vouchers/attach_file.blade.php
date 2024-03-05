<form action="{{url('attach_file/'.$id)}}" method="POST" enctype="multipart/form-data" id="formajax">
<div class="row">
    <div class="col-12 mt-3 mb-3">
        <label class="mb-3 pl-2">Upload Document related to the voucher</label>
        <input type="file" name="attach_file" class="form-control form-control-sm mb-3 bg-light" style="height: 40px;" />

    </div>
</div>
<button type="submit" name="submit" class="btn btn-primary" style="width: 100%;">Upload</button>

</form>