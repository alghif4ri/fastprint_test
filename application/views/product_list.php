<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Product List</title>

	<!-- Bootstrap CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

	<!-- DataTables CSS -->
	<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<style>
		.table-wrapper {
			margin: 30px;
		}
	</style>
</head>

<body>

	<div class="container">
		<div class="table-wrapper">
			<h2>Product List</h2>

			<a href="<?= base_url('product/add') ?>" class="btn btn-primary">Tambah Produk</a>


			<!-- Table with Bootstrap and DataTables -->
			<table id="productTable" class="table table-striped table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>Nama Produk</th>
						<th>Harga</th>
						<th>Kategori</th>
						<th>Status</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<!-- Produk List Akan Ditampilkan di Sini -->
					<?php foreach ($products as $product): ?>
						<tr>
							<td><?= $product->nama_produk ?></td>
							<td><?= $product->harga ?></td>
							<td><?= $product->nama_kategori ?></td>
							<td><?= $product->nama_status ?></td>
							<td>
								<button class="btn btn-warning btn-sm edit-product" data-id="<?= $product->id_produk ?>">Edit</button>
								<button class="btn btn-danger btn-sm delete-product" data-id="<?= $product->id_produk ?>">Hapus</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

	<!-- Bootstrap JS -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<!-- DataTables JS -->
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script>
		$(document).ready(function() {
			$('#productTable').DataTable();

			$(document).ready(function() {
				$('.edit-product').on('click', function() {
					var productId = $(this).data('id'); // Ambil ID produk dari data-id
					window.location.href = "<?= base_url('product/edit/') ?>" + productId; // Arahkan ke halaman edit sesuai ID produk
				});
			});

			$(document).on('click', '.delete-product', function() {
				var productId = $(this).data('id');

				Swal.fire({
					title: 'Apakah Anda yakin?',
					text: "Data produk ini akan dihapus secara permanen!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#d33',
					cancelButtonColor: '#3085d6',
					confirmButtonText: 'Ya, hapus!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: 'http://localhost/fastprint_test/product/delete/' + productId,
							type: 'POST',
							success: function(response) {
								var res = JSON.parse(response);
								if (res.status) {
									Swal.fire(
										'Deleted!',
										res.message,
										'success'
									).then(() => {
										location.reload(); // Reload page after deletion
									});
								} else {
									Swal.fire(
										'Gagal!',
										res.message,
										'error'
									);
								}
							}
						});
					}
				});
			});

		});
	</script>

</body>

</html>
