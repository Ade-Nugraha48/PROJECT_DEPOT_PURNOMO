<?php

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../functions/pengiriman_helper.php";

session_start();

$id_pengiriman = $_GET['id_pengiriman'];
$id_kurir = $_SESSION['id_user'];

// tandai pengiriman sedang dalam proses oleh kurir
mulai_pengiriman($koneksi, $id_pengiriman, $id_kurir);

header("Location: daftar_pengiriman.php");