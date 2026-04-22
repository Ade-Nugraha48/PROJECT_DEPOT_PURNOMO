<?php

require_once __DIR__ . "/../../config/database.php";

$id_pesanan = $_GET['id_pesanan'];

$query = "UPDATE pembayaran 
SET status_pembayaran='berhasil', waktu_pembayaran=NOW()
WHERE id_pesanan='$id_pesanan'";

mysqli_query($koneksi, $query);

$query_update_pesanan = "UPDATE pesanan 
SET status_pesanan='sedang_proses'
WHERE id_pesanan='$id_pesanan'";

mysqli_query($koneksi, $query_update_pesanan);

// Cek apakah transaksi sudah ada untuk id_pesanan ini
$query_check = "SELECT id_transaksi FROM transaksi WHERE id_pesanan='$id_pesanan'";
$result_check = mysqli_query($koneksi, $query_check);

if (mysqli_num_rows($result_check) == 0) {
    // Catat transaksi hanya jika belum ada
    require_once __DIR__ . "/../../functions/transaksi_helper.php";
    catat_transaksi($koneksi, $id_pesanan);
}

echo "Pembayaran berhasil";