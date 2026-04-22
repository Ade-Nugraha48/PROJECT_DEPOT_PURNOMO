<?php

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../functions/pengiriman_helper.php";

$id_pengiriman = $_GET['id_pengiriman'];

selesai_pengiriman($koneksi, $id_pengiriman);

$query = "UPDATE pesanan
SET status_pesanan='selesai'
WHERE id_pesanan =
(
SELECT id_pesanan FROM pengiriman 
WHERE id_pengiriman='$id_pengiriman'
)";

mysqli_query($koneksi, $query);

// Redirect kembali ke daftar pengiriman dengan pesan sukses
header("Location: daftar_pengiriman.php?completed=1");
exit;