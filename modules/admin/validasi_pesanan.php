<?php

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../functions/stok_helper.php";

$id_pesanan = $_GET['id_pesanan'];

$query_detail = "SELECT * FROM detail_pesanan 
WHERE id_pesanan='$id_pesanan'";

$result = mysqli_query($koneksi, $query_detail);

while ($detail = mysqli_fetch_assoc($result)) {

    $id_barang = $detail['id_barang'];
    $jumlah = $detail['jumlah'];

    kurangi_stok($koneksi, $id_barang, $jumlah);
}

$query_update = "UPDATE pesanan
SET status_pesanan='sedang_proses'
WHERE id_pesanan='$id_pesanan'";

mysqli_query($koneksi, $query_update);

require_once __DIR__ . "/../../functions/pengiriman_helper.php";

buat_pengiriman($koneksi, $id_pesanan);

// Catat transaksi ketika admin validasi (asumsi pembayaran sudah berhasil)
require_once __DIR__ . "/../../functions/transaksi_helper.php";

// Cek apakah transaksi sudah ada untuk id_pesanan ini
$query_check = "SELECT id_transaksi FROM transaksi WHERE id_pesanan='$id_pesanan'";
$result_check = mysqli_query($koneksi, $query_check);

if (mysqli_num_rows($result_check) == 0) {
    // Catat transaksi hanya jika belum ada
    catat_transaksi($koneksi, $id_pesanan);
}

// Redirect kembali ke daftar pesanan dengan pesan sukses
header("Location: daftar_pesanan.php?success=1");
exit;