<?php $this->load->view('template/v_header'); ?>

<div class="wrapper">
	<!-- Navbar -->
	<?php $this->load->view('template/v_navbar'); ?>
	<!-- End of Navbar -->

	<!-- Sidebar -->
	<?php $this->load->view('template/v_sidebar'); ?>
	<!-- End of Sidebar -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0 text-dark"><?= $title; ?></h1>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<blockquote class="ml-0 mt-0">
							<strong>Perhatian!</strong><br>
							Setiap perubahan yang terjadi akan berpengaruh pada data yang berhubungan. Mohon berhati-hati ketika <b>mengubah</b> atau <b>menghapus</b> data.
						</blockquote>
					</div>
					<div class="col-10">
						<div class="card">
							<div class="card-header">
								<button type="button" class="btn btn-xs btn-primary" onclick="show_modal()">
									<i class="fa fa-plus"></i> Unit Tujuan
								</button>
							</div>
							<div class="card-body">
								<table class="table table-bordered table-hover" id="table">
									<thead>
										<tr>
											<th class="text-center" style="width: 25px;">#</th>
											<th>Kode Unit</th>
											<th>Nama Unit</th>
											<th class="text-center">Opsi</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- /.row -->
			</div>
			<!--/. container-fluid -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
</div>

<!-- Modal -->
<div class="modal fade" id="modal_form" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Form Unit Tujuan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form" autocomplete="off">
					<input type="hidden" class="form-control" name="no" id="no">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Kode Unit</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="kd_unit" id="kd_unit">
							<span class="help-text"></span>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nama Unit</label>
						<div class="col-sm-6">
							<textarea class="form-control" name="nm_unit" id="nm_unit"></textarea>
							<span class="help-text"></span>
						</div>
					</div>
					<div class="form-group row">
						<div class="offset-2 col-sm-6">
							<span class="btn btn-primary btn_save" onclick="save_form()"></span>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Footer -->
<?php $this->load->view('template/v_footer'); ?>
<!-- End of Footer -->

<script>
	var save_method = '';

	$(document).ready(function() {
		//datatables
		table = $('#table').DataTable({
			'processing': true,
			'serverSide': true,
			'order': [],
			'ajax': {
				'url': "<?= site_url('admin/page/unit-tujuan/list') ?>",
				'type': 'POST'
			},
			'ordering': false
		});
	});

	$('input[type="text"], textarea').on('keypress', function() {
		$(this).removeClass('is-invalid');
		$(this).next().removeClass('invalid-feedback').empty();
		$(this).css('text-transform', 'uppercase');
	});

	function reset_form() {
		$('#form')[0].reset();
		$('.form-control').removeClass('is-invalid');
		$('.text-help').removeClass('invalid-feedback').empty();
	}

	function show_modal() {
		reset_form();
		save_method = 'add';

		$('#modal_form').modal('show');
		$('.btn_save').text('Simpan');
	}

	function sunting(id) {
		reset_form();
		save_method = 'update';

		$('#modal_form').modal('show');
		$('.btn_save').text('Sunting');

		$.ajax({
			url: '<?= site_url('admin/page/unit-tujuan/get/') ?>' + id,
			type: 'GET',
			dataType: 'JSON',
			success: function(data) {
				$('#no').val(data.no);
				$('#kd_unit').val(data.kd_unit);
				$('#nm_unit').val(data.nm_unit);
			}
		});
	}

	function save_form() {
		var url = '';
		if (save_method == 'add') url = '<?= site_url('admin/page/unit-tujuan/insert') ?>';
		else url = '<?= site_url('admin/page/unit-tujuan/update') ?>';

		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'JSON',
			data: $('#form').serialize(),
			success: function(data) {
				if (data.status === true) {
					if (data.icon == 'warning') {
						Swal.fire({
							title: data.title,
							text: data.text,
							icon: data.icon
						});
					} else {
						Swal.fire({
							title: data.title,
							text: data.text,
							icon: data.icon,
							timer: 2000,
							showConfirmButton: false
						}).then((result) => {
							if (result.dismiss === Swal.DismissReason.timer) {
								$('#modal_form').modal('hide');
								location.reload();
							}
						});
					}
				} else {
					for (var i = 0; i < data.inputerror.length; i++) {
						$('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
						$('[name="' + data.inputerror[i] + '"]').next().addClass('invalid-feedback').text(data.error[i]);
					}
				}
			}
		});
	}

	function hapus(id) {
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Data yang dihapus tidak bisa dikembalikan kembali!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Hapus',
			cancelButtonText: 'Tidak'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: "<?= site_url('admin/page/unit-tujuan/delete/') ?>" + id,
					type: "GET",
					dataType: "JSON",
					success: function(data) {
						Swal.fire({
							title: 'Berhasil',
							text: 'Unit tujuan telah dihapus',
							icon: 'success',
							timer: 2000,
							showConfirmButton: false
						}).then((result) => {
							if (result.dismiss === Swal.DismissReason.timer) {
								location.reload();
							}
						});
					}
				});
			}
		})
	}
</script>
