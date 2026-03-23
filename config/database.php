<?php
// konfigurasi koneksi database MySQL
// ubah nilai host/user/password/ database jika dipindah ke server lain
$host = "localhost";
$user = "root";
$password = "";
$database = "galon_depot_purnomo";

// buat koneksi global bernama $koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// jika gagal, hentikan eksekusi dan tampilkan pesan
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}