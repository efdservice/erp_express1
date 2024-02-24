
 <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

 <table class="table table-hover data-table text-nowrap">
    <thead>
    <tr>
        <th>#</th>
        <th>Trans Date</th>
        <th>Trans Code</th>
        <th>Billing Month</th>
        <th>Voucher Type</th>
        <th>Amount</th>
        <th>Created By</th>
        <th>Updated By</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js" defer></script>
<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: false,
            ajax: "{{ route('vouchers.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'trans_date', name: 'trans_date'},
                {data: 'trans_code', name: 'trans_code'},
                {data: 'billing_month', name: 'billing_month'},
                {data: 'voucher_type', name: 'voucher_type'},
                {data: 'amount', name: 'amount'},
                {data: 'Created_By', name: 'Created_By'},
                {data: 'Updated_By', name: 'Updated_By'},
                {data: 'action', name: 'action',
                    orderable: true, searchable: false
                },
            ]
        });
    });
</script>