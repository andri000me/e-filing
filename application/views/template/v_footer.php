<script>
	function logout() {
		Swal.fire({
			title: "Logout",
			text: "Apakah Anda yakin ingin keluar dari aplikasi?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Logout',
			cancelButtonText: 'Tidak'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: "<?= site_url('logout') ?>",
					type: "POST",
					success: function(data) {
						Swal.fire({
							title: 'Berhasil Logout',
							text: '',
							icon: 'success',
							timer: 1000,
							showConfirmButton: false
						}).then((result) => {
							if (result.dismiss === Swal.DismissReason.timer) {
								window.location.href = '<?= base_url() ?>';
							}
						});
					}
				});
			}
		})
	}
</script>

<footer class="main-footer">
	Copyright &copy; 2021 - Bank Syariah Indonesia
	<div class="float-right d-none d-sm-inline-block">
		<b>Version</b> 1.0.0
	</div>
</footer>

</body>

</html>
