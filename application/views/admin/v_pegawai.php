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
					<div class="col-8">
						<div class="card">
							<div class="card-header">
								<button type="button" class="btn btn-xs btn-primary" onclick="show_modal()">
									<i class="fa fa-plus"></i> pegawai
								</button>
							</div>
							<div class="card-body">
								<table class="table table-bordered table-hover" id="table">
									<thead>
										<tr>
											<th class="text-center" style="width: 15px;">#</th>
											<th>Nama Pegawai</th>
											<th>Jabatan</th>
											<th class="text-center">Opsi</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($data as $key => $dt) : ?>
											<tr>
												<td class="text-center"><?= ($key + 1) ?></td>
												<td><?= $dt['nm_pegawai']; ?></td>
												<td><?= $dt['nm_jabatan']; ?></td>
												<td class="text-center">
													<span class="badge badge-success" style="cursor: pointer" onclick="sunting('<?= $dt['id_pegawai'] ?>')">
														<i class="fa fa-edit"></i>
													</span>
													<span class="badge badge-danger" style="cursor: pointer" onclick="hapus('<?= $dt['id_pegawai'] ?>')">
														<i class="fa fa-trash"></i>
													</span>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
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
				<h5 class="modal-title">Form Pegawai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form" autocomplete="off">
					<input type="hidden" class="form-control" name="id_pegawai" id="id_pegawai">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nama Pegawai</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="nm_pegawai" id="nm_pegawai">
							<span class="help-text"></span>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Jabatan</label>
						<div class="col-sm-6">
							<select class="form-control selectpicker" name="li_jabatan" id="li_jabatan">
								<option selected disabled>-- Please Select --</option>
								<?php foreach ($li_jabatan as $li) : ?>
									<option value="<?= $li['id_jabatan'] ?>"><?= $li['nm_jabatan']; ?></option>
								<?php endforeach; ?>
							</select>
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

	$('#table').DataTable({
		'ordering': false
	});

	$('input[type="text"]').on('keypress', function() {
		$(this).removeClass('is-invalid');
		$(this).next().removeClass('invalid-feedback').empty();
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
		$('.selectpicker').selectpicker('refresh');
	}

	function sunting(id) {
		reset_form();
		save_method = 'update';

		$('#modal_form').modal('show');
		$('.btn_save').text('Sunting');

		$.ajax({
			url: '<?= site_url('admin/page/pegawai/get/') ?>' + id,
			type: 'GET',
			dataType: 'JSON',
			success: function(data) {
				$('#id_pegawai').val(data.id_pegawai);
				$('#nm_pegawai').val(data.nm_pegawai);
				$('#li_jabatan').selectpicker('val', data.id_jabatan);
			}
		});
	}

	function save_form() {
		var url = '';
		if (save_method == 'add') url = '<?= site_url('admin/page/pegawai/insert') ?>';
		else url = '<?= site_url('admin/page/pegawai/update') ?>';

		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'JSON',
			data: $('#form').serialize(),
			success: function(data) {
				if (data.status === true) {
					Swal.fire({
						title: 'Berhasil',
						text: 'Nama pegawai telah tersimpan',
						icon: 'success',
						timer: 2000,
						showConfirmButton: false
					}).then((result) => {
						if (result.dismiss === Swal.DismissReason.timer) {
							$('#modal_form').modal('hide');
							location.reload();
						}
					});
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
					url: "<?= site_url('admin/page/pegawai/delete/') ?>" + id,
					type: "GET",
					dataType: "JSON",
					success: function(data) {
						Swal.fire({
							title: 'Berhasil',
							text: 'Nama pegawai telah dihapus',
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
