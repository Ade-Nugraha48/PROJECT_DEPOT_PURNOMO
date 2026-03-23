<?php
// fungsi bantu terkait perhitungan dan pencatatan transaksi

function hitung_total_pesanan($koneksi, $id_pesanan)
{
    // ambil detail pesanan untuk menjumlahkan harga
    $query = "SELECT jumlah, harga_satuan 
              FROM detail_pesanan 
              WHERE id_pesanan='$id_pesanan'";

    $result = mysqli_query($koneksi, $query);

    $total = 0;

    while($data = mysqli_fetch_assoc($result))
    {
        $total += $data['jumlah'] * $data['harga_satuan'];
    }

    return $total;
}


function catat_transaksi($koneksi, $id_pesanan)
{
    // simpan ringkasan transaksi ke tabel transaksi
    $total = hitung_total_pesanan($koneksi, $id_pesanan);

    $query = "INSERT INTO transaksi
    (id_pesanan,total_harga)
    VALUES
    ('$id_pesanan','$total')";

    mysqli_query($koneksi, $query);
}


function catat_log($koneksi, $id_user, $aktivitas)
{
    // catat aktivitas pengguna ke tabel audit_log
    $query = "INSERT INTO audit_log
    (id_user,aktivitas)
    VALUES
    ('$id_user','$aktivitas')";

    mysqli_query($koneksi, $query);
}