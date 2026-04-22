<?php
// skrip yang dijalankan saat admin menambahkan stok via form kecil
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../functions/stok_helper.php";

$id_barang = $_POST['id_barang'];
$jumlah = $_POST['jumlah'];

// fungsi helper akan meng-update stok dan mencatat log
tambah_stok($koneksi, $id_barang, $jumlah);

// kembali ke halaman manajemen stok
header("Location: manajemen_stok.php");