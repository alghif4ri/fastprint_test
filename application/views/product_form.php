<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tambah Produk</title>

	<!-- Bootstrap CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

	<!-- Custom CSS -->
	<style>
		.table-wrapper {
			margin: 30px;
		}
	</style>
</head>

<body>
	<div class="container">
		<form id="form_produk" novalidate>
			<div class="container mt-5">
				<div class="card">
					<div class="card-header bg-primary text-white">
						<h4>Tambah Produk</h4>
					</div>
					<div class="card-body">
						<!-- Nama Produk -->
						<div class="form-group">
							<label for="nama_produk">Nama Produk</label>
							<input type="text" name="nama_produk" id="nama_produk" class="form-control" required>
						</div>

						<!-- Harga -->
						<div class="form-group">
							<label for="harga">Harga</label>
							<input type="text" name="harga" id="harga" class="form-control" required>
						</div>

						<!-- Kategori -->
						<div class="form-group">
							<label for="kategori_id">Kategori</label>
							<select name="kategori_id" id="kategori_id" class="form-control" required>
								<option value="">---Pilih Kategori---</option>
								<?php foreach ($categories as $category) : ?>
									<option value="<?= $category->id_kategori ?>"><?= $category->nama_kategori ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<!-- Status -->
						<div class="form-group">
							<label for="status_id">Status</label>
							<select name="status_id" id="status_id" class="form-control" required>
								<option value="">---Pilih Status---</option>
								<?php foreach ($statuses as $status) : ?>
									<option value="<?= $status->id_status ?>"><?= $status->status ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<!-- Tombol Simpan -->
						<div class="form-group mt-4">
							<button type="submit" class="btn btn-primary btn-block">Simpan</button>
							<a href="<?= base_url('product') ?>" class="btn btn-secondary btn-block">Kembali ke List Produk</a>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- Bootstrap JS -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<!-- SweetAlert2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script>
		$(document).ready(function() {
			$('#form_produk').on('submit', function(e) {
				e.preventDefault(); // Prevent form submission

				const formData = $(this).serialize(); // Serialize form data

				$.ajax({
					url: "<?= base_url('product/insert') ?>", // URL controller
					method: "POST",
					data: formData,
					dataType: "json", // Response dari server adalah JSON
					success: function(response) {
						if (response.status === 'success') {
							Swal.fire({
								icon: 'success',
								title: 'Berhasil!',
								text: response.message,
								confirmButtonText: 'OK'
							}).then((result) => {
								if (result.isConfirmed) {
									window.location.href = "<?= base_url('product/add') ?>";
								}
							});
						} else if (response.status === 'error') {
							Swal.fire({
								icon: 'error',
								title: 'Gagal!',
								html: response.message, // Menampilkan semua pesan error
							});
						}
					},
					error: function() {
						Swal.fire({
							icon: 'error',
							title: 'Error!',
							text: 'Terjadi kesalahan server.',
						});
					}
				});
			});
		});
	</script>
</body>

</html>
