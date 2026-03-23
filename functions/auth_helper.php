<?php
// fungsi-fungsi bantu untuk manajemen sesi dan otentikasi pengguna

function login_user($data_user)
{
    // memulai sesi lalu menyimpan informasi penting pengguna
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['id_user'] = $data_user['id_user'];
    $_SESSION['username'] = $data_user['username'];
    $_SESSION['id_role'] = $data_user['id_role'];
}

function logout_user()
{
    // hapus semua data sesi dan akhiri sesi
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_destroy();
}

function cek_login()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // jika tidak ada id_user di sesi, berarti belum login
    if (!isset($_SESSION['id_user'])) {
        // redirect to login menggunakan path absolut localhost
        header("Location: http://localhost/PROJECT_DEPOT_PURNOMO/modules/auth/login.php");
        exit;
    }
}

function arahkan_dashboard()
{
    // pengguna dialihkan ke dashboard sesuai perannya
    if ($_SESSION['id_role'] == 1) {
        header("Location: http://localhost/PROJECT_DEPOT_PURNOMO/modules/admin/dashboard_admin.php");
    }

    if ($_SESSION['id_role'] == 2) {
        header("Location: http://localhost/PROJECT_DEPOT_PURNOMO/modules/pelanggan/dashboard_pelanggan.php");
    }

    if ($_SESSION['id_role'] == 3) {
        header("Location: http://localhost/PROJECT_DEPOT_PURNOMO/modules/kurir/dashboard_kurir.php");
    }

    if ($_SESSION['id_role'] == 4) {
        header("Location: http://localhost/PROJECT_DEPOT_PURNOMO/modules/owner/dashboard_owner.php");
    }
}