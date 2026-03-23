<?php

function cek_stok_barang($koneksi, $id_barang, $jumlah)
{
    $query = "SELECT stok_barang FROM barang WHERE id_barang='$id_barang'";
    $result = mysqli_query($koneksi, $query);

    $data = mysqli_fetch_assoc($result);

    if ($data['stok_barang'] >= $jumlah) {
        return true;
    }

    return false;
}