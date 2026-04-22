<?php

require_once "../../includes/auth_middleware.php";
require_once "../../config/database.php";

$id_pesanan = intval($_GET['id_pesanan'] ?? 0);

// pastikan pesanan terkait berada di pengiriman milik kurir (opsional)
$q0 = "SELECT p.id_pesanan FROM pesanan p
        JOIN pengiriman pg ON p.id_pesanan = pg.id_pesanan
        WHERE p.id_pesanan = $id_pesanan";
$r0 = mysqli_query($koneksi, $q0);
// tidak divalidasi lebih lanjut dalam contoh ini

$query = "SELECT 
    barang.nama_barang,
    detail_pesanan.jumlah,
    detail_pesanan.harga_satuan
FROM detail_pesanan
JOIN barang ON detail_pesanan.id_barang = barang.id_barang
WHERE id_pesanan='$id_pesanan'";

$result = mysqli_query($koneksi,$query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/dark-mode.css" rel="stylesheet">
    <link href="../../assets/css/kurir.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard_kurir.php"><img src="../../assets/images/navbar_logo.png" alt="Depot Purnomo" height="30" class="d-inline-block align-text-top"> Depot Purnomo</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="daftar_pengiriman.php">Pengiriman Masuk</a></li>
                <li class="nav-item"><a class="nav-link" href="history_pengiriman.php">History</a></li>
                <li class="nav-item"><a class="nav-link" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-container">
    <h2 class="mb-4">Detail Pesanan #<?php echo $id_pesanan; ?></h2>
    <?php
    $total_qty = 0;
    $total_price = 0;
    while($data = mysqli_fetch_assoc($result)) {
        $total_qty += $data['jumlah'];
        $total_price += $data['jumlah'] * $data['harga_satuan'];
    ?>
        <div class="card card-custom mb-3 p-3">
            <strong>Barang:</strong> <?php echo $data['nama_barang']; ?><br>
            <strong>Jumlah:</strong> <?php echo $data['jumlah']; ?><br>
            <strong>Harga:</strong> <?php echo $data['harga_satuan']; ?>
        </div>
    <?php } ?>
    <div class="card card-custom p-3">
        <strong>Total Jumlah:</strong> <?php echo $total_qty; ?><br>
        <strong>Total Harga:</strong> <?php echo $total_price; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/dark-mode.js"></script>
</body>
</html>