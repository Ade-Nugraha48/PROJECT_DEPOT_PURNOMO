<?php
// helper sederhana untuk membersihkan input pengguna dari karakter berbahaya
function bersihkan_input($data)
{
    $data = trim($data);        // hapus spasi di awal/akhir
    $data = htmlspecialchars($data); // konversi karakter khusus HTML
    return $data;
}