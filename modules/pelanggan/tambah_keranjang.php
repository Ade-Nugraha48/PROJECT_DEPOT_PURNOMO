<?php
session_start();
require_once "../../includes/auth_middleware.php";
require_once "../../config/database.php";

// pastikan data dikirim via POST
$id_barang = intval($_POST['id_barang'] ?? 0);
$jumlah = intval($_POST['jumlah'] ?? 0);

if ($id_barang <= 0 || $jumlah <= 0) {
    header("Location: daftar_barang.php");
    exit;
}

// cek stok sekarang, jika tidak cukup kembali ke daftar
$q = "SELECT stok_barang FROM barang WHERE id_barang=$id_barang";
$r = mysqli_query($koneksi, $q);
$d = mysqli_fetch_assoc($r);
if (!$d || $d['stok_barang'] < $jumlah) {
    // stok tidak cukup, kembali
    header("Location: daftar_barang.php");
    exit;
}

// inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// tambahkan atau tambahkan jumlah
if (isset($_SESSION['cart'][$id_barang])) {
    $_SESSION['cart'][$id_barang] += $jumlah;
} else {
    $_SESSION['cart'][$id_barang] = $jumlah;
}

header("Location: cart.php");
exit;