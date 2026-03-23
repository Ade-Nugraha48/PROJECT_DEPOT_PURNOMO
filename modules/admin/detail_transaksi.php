<?php

require_once "../../config/database.php";

$id_pesanan = $_GET['id_pesanan'];

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
    <title>Detail Transaksi</title>
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
                <li class="nav-item"><a class="nav-link" href="monitoring_transaksi.php">Transaksi</a></li>
                <li class="nav-item"><a class="nav-link" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-container">
    <h2 class="mb-4">Detail Transaksi</h2>
    <?php while($data = mysqli_fetch_assoc($result)) { ?>
        <div class="card card-custom mb-3 p-3">
            <strong>Barang:</strong> <?php echo $data['nama_barang']; ?><br>
            <strong>Jumlah:</strong> <?php echo $data['jumlah']; ?><br>
            <strong>Harga:</strong> <?php echo $data['harga_satuan']; ?>
        </div>
    <?php } ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>