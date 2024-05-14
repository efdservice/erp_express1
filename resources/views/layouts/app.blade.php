<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Express-Fast | @yield('title')</title>
	<link rel="icon" type="image/x-icon" href="{{ URL::asset('public/dist/img/favicon.ico') }}"/>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Font Awesome -->
	{{--<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>--}}
	<link rel="stylesheet" href="{{ URL::asset('public/plugins/fontawesome-free/css/all.min.css') }}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ URL::asset('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="{{ URL::asset('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
	<!-- iCheck -->
	<link rel="stylesheet" href="{{ URL::asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
	<!-- JQVMap -->
	<link rel="stylesheet" href="{{ URL::asset('public/plugins/jqvmap/jqvmap.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ URL::asset('public/dist/css/adminlte.min.css') }}">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="{{ URL::asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="{{ URL::asset('public/plugins/daterangepicker/daterangepicker.css') }}">
	<!-- summernote -->
	<link rel="stylesheet" href="{{ URL::asset('public/plugins/summernote/summernote-bs4.css') }}">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="stylesheet" href="{{ URL::asset('public/dist/css/style.css') }}">
	<!-- Select2 -->
	<link rel="stylesheet" href="{{ URL::asset('public/plugins/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('public/dist/css/toastr.min.css') }}">
	<!-- summernote -->
	<link rel="stylesheet" href="{{ URL::asset('public/plugins/summernote/summernote-bs4.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed text-sm">
	<input type="hidden" name="base_url" id='base_url' value="{{url('/')}}" />
        {{--<div class="loader-bg">--}}
				{{--<div class="loader-bar">--}}
				{{--</div>--}}
		{{--</div>--}}
		@include('loader')
        <div class="wrapper">
           @include('layouts.navbar')
           @include('layouts.aside')


		   @yield('content')

		   @include('partials.modal')


			<footer class="main-footer">
				<strong>Copyright &copy; 2021 <a href="#">Express-Fast</a>.</strong>
				All rights reserved.
				<div class="float-right d-none d-sm-inline-block">
					<b>Version</b> 0.0.1
				</div>
			</footer>
			<!-- Control Sidebar -->
			<aside class="control-sidebar control-sidebar-dark">
				<!-- Control sidebar content goes here -->
			</aside>
			<!-- /.control-sidebar -->
    </div><!--wrapper-->
		<!-- jQuery -->
		<script src="{{ URL::asset('public/plugins/jquery/jquery.min.js') }}"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="{{ URL::asset('public/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
            $.widget.bridge('uibutton', $.ui.button)
		</script>
		<!-- Select2 -->
		<script src="{{ URL::asset('public/plugins/select2/js/select2.full.min.js') }}" defer></script>
		<!-- Bootstrap 4 -->
		<script src="{{ URL::asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<!-- ChartJS -->
		<script src="{{ URL::asset('public/plugins/chart.js/Chart.min.js') }}"></script>
		<!-- Sparkline -->
		<script src="{{ URL::asset('public/plugins/sparklines/sparkline.js') }}"></script>
		<!-- JQVMap -->
		<script src="{{ URL::asset('public/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
		<script src="{{ URL::asset('public/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
		<!-- jQuery Knob Chart -->
		<script src="{{ URL::asset('public/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
		<!-- daterangepicker -->
		<script src="{{ URL::asset('public/plugins/moment/moment.min.js') }}"></script>
		<script src="{{ URL::asset('public/plugins/daterangepicker/daterangepicker.js') }}"></script>
		<!-- Tempusdominus Bootstrap 4 -->
		<script src="{{ URL::asset('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
		<!-- Summernote -->
		<script src="{{ URL::asset('public/plugins/summernote/summernote-bs4.min.js') }}"></script>
		<!-- overlayScrollbars -->
		<script src="{{ URL::asset('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
		<!-- AdminLTE App -->
		<script src="{{ URL::asset('public/dist/js/adminlte.js') }}"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<script src="{{ URL::asset('public/dist/js/pages/dashboard.js') }}"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="{{ URL::asset('public/dist/js/demo.js') }}"></script>
		<script src="{{ URL::asset('public/js/inc.func.js') }}"></script>
		<script src="{{ URL::asset('public/dist/js/toastr.min.js') }}"></script>
		<script src="{{ URL::asset('public/plugins/summernote/summernote-bs4.min.js') }}"></script>
		@include('js_functions.inc_func')

	<script>
		 $(document).on("click", ".new_line", function () {
    $(".append-line").append(`
                        <div class="row">
                            <div class="form-group col-md-3">
                                <select name="trans_acc_id[]" class="form-control form-control-sm select2">
                                    <option value="">Select</option>
                                    {!! \App\Models\Accounts\TransactionAccount::dropdown() !!}
                                </select>
                        </div>
                <div class="form-group col-md-4">
                    <textarea name="narration[]" class="form-control form-control-sm" rows="10" placeholder="Narration" style="height: 40px !important;"></textarea>
                </div>
                <div class="form-group col-md-2">
                    <input type="number" step="any" name="dr_amount[]" class="form-control form-control-sm dr_amount" placeholder="Paid Amount" onchange="getTotal();">
                </div>
                <div class="form-group col-md-2">
                    <input type="number" step="any" name="cr_amount[]" class="form-control form-control-sm cr_amount" placeholder="Paid Amount" onchange="getTotal();">
                </div>
                <div class="form-group col-md-1">
                    <button type="button" class="btn btn-danger btn-xs remove"><i class="fa fa-trash"></i> </button>
                </div>
            </div>
`);
    $(".select2").select2();
});

	</script>
	 @if(session()->get('success'))
	 <script>
		 toastr.success("{{session()->get('success')}}");
	 </script>
	{{ session()->forget('success')}}
	 @endif
	 @if(session()->get('error'))
	 <script>
		 toastr.error("{{session()->get('error')}}");
	 </script>
	 {{ session()->forget('error')}}
	 @endif
</body>
</html>
