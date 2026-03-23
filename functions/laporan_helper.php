<?php

function ambil_laporan_penjualan($koneksi, $tanggal_mulai, $tanggal_selesai)
{

$query = "SELECT 
transaksi.id_transaksi,
transaksi.total_harga,
transaksi.tanggal_transaksi,
pesanan.id_pesanan,
users.username

FROM transaksi
JOIN pesanan ON transaksi.id_pesanan = pesanan.id_pesanan
JOIN users ON pesanan.id_user = users.id_user

WHERE DATE(transaksi.tanggal_transaksi) 
BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'

ORDER BY transaksi.tanggal_transaksi DESC";

$result = mysqli_query($koneksi,$query);

return $result;

}


function hitung_total_penjualan($koneksi,$tanggal_mulai,$tanggal_selesai)
{

$query = "SELECT SUM(total_harga) as total_penjualan
FROM transaksi
WHERE DATE(tanggal_transaksi)
BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";

$result = mysqli_query($koneksi,$query);

$data = mysqli_fetch_assoc($result);

return $data['total_penjualan'];

}


function hitung_keuntungan($total_penjualan)
{

    $persentase_keuntungan = 0.20;

    $keuntungan = $total_penjualan * $persentase_keuntungan;

    return $keuntungan;
}

// menghitung jumlah transaksi yang diselesaikan pada rentang tanggal tertentu
function hitung_jumlah_transaksi($koneksi,$tanggal_mulai,$tanggal_selesai)
{
    $query = "SELECT COUNT(*) as total_transaksi
        FROM transaksi
        WHERE DATE(tanggal_transaksi)
        BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";

    $result = mysqli_query($koneksi,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['total_transaksi'];
}