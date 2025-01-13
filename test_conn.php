<?php
$conn = pg_connect("host=localhost dbname=fastprint user=postgres password=root");
if (!$conn) {
	die("Koneksi gagal: " . pg_last_error());
} else {
	echo "Koneksi berhasil!";
}
