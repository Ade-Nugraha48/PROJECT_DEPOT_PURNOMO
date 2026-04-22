<?php
// skrip ini menangani proses login: memeriksa username/password
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../functions/auth_helper.php";

// ambil masukan dan bersihkan username
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = $_POST['password'];

// cari user di database
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);

$loginSuccess = false;

if ($user) {
    $stored = $user['password'];

    // jika hash cocok, login sukses
    if (password_verify($password, $stored)) {
        // jika perlu rehash, perbarui di DB
        if (password_needs_rehash($stored, PASSWORD_DEFAULT)) {
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($koneksi, "UPDATE users SET password='$newHash' WHERE id_user='{$user['id_user']}'");
        }
        $loginSuccess = true;
    } elseif ($password === $stored) {
        // kasus lama: password tersimpan dalam teks biasa
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($koneksi, "UPDATE users SET password='$newHash' WHERE id_user='{$user['id_user']}'");
        $loginSuccess = true;
    }
}

if ($loginSuccess) {
    // buat sesi dan catat aktivitas
    login_user($user);

    require_once __DIR__ . "/../../functions/transaksi_helper.php";
    catat_log($koneksi, $user['id_user'], "login ke sistem");

    // kirim ke dashboard sesuai peran
    arahkan_dashboard();
    exit;
} else {
    echo "Login gagal"; // bisa diganti dengan redirect dengan pesan
}