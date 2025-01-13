<?php
$conn = pg_connect("host=localhost dbname=fastprint user=postgres password=root");
if ($conn) {
    echo "Koneksi berhasil!";
} else {
    echo "Koneksi gagal!";
}
?>
