<?php
// proses saat admin men-submit form tambah barang
require_once "../../config/database.php";

// ambil dan bersihkan input sederhana
$nama = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
$harga = intval($_POST['harga_barang']);
$stok = intval($_POST['stok_barang']);
$gambarPath = null;

// jika ada file gambar, pindahkan ke folder assets/images
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['gambar']['tmp_name'];
    $origName = basename($_FILES['gambar']['name']);
    $ext = pathinfo($origName, PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','gif'];
    if (in_array(strtolower($ext), $allowed)) {
        $newName = uniqid('img_').".".$ext;
        $dest = __DIR__ . "/../../assets/images/" . $newName;
        if (move_uploaded_file($tmp, $dest)) {
            $gambarPath = $newName;
        }
    }
}

// bangun query INSERT dinamis sesuai ada/tidaknya gambar
$query = "INSERT INTO barang (nama_barang, harga_barang, stok_barang";
if ($gambarPath !== null) {
    $query .= ", gambar";
}
$query .= ") VALUES ('{$nama}', {$harga}, {$stok}";
if ($gambarPath !== null) {
    $query .= ", '{$gambarPath}'";
}
$query .= ")";

mysqli_query($koneksi, $query);
// kembali ke daftar stok
header("Location: manajemen_stok.php");
exit;