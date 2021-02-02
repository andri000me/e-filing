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
							* File yang sudah di upload tidak bisa dihapus kembali.
						</blockquote>
					</div>
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<button type="button" class="btn btn-xs btn-primary" onclick="show_modal()">
									<i class="fa fa-plus"></i> Dokumen Masuk
								</button>
							</div>
							<div class="card-body">
								<table class="table table-bordered table-hover" id="table" style="width: 100%;">
									<thead>
										<tr>
											<th class="text-center" style="width: 25px;">#</th>
											<th>Jenis Dokumen</th>
											<th>Detail Dokumen</th>
											<th style="width: 15%;">Status Dokumen</th>
											<th style="width: 10%">Tgl. Diterima</th>
											<!-- <th>Status</th> -->
											<th class="text-center" style="width: 10%;">Opsi</th>
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
				<h5 class="modal-title">Form Dokumen Masuk</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form" enctype="multipart/form-data" autocomplete="off">
					<input type="hidden" class="form-control" name="id_dok" id="id_dok">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Jenis Dokumen <sup class="text-red">*</sup></label>
						<div class="col-sm-4">
							<select class="form-control selectpicker" name="jns_dokumen" id="jns_dokumen">
								<option selected disabled>-- Please Select --</option>
								<?php foreach ($jns_dokumen as $li) : ?>
									<option value="<?= $li['id_jns_dokumen'] ?>"><?= $li['jns_dokumen']; ?></option>
								<?php endforeach; ?>
							</select>
							<small class="help-text" id="jns_dokumen-feedback"></small>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nomor Dokumen <sup class="text-red">*</sup></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="no_dok" id="no_dok">
							<small class="help-text" id="no_dok-feedback"></small>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Perihal <sup class="text-red">*</sup></label>
						<div class="col-sm-6">
							<textarea class="form-control" name="perihal" id="perihal"></textarea>
							<small class="help-text" id="perihal-feedback"></small>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Dari <sup class="text-red">*</sup></label>
						<div class="col-sm-6">
							<input class="form-control" name="dari" id="dari" list="li_unit">
							<datalist id="li_unit">
								<?php foreach ($dari as $li) : ?>
									<option value="<?= $li['kd_unit'] . ' - ' . $li['nm_unit'] ?>">
									<?php endforeach; ?>
							</datalist>
							<small class="help-text" id="dari-feedback"></small>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Lampiran</label>
						<div class="col-sm-1">
							<input type="text" class="form-control" name="lampiran" id="lampiran" onkeypress="return CheckNumeric()">
						</div>
						<label class="col-sm-auto col-form-label">Lembar <span class="ml-3 text-muted">(kosongkan bila tidak ada lampiran)</span></label>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Kategori <sup class="text-red">*</sup></label>
						<div class="col-sm-3">
							<select class="form-control selectpicker" name="kategori" id="kategori">
								<option selected disabled>-- Please Select --</option>
								<?php foreach ($kategori as $li) : ?>
									<option value="<?= $li['id_kategori'] ?>"><?= $li['jns_kategori']; ?></option>
								<?php endforeach; ?>
							</select>
							<small class="help-text" id="kategori-feedback"></small>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tgl. Dokumen <sup class="text-red">*</sup></label>
						<div class="col-sm-3">
							<div class="input-group date" id="datepicker">
								<input type="text" class="form-control" name="tgl_dokumen" id="tgl_dokumen">
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="fa fa-fw fa-calendar-alt"></i>
									</span>
								</div>
							</div>
							<small class="help-text" id="tgl_dokumen-feedback"></small>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tgl. Diterima <sup class="text-red">*</sup></label>
						<div class="col-sm-3">
							<div class="input-group date" id="datepicker">
								<input type="text" class="form-control" name="tgl_diterima" id="tgl_diterima">
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="fa fa-fw fa-calendar-alt"></i>
									</span>
								</div>
							</div>
							<small class="help-text" id="tgl_diterima-feedback"></small>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Disposisi</label>
						<div class="col-sm-6">
							<select class="form-control select2" name="disposisi[]" id="disposisi" multiple="multiple" style="width: 100%;">
								<option disabled>-- Please Select --</option>
								<?php foreach ($pegawai as $li) : ?>
									<option value="<?= $li['nm_pegawai'] ?>"><?= $li['nm_pegawai'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">File Upload</label>
						<div class="col-sm-6">
							<div class="custom-file">
								<input type="file" class="custom-file-input" name="file" id="file">
								<label class="custom-file-label" for="file">Choose file</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Catatan</label>
						<div class="col-sm-6">
							<textarea class="form-control" name="catatan" id="catatan"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<div class="offset-2 col-sm-6">
							<button type="submit" class="btn btn-primary btn_save"></button>
							<!-- <span class="btn btn-primary btn_save" onclick="save_form()"></span> -->
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
				'url': "<?= site_url('user/page/dokumen-masuk/list') ?>",
				'type': 'POST'
			},
			'ordering': false
		});

		$('input[type="file"]').on('change', function() {
			//get the file name
			var file = $(this).val();
			var fileName = file.replace('C:\\fakepath\\', '');
			//replace the "Choose a file" label
			$(this).next('.custom-file-label').html(fileName);
		});

		$('#no_dok, #perihal').on('keypress', function() {
			$(this).css('text-transform', 'uppercase');
		});

		$('#form').on('change', 'input[type="file"]', function() {
			//get the file name
			var file = $(this).val();
			var fileName = file.replace('C:\\fakepath\\', '');
			//replace the "Choose a file" label
			$(this).next('.custom-file-label').html(fileName);

			var size = $(this)[0].files[0].size / 1024;
			console.log(size);

			if ($(this)[0].files[0].type != 'application/pdf') {
				Swal.fire({
					title: 'Oops!',
					icon: 'warning',
					text: 'Format file upload tidak valid!'
				});
				$(this).next('.custom-file-label').html('Choose file');
				$(this).val('');
			} else {
				if (size > (1024 * 8)) {
					Swal.fire({
						title: 'Oops!',
						icon: 'warning',
						text: 'Ukuran file melebihi batas, maksimal 8 MB!'
					});
					$(this).next('.custom-file-label').html('Choose file');
					$(this).val('');
				}
			}
		});

		// save form
		$('#form').submit(function(evt) {
			evt.preventDefault();

			var url = '';
			if (save_method == 'add') url = '<?= site_url('user/page/dokumen-masuk/insert') ?>';
			else url = '<?= site_url('user/page/dokumen-masuk/update') ?>';

			$.ajax({
				url: url,
				type: 'POST',
				dataType: 'JSON',
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function(data) {
					if (data.status === true) {
						Swal.fire({
							title: data.title,
							text: data.text,
							icon: data.icon,
							timer: 2000,
							showConfirmButton: false
						}).then((result) => {
							if (result.dismiss === Swal.DismissReason.timer) {
								location.reload();
							}
						});
					} else {
						$('.help-text').removeClass('text-red').empty();
						for (var i = 0; i < data.inputerror.length; i++) {
							$('#' + data.inputerror[i] + '-feedback').addClass('text-red').text(data.error[i]);
						}
					}
				}
			});
		});
	});

	function reset_form() {
		$('#form')[0].reset();
		$('.custom-file-label').text('Choose file');
		$('.help-text').removeClass('text-red').empty();

		$('input, select, textarea').attr('disabled', false);
		$('.select2').select2();
		$('.selectpicker').selectpicker('refresh');
	}

	function show_modal() {
		reset_form();
		save_method = 'add';

		$('#modal_form').modal('show');
		$('.btn_save').css({
			'display': 'block',
			'cursor': 'pointer'
		}).text('Simpan');
	}

	function sunting(id) {
		reset_form();
		save_method = 'update';

		$('#modal_form').modal('show');
		$('.btn_save').css({
			'display': 'block',
			'cursor': 'pointer'
		}).text('Sunting');

		$.ajax({
			url: '<?= site_url('user/page/dokumen-masuk/get/') ?>' + id,
			type: 'GET',
			dataType: 'JSON',
			success: function(data) {
				$('#id_dok').val(data.id_dokumen);
				$('#no_dok').val(data.no_dokumen);
				$('#jns_dokumen').val(data.jns_dokumen);
				$('#disposisi').val(data.disposisi).change();
				$('#perihal').val(data.perihal);
				$('#dari').val(data.dari);
				$('#lampiran').val(data.lampiran);
				$('#kategori').val(data.kategori);
				$('#tgl_dokumen').val(data.tgl_dokumen);
				$('#tgl_diterima').val(data.tgl_diterima);
				$('.custom-file-label').text(data.file_dokumen);
				$('#catatan').val(data.catatan);

				$('.selectpicker').selectpicker('refresh');
			}
		});
	}

	function view(id) {
		reset_form();

		$('#modal_form').modal('show');
		$('.btn_save').css({
			'display': 'none',
			'cursor': 'none'
		});

		$.ajax({
			url: '<?= site_url('user/page/dokumen-masuk/get/') ?>' + id,
			type: 'GET',
			dataType: 'JSON',
			success: function(data) {
				$('#id_dok').val(data.id_dokumen).attr('disabled', true);
				$('#no_dok').val(data.no_dokumen).attr('disabled', true);
				$('#jns_dokumen').val(data.jns_dokumen).attr('disabled', true);
				$('#disposisi').val(data.disposisi).change().attr('disabled', true);
				$('#perihal').val(data.perihal).attr('disabled', true);
				$('#dari').val(data.dari).attr('disabled', true);
				$('#lampiran').val(data.lampiran).attr('disabled', true);
				$('#kategori').val(data.kategori).attr('disabled', true);
				$('#tgl_dokumen').val(data.tgl_dokumen).attr('disabled', true);
				$('#tgl_diterima').val(data.tgl_diterima).attr('disabled', true);
				$('#file').attr('disabled', true);
				$('.custom-file-label').text(data.file_dokumen);
				$('#catatan').val(data.catatan).attr('disabled', true);

				$('.selectpicker').selectpicker('refresh');
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
					url: "<?= site_url('user/page/dokumen-masuk/delete/') ?>" + id,
					type: "GET",
					dataType: "JSON",
					success: function(data) {
						Swal.fire({
							title: 'Sukses',
							text: 'Dokumen telah berhasil dihapus',
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
