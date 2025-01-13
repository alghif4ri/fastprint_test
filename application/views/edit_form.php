<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Product</title>

	<!-- Bootstrap CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

	<!-- DataTables CSS -->
	<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

	<!-- SweetAlert2 -->
	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>

	<!-- Custom CSS -->
	<style>
		.table-wrapper {
			margin: 30px;
		}
	</style>
</head>

<body>
	<div class="container">
		<form action="<?= base_url('product/update') ?>" method="post" id="form_edit_produk">
			<div class="container mt-5">
				<div class="card">
					<div class="card-header bg-primary text-white">
						<h4>Edit Produk</h4>
					</div>
					<div class="card-body">
						<!-- ID Produk (hidden) -->
						<input type="hidden" name="id_produk" value="<?= set_value('id_produk', $product->id_produk) ?>">

						<!-- Nama Produk -->
						<div class="form-group">
							<label for="nama_produk">Nama Produk</label>
							<input type="text" name="nama_produk" id="nama_produk" class="form-control <?= form_error('nama_produk') ? 'is-invalid' : '' ?>" value="<?= set_value('nama_produk', $product->nama_produk) ?>">
							<div class="invalid-feedback"><?= form_error('nama_produk') ?></div>
						</div>

						<!-- Harga -->
						<div class="form-group">
							<label for="harga">Harga</label>
							<input type="text" name="harga" id="harga" class="form-control <?= form_error('harga') ? 'is-invalid' : '' ?>" value="<?= set_value('harga', $product->harga) ?>">
							<div class="invalid-feedback"><?= form_error('harga') ?></div>
						</div>

						<!-- Kategori -->
						<div class="form-group">
							<label for="kategori_id">Kategori</label>
							<select name="kategori_id" id="kategori_id" class="form-control <?= form_error('kategori_id') ? 'is-invalid' : '' ?>">
								<option value="">---Pilih Kategori---</option>
								<?php foreach ($categories as $category) : ?>
									<option value="<?= $category->id_kategori ?>" <?= set_value('kategori_id', $product->kategori_id) == $category->id_kategori ? 'selected' : '' ?>>
										<?= $category->nama_kategori ?>
									</option>
								<?php endforeach; ?>
							</select>
							<div class="invalid-feedback"><?= form_error('kategori_id') ?></div>
						</div>

						<!-- Status -->
						<div class="form-group">
							<label for="status_id">Status</label>
							<select name="status_id" id="status_id" class="form-control <?= form_error('status_id') ? 'is-invalid' : '' ?>">
								<option value="">---Pilih Status---</option>
								<?php foreach ($statuses as $status) : ?>
									<option value="<?= $status->id_status ?>" <?= set_value('status_id', $product->status_id) == $status->id_status ? 'selected' : '' ?>>
										<?= $status->status ?>
									</option>
								<?php endforeach; ?>
							</select>
							<div class="invalid-feedback"><?= form_error('status_id') ?></div>
						</div>

						<!-- Tombol Simpan -->
						<div class="form-group mt-4">
							<button type="submit" class="btn btn-primary btn-block" id="updateButton">Update</button>
							<a href="<?= base_url('product') ?>" class="btn btn-secondary btn-block">Kembali ke List Produk</a>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>



	<script>
		document.getElementById("form_edit_produk").addEventListener("submit", async function(event) {
			event.preventDefault();

			const formData = new FormData(this);
			const response = await fetch(this.action, {
				method: 'POST',
				body: formData
			});

			const result = await response.json();

			if (result.status === 'success') {
				Swal.fire({
					title: 'Berhasil',
					text: result.message,
					icon: 'success',
					confirmButtonText: 'OK'
				}).then(() => {
					window.location.href = "<?= base_url('product') ?>";
				});
			} else if (result.status === 'error') {
				Swal.fire({
					title: 'Gagal',
					text: result.message,
					icon: 'error',
					confirmButtonText: 'OK'
				});
			}
		});
	</script>


</body>

</html>
