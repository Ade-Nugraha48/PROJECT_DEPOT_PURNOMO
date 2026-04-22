<?php
// skrip untuk menghapus barang dari database (dipanggil via POST)
require_once __DIR__ . "/../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_barang']);
    // jika ada gambar terkait, hapus filenya
    $q0 = "SELECT gambar FROM barang WHERE id_barang = $id";
    $r0 = mysqli_query($koneksi, $q0);
    if ($r0) {
        $b0 = mysqli_fetch_assoc($r0);
        if ($b0 && !empty($b0['gambar'])) {
            @unlink(__DIR__ . "/../../assets/images/" . $b0['gambar']);
        }
    }
    // lakukan query DELETE
    $query = "DELETE FROM barang WHERE id_barang = $id";
    mysqli_query($koneksi, $query);
}

header("Location: manajemen_stok.php");
exit;