<?php

// helper untuk memperbarui stok dan mencatatnya di tabel log_stok
function kurangi_stok($koneksi, $id_barang, $jumlah)
{
    // kurangi jumlah di tabel barang
    $query = "UPDATE barang 
              SET stok_barang = stok_barang - $jumlah
              WHERE id_barang = '$id_barang'";

    mysqli_query($koneksi, $query);

    // catat perubahan ke tabel log_stok dengan keterangan standar
    $query_log = "INSERT INTO log_stok
    (id_barang, perubahan_stok, tipe_perubahan, keterangan)
    VALUES
    ('$id_barang','$jumlah','pengurangan','stok berkurang karena pesanan')";

    mysqli_query($koneksi, $query_log);
}


function tambah_stok($koneksi, $id_barang, $jumlah)
{
    // tambah stok barang
    $query = "UPDATE barang 
              SET stok_barang = stok_barang + $jumlah
              WHERE id_barang = '$id_barang'";

    mysqli_query($koneksi, $query);

    // log penambahan manual oleh admin
    $query_log = "INSERT INTO log_stok
    (id_barang, perubahan_stok, tipe_perubahan, keterangan)
    VALUES
    ('$id_barang','$jumlah','penambahan','update manual admin')";

    mysqli_query($koneksi, $query_log);
}