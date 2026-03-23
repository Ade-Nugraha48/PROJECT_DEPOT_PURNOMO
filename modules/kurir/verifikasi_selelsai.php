<?php

require_once "../../config/database.php";
require_once "../../functions/pengiriman_helper.php";

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

echo "pesanan selesai";

require_once "../../functions/transaksi_helper.php";

$id_pengiriman = $_GET['id_pengiriman'];

$query = "SELECT id_pesanan 
          FROM pengiriman
          WHERE id_pengiriman='$id_pengiriman'";

$result = mysqli_query($koneksi,$query);

$data = mysqli_fetch_assoc($result);

$id_pesanan = $data['id_pesanan'];

catat_transaksi($koneksi,$id_pesanan);