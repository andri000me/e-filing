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
					<div class="col-6">
						<div class="card">
							<div class="card-header">
								<button type="button" class="btn btn-xs btn-primary" onclick="show_modal()">
									<i class="fa fa-plus"></i> Jenis Dokumen
								</button>
							</div>
							<div class="card-body">
								<table class="table table-bordered table-hover" id="table">
									<thead>
										<tr>
											<th class="text-center">#</th>
											<th>Jenis Dokumen</th>
											<th>Keterangan</th>
											<th class="text-center">Opsi</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($data as $key => $dt) : ?>
											<tr>
												<td class="text-center"><?= ($key + 1) ?></td>
												<td><?= $dt['jns_dokumen']; ?></td>
												<td><?= $dt['keterangan']; ?></td>
												<td class="text-center">
													<?php if ($dt['id_jns_dokumen'] > 3) : ?>
														<span class="badge badge-success" style="cursor: pointer" onclick="sunting('<?= $dt['id_jns_dokumen'] ?>')">
															<i class="fa fa-edit"></i>
														</span>
														<span class="badge badge-danger" style="cursor: pointer" onclick="hapus('<?= $dt['id_jns_dokumen'] ?>')">
															<i class="fa fa-trash"></i>
														</span>
													<?php else : ?>
													<span class="text-red"><i class="fa fa-ban"></i></span>
													<?php endif; ?>
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
				<h5 class="modal-title">Form Jenis Dokumen</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form" autocomplete="off">
					<input type="hidden" class="form-control" name="id_dokumen" id="id_dokumen">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Jenis Dokumen</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="jns_dokumen" id="jns_dokumen">
							<span class="help-text"></span>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Keterangan</label>
						<div class="col-sm-6">
							<textarea class="form-control" name="ket_dokumen" id="ket_dokumen"></textarea>
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

	$('#table').DataTable({
		'ordering': false
	});

	$('input[type="text"], textarea').on('keypress', function() {
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
	}

	function sunting(id) {
		reset_form();
		save_method = 'update';

		$('#modal_form').modal('show');
		$('.btn_save').text('Sunting');

		$.ajax({
			url: '<?= site_url('admin/page/jenis-dokumen/get/') ?>' + id,
			type: 'GET',
			dataType: 'JSON',
			success: function(data) {
				console.log(data);
				$('#id_dokumen').val(data.id_jns_dokumen);
				$('#jns_dokumen').val(data.jns_dokumen);
				$('#ket_dokumen').val(data.keterangan);
			}
		});
	}

	function save_form() {
		var url = '';
		if (save_method == 'add') url = '<?= site_url('admin/page/jenis-dokumen/insert') ?>';
		else url = '<?= site_url('admin/page/jenis-dokumen/update') ?>';

		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'JSON',
			data: $('#form').serialize(),
			success: function(data) {
				if (data.status) {
					Swal.fire({
						title: 'Berhasil',
						text: 'Jenis dokumen berhasil tersimpan',
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
					url: "<?= site_url('admin/page/jenis-dokumen/delete/') ?>" + id,
					type: "GET",
					dataType: "JSON",
					success: function(data) {
						Swal.fire({
							title: 'Berhasil',
							text: 'Jenis dokumen telah dihapus',
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
