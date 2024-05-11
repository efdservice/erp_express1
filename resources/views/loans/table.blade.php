<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

<table class="table table-hover data-table text-nowrap">
   <thead>
   <tr>
       <th>#</th>
       <th>Rider Id</th>
       <th>Amount</th>
       <th>Purpose</th>
       <th>Terms</th>
       <th>Issue Date</th>
       <th>Due Date</th>
       <th>Status</th>
       <th>Created By</th>
           <th colspan="3">Action</th>
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
           ajax: "{{ route('loans.index') }}",
           columns: [
               {data: 'id', name: 'id'},
               {data: 'rider_id', name: 'rider_id'},
               {data: 'amount', name: 'amount'},
               {data: 'purpose', name: 'purpose'},
               {data: 'terms', name: 'terms'},
               {data: 'issue_date', name: 'issue_date'},
               {data: 'due_date', name: 'due_date'},
               {data: 'status', name: 'status'},
               {data: 'created_by', name: 'created_by'},
/*                {data: 'attach_file', name: 'Document', orderable: true, searchable: false},
 */               {data: 'action', name: 'action',
                   orderable: true, searchable: false
               },
           ]
       });
   });
</script>
