<?php

require_once "../../includes/auth_middleware.php";
require_once "../../config/database.php";

$query = "SELECT 
transaksi.id_transaksi,
transaksi.total_harga,
transaksi.tanggal_transaksi,
pesanan.id_pesanan,
users.username

FROM transaksi
JOIN pesanan ON transaksi.id_pesanan = pesanan.id_pesanan
JOIN users ON pesanan.id_user = users.id_user
ORDER BY transaksi.tanggal_transaksi DESC";

$result = mysqli_query($koneksi,$query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitoring Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/admin.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard_admin.php"><img src="../../assets/images/navbar_logo.png" alt="Depot Purnomo" height="30" class="d-inline-block align-text-top"> Depot Purnomo</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard_admin.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="daftar_pesanan.php">Pesanan</a></li>
                <li class="nav-item"><a class="nav-link" href="manajemen_stok.php">Stok</a></li>
                <li class="nav-item"><a class="nav-link" href="laporan_penjualan.php">Laporan</a></li>
                <li class="nav-item"><a class="nav-link" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-container">
    <h2 class="mb-4">Monitoring Transaksi</h2>
    <?php while($data = mysqli_fetch_assoc($result)) { ?>
        <div class="card card-custom mb-3 p-3">
            <strong>ID Transaksi:</strong> <?php echo $data['id_transaksi']; ?><br>
            <strong>Pesanan:</strong> <?php echo $data['id_pesanan']; ?><br>
            <strong>Pelanggan:</strong> <?php echo $data['username']; ?><br>
            <strong>Total:</strong> <?php echo $data['total_harga']; ?><br>
            <strong>Tanggal:</strong> <?php echo $data['tanggal_transaksi']; ?>
        </div>
    <?php } ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>