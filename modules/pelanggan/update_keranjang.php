<?php
session_start();
require_once __DIR__ . "/../../includes/auth_middleware.php";

$id_barang = intval($_POST['id_barang'] ?? 0);
$jumlah = intval($_POST['jumlah'] ?? 0);

if ($id_barang > 0) {
    if ($jumlah > 0) {
        $_SESSION['cart'][$id_barang] = $jumlah;
    } else {
        unset($_SESSION['cart'][$id_barang]);
    }
}

header("Location: cart.php");
exit;