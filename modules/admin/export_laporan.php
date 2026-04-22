<?php

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../functions/laporan_helper.php";

$tanggal_mulai = $_GET['tanggal_mulai'];
$tanggal_selesai = $_GET['tanggal_selesai'];

$data_laporan = ambil_laporan_penjualan(
$koneksi,
$tanggal_mulai,
$tanggal_selesai
);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=laporan_penjualan.csv");

$output = fopen("php://output","w");

fputcsv($output,
[
"id_transaksi",
"id_pesanan",
"pelanggan",
"total_harga",
"tanggal_transaksi"
]);

while($data = mysqli_fetch_assoc($data_laporan))
{

fputcsv($output,
[
$data['id_transaksi'],
$data['id_pesanan'],
$data['username'],
$data['total_harga'],
$data['tanggal_transaksi']
]);

}

fclose($output);