<?php

require_once "../../config/database.php";
require_once "../../functions/stok_helper.php";

$id_pesanan = intval($_GET['id_pesanan'] ?? 0);

// pastikan status enum mencakup 'ditolak' agar query update tidak gagal
// ini hanya menjalankan ALTER TABLE jika belum ada nilai, tidak berpengaruh bila sudah
$alter = "ALTER TABLE pesanan \
    MODIFY status_pesanan ENUM('menunggu_pembayaran','sedang_proses','selesai','ditolak') DEFAULT NULL";
mysqli_query($koneksi, $alter);

// cek status saat ini, kalau sudah "sedang_proses" berarti stok sudah dikurangi
// maka kita kembalikan stok sebelum membatalkan pesanan
$qcheck = "SELECT status_pesanan FROM pesanan WHERE id_pesanan='$id_pesanan'";
$rcheck = mysqli_query($koneksi, $qcheck);
$row = mysqli_fetch_assoc($rcheck);
if ($row && $row['status_pesanan'] === 'sedang_proses') {
    $qdetail = "SELECT * FROM detail_pesanan WHERE id_pesanan='$id_pesanan'";
    $rdetail = mysqli_query($koneksi, $qdetail);
    while ($d = mysqli_fetch_assoc($rdetail)) {
        tambah_stok($koneksi, $d['id_barang'], $d['jumlah']);
    }
}

// ubah status menjadi ditolak
$query = "UPDATE pesanan SET status_pesanan='ditolak' WHERE id_pesanan='$id_pesanan'";
mysqli_query($koneksi, $query);

// redirect kembali ke daftar
header("Location: daftar_pesanan.php");
