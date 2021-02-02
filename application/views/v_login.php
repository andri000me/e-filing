<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>E-Filing | Log in</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?= base_url('assets/logo-bsi.png') ?>">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url('assets/') . 'plugins/fontawesome-free/css/all.min.css' ?>">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?= base_url('assets/') . 'plugins/icheck-bootstrap/icheck-bootstrap.min.css' ?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url('assets/') . 'dist/css/adminlte.min.css' ?>">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="card">
			<div class="card-header text-center my-0 py-2">
				<img src="<?= base_url('assets/logo-bsi.png') ?>" width="150px" height="50px">
				<h4 class="text-bold">Aplikasi Management Arsip</h4>
			</div>
			<div class="card-body login-card-body" style="border-radius: 10px;">
				<?php $msg = $this->session->flashdata('msg');
				if (!empty($msg)) : ?>
					<div class="alert alert-warning" role="alert">
						<strong>Oops!</strong><br> <?= $msg; ?>
					</div>
				<?php endif; ?>

				<form action="<?= site_url('login') ?>" method="post" autocomplete="off">
					<div class="input-group mb-3">
						<input type="text" class="form-control" name="username" id="username" placeholder="Username" autofocus required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<button type="submit" class="btn btn-info btn-block">Login</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
				<!-- /.login-card-body -->
			</div>
		</div>
		<p class="text-center">Copyright &copy; 2021 - Bank Syariah Indonesia</p>
	</div>
	<!-- /.login-box -->


	<!-- jQuery -->
	<script src="<?= base_url('assets/') . 'plugins/jquery/jquery.min.js' ?>"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url('assets/') . 'plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url('assets/') . 'dist/js/adminlte.min.js' ?>"></script>

</body>

</html>
