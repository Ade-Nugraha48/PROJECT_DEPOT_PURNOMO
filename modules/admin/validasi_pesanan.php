<?php

require_once "../../config/database.php";
require_once "../../functions/stok_helper.php";

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

echo "pesanan berhasil divalidasi";

require_once "../../functions/pengiriman_helper.php";

buat_pengiriman($koneksi, $id_pesanan);