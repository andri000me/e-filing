<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<title>E-Filing | <?= $title; ?></title>

	<!-- Favivon -->
	<link rel="shortcut icon" href="<?= base_url('assets/logo-bsi.png') ?>">
	<!-- Custome CSS -->
	<link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?= base_url('assets/') . 'plugins/fontawesome-free/css/all.min.css' ?>">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="<?= base_url('assets/') . 'plugins/overlayScrollbars/css/OverlayScrollbars.min.css' ?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url('assets/') . 'dist/css/adminlte.min.css' ?>">
	<!-- Sweetalert2 -->
	<link rel="stylesheet" href="<?= base_url('assets/') . 'plugins/sweetalert2/sweetalert2.min.css' ?>">
	<!-- DataTables BS4 -->
	<link rel="stylesheet" href="<?= base_url('assets/') . 'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css' ?>">
	<!-- Bootstrap Select -->
	<link rel="stylesheet" href="<?= base_url('assets/') . 'plugins/bootstrap-select/css/bootstrap-select.min.css' ?>">
	<!-- Bootstrap Select2 -->
	<link rel="stylesheet" href="<?= base_url('assets/') . 'plugins/select2/css/select2.min.css' ?>">
	<!-- Bootstrap Datepicker -->
	<link rel="stylesheet" href="<?= base_url('assets/') . 'plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css' ?>">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


	<!-- REQUIRED SCRIPTS -->
	<!-- jQuery -->
	<script src="<?= base_url('assets/') . 'plugins/jquery/jquery.min.js' ?>"></script>
	<!-- Bootstrap -->
	<script src="<?= base_url('assets/') . 'plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
	<!-- overlayScrollbars -->
	<script src="<?= base_url('assets/') . 'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js' ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url('assets/') . 'dist/js/adminlte.js' ?>"></script>
	<!-- Sweetalert2 -->
	<script src="<?= base_url('assets/') . 'plugins/sweetalert2/sweetalert2.min.js' ?>"></script>
	<!-- DataTables BS4 -->
	<script src="<?= base_url('assets/') . 'plugins/datatables/jquery.dataTables.min.js' ?>"></script>
	<script src="<?= base_url('assets/') . 'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js' ?>"></script>
	<!-- Bootstrap Select -->
	<script src="<?= base_url('assets/') . 'plugins/bootstrap-select/js/bootstrap-select.min.js' ?>"></script>
	<!-- Bootstrap Select2 -->
	<script src="<?= base_url('assets/') . 'plugins/select2/js/select2.min.js' ?>"></script>
	<!-- Bootstrap Datepicker -->
	<script src="<?= base_url('assets/') . 'plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js' ?>"></script>
	<!-- Pages Script -->
	<script>
		$(document).ready(function() {
			const url = '<?= $this->uri->segment('3'); ?>';

			$('.nav-link').removeClass('active');
			if (url == 'dashboard') {
				$('#' + url).addClass('active');
			} else {
				$('#' + url).addClass('active');
				$('#' + url).closest('ul').prev().addClass('active');
				$('#' + url).closest('ul').prev().parent('.has-treeview').addClass('menu-open');
			}

			$('.date').datepicker({
				container: '#datepicker',
				format: 'dd/mm/yyyy',
				todayHighlight: true,
				autoclose: true,
				orientation: 'top auto'
			});
		});

		function CheckNumeric() {
			return event.keyCode >= 48 && event.keyCode <= 57;
		}
	</script>

	<!-- PAGE PLUGINS -->
	<!-- jQuery Mapael -->
	<script src="<?= base_url('assets/') . 'plugins/jquery-mousewheel/jquery.mousewheel.js' ?>"></script>
	<script src="<?= base_url('assets/') . 'plugins/raphael/raphael.min.js' ?>"></script>
	<script src="<?= base_url('assets/') . 'plugins/jquery-mapael/jquery.mapael.min.js' ?>"></script>
	<script src="<?= base_url('assets/') . 'plugins/jquery-mapael/maps/usa_states.min.js' ?>"></script>
	<!-- ChartJS -->
	<script src="<?= base_url('assets/') . 'plugins/chart.js/Chart.min.js' ?>"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm">
