<?php
session_start();
require_once __DIR__ . "/../../includes/auth_middleware.php";

$id_barang = intval($_GET['id_barang'] ?? 0);
if ($id_barang > 0 && isset($_SESSION['cart'][$id_barang])) {
    unset($_SESSION['cart'][$id_barang]);
}

header("Location: cart.php");
exit;