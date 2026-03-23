<?php

function buat_pengiriman($koneksi, $id_pesanan)
{
    $query = "INSERT INTO pengiriman
    (id_pesanan,status_pengiriman)
    VALUES
    ('$id_pesanan','menunggu_kurir')";

    mysqli_query($koneksi, $query);
}


function mulai_pengiriman($koneksi, $id_pengiriman, $id_kurir)
{
    $query = "UPDATE pengiriman
    SET 
    id_kurir='$id_kurir',
    status_pengiriman='dalam_pengiriman',
    waktu_mulai=NOW()
    WHERE id_pengiriman='$id_pengiriman'";

    mysqli_query($koneksi, $query);
}


function selesai_pengiriman($koneksi, $id_pengiriman)
{
    $query = "UPDATE pengiriman
    SET 
    status_pengiriman='selesai',
    waktu_selesai=NOW()
    WHERE id_pengiriman='$id_pengiriman'";

    mysqli_query($koneksi, $query);
}