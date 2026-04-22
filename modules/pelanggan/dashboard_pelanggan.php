<?php
require_once "../../includes/auth_middleware.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/dark-mode.css" rel="stylesheet">
    <link href="../../assets/css/pelanggan.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="../../assets/images/navbar_logo.png" alt="Depot Purnomo" height="30" class="d-inline-block align-text-top"> Depot Purnomo</a>
        <?php $cart_count = array_sum($_SESSION['cart'] ?? []); ?>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="cart.php">Keranjang <?php if($cart_count>0) echo '<span class="badge bg-light text-dark">'.$cart_count.'</span>'; ?></a></li>
                <li class="nav-item"><a class="nav-link" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-container">
    <h1 class="mb-4"><img src="../../assets/images/logo_depot_purnomo.png" alt="Logo" height="40" class="me-2">Dashboard Pelanggan</h1>
    <div class="list-group">
        <a class="list-group-item list-group-item-action" href="daftar_barang.php">Pesan Galon</a>
        <a class="list-group-item list-group-item-action" href="status_pesanan.php">Status Pesanan</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/dark-mode.js"></script>
</body>
</html>