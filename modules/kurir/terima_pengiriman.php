<?php

require_once "../../config/database.php";
require_once "../../functions/pengiriman_helper.php";

session_start();

$id_pengiriman = $_GET['id_pengiriman'];
$id_kurir = $_SESSION['id_user'];

// tandai pengiriman sedang dalam proses oleh kurir
mulai_pengiriman($koneksi, $id_pengiriman, $id_kurir);

// ubah juga status pesanan menjadi selesai langsung saat kurir menerima
$query_up = "UPDATE pesanan
SET status_pesanan='selesai'
WHERE id_pesanan = (
    SELECT id_pesanan FROM pengiriman WHERE id_pengiriman='$id_pengiriman'
)";
mysqli_query($koneksi, $query_up);

header("Location: daftar_pengiriman.php");