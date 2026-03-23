<?php
// skrip yang dijalankan saat pelanggan memesan barang
require_once "../../config/database.php";
require_once "../../functions/pesanan_helper.php";

session_start();

$id_user = $_SESSION['id_user'];

// gunakan keranjang dari sesi
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

// cek stok semua barang terlebih dahulu
foreach ($cart as $id_barang => $jumlah) {
    if (!cek_stok_barang($koneksi, $id_barang, $jumlah)) {
        die("stok tidak mencukupi untuk barang ID $id_barang");
    }
}

mysqli_begin_transaction($koneksi);

try {
    // buat entri pesanan utama
    $query_pesanan = "INSERT INTO pesanan (id_user, status_pesanan)
    VALUES ('$id_user','menunggu_pembayaran')";
    mysqli_query($koneksi, $query_pesanan);

    $id_pesanan = mysqli_insert_id($koneksi);

    // simpan detail semua barang di keranjang
    foreach ($cart as $id_barang => $jumlah) {
        $query_barang = "SELECT harga_barang FROM barang WHERE id_barang='$id_barang'";
        $result_barang = mysqli_query($koneksi, $query_barang);
        $data_barang = mysqli_fetch_assoc($result_barang);
        $harga = $data_barang['harga_barang'];

        $query_detail = "INSERT INTO detail_pesanan
        (id_pesanan,id_barang,jumlah,harga_satuan)
        VALUES
        ('$id_pesanan','$id_barang','$jumlah','$harga')";
        mysqli_query($koneksi, $query_detail);
    }

    // buat record pembayaran
    $query_pembayaran = "INSERT INTO pembayaran
    (id_pesanan,metode_pembayaran,status_pembayaran)
    VALUES
    ('$id_pesanan','qris','pending')";
    mysqli_query($koneksi, $query_pembayaran);

    mysqli_commit($koneksi);

    // kosongkan keranjang
    unset($_SESSION['cart']);

    header("Location: status_pesanan.php");

} catch (Exception $e) {
    mysqli_rollback($koneksi);
    echo "gagal membuat pesanan";
}