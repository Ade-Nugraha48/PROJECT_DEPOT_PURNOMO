<?php
// file ini adalah middleware sederhana untuk memeriksa pengguna sudah login atau belum
// jika belum terautentikasi, akan diarahkan ke halaman login
require_once __DIR__ . "/../functions/auth_helper.php";

cek_login();
// setelah cek_login() berhasil, skrip yang memanggil middleware dapat dijalankan