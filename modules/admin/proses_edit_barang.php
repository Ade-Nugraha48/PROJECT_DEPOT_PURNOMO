<?php
// skrip untuk memproses perubahan data barang
require_once "../../config/database.php";

$id = intval($_POST['id_barang']);
$nama = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
$harga = intval($_POST['harga_barang']);
$stok = intval($_POST['stok_barang']);

// siapkan bagian SQL kalau ada gambar baru
$update_img_sql = '';
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['gambar']['tmp_name'];
    $origName = basename($_FILES['gambar']['name']);
    $ext = pathinfo($origName, PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','gif'];
    if (in_array(strtolower($ext), $allowed)) {
        $newName = uniqid('img_').".".$ext;
        $dest = __DIR__ . "/../../assets/images/" . $newName;
        if (move_uploaded_file($tmp, $dest)) {
            // hapus file lama dari server jika ada
            $q0 = "SELECT gambar FROM barang WHERE id_barang = $id";
            $r0 = mysqli_query($koneksi, $q0);
            if ($r0) {
                $b0 = mysqli_fetch_assoc($r0);
                if ($b0 && !empty($b0['gambar'])) {
                    @unlink(__DIR__ . "/../../assets/images/" . $b0['gambar']);
                }
            }
            $update_img_sql = ", gambar='".$newName."'";
        }
    }
}

// jalankan update dengan atau tanpa update_img_sql
$query = "UPDATE barang SET nama_barang='".$nama."', harga_barang={$harga}, stok_barang={$stok} {$update_img_sql} WHERE id_barang={$id}";
mysqli_query($koneksi, $query);
// kembali ke daftar
header("Location: manajemen_stok.php");
exit;