<?php

require_once "../../config/database.php";

$id_pesanan = $_GET['id_pesanan'];

$query = "UPDATE pembayaran 
SET status_pembayaran='berhasil', waktu_pembayaran=NOW()
WHERE id_pesanan='$id_pesanan'";

mysqli_query($koneksi, $query);

$query_update_pesanan = "UPDATE pesanan 
SET status_pesanan='sedang_proses'
WHERE id_pesanan='$id_pesanan'";

mysqli_query($koneksi, $query_update_pesanan);

echo "Pembayaran berhasil";