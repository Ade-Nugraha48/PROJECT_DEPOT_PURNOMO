<?php
// skrip pendaftaran akun baru pelanggan
require_once "../../config/database.php";
require_once "../../functions/validasi_helper.php";

// bersihkan input untuk menghindari XSS dan whitespace
$username = bersihkan_input($_POST['username']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password sebelum simpan
$no_telp = bersihkan_input($_POST['no_telp']);

$id_role = 2; // pelanggan (nilai tetap)

// simpan ke tabel users
$query = "INSERT INTO users 
(username, password, no_telp, id_role) 
VALUES 
('$username','$password','$no_telp','$id_role')";

mysqli_query($koneksi, $query);

// setelah registrasi selesai, kembali ke halaman login
header("Location: login.php");