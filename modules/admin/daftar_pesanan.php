<?php

require_once "../../includes/auth_middleware.php";
require_once "../../config/database.php";

$query = "SELECT 
pesanan.id_pesanan,
users.username,
pesanan.status_pesanan,
pesanan.tanggal_pesanan
FROM pesanan
JOIN users ON pesanan.id_user = users.id_user
ORDER BY pesanan.tanggal_pesanan DESC";

$result = mysqli_query($koneksi, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/dark-mode.css" rel="stylesheet">
    <link href="../../assets/css/admin.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard_admin.php"><img src="../../assets/images/navbar_logo.png" alt="Depot Purnomo" height="30" class="d-inline-block align-text-top"> Depot Purnomo</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard_admin.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="manajemen_stok.php">Stok</a></li>
                <li class="nav-item"><a class="nav-link" href="monitoring_transaksi.php">Transaksi</a></li>
                <li class="nav-item"><a class="nav-link" href="laporan_penjualan.php">Laporan</a></li>
                <li class="nav-item"><a class="nav-link" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-container">
    <h2 class="mb-4">Daftar Pesanan</h2>
    <?php while($data = mysqli_fetch_assoc($result)) { ?>
        <div class="card card-custom mb-3 p-3">
            <strong>ID Pesanan:</strong> <?php echo $data['id_pesanan']; ?><br>
            <strong>Pelanggan:</strong> <?php echo $data['username']; ?><br>
            <strong>Status:</strong> <?php echo $data['status_pesanan']; ?><br>
            <a href="detail_transaksi.php?id_pesanan=<?php echo $data['id_pesanan']; ?>" class="btn btn-outline-secondary mt-2 me-2">Lihat Detail</a>
            <?php // hanya tampilkan tombol validasi & tolak jika pesanan belum selesai atau ditolak ?>
            <?php if($data['status_pesanan'] !== 'selesai' && $data['status_pesanan'] !== 'ditolak') { ?>
                <a href="validasi_pesanan.php?id_pesanan=<?php echo $data['id_pesanan']; ?>" class="btn btn-primary mt-2 me-2">Validasi Pesanan</a>
                <a href="tolak_pesanan.php?id_pesanan=<?php echo $data['id_pesanan']; ?>" class="btn btn-danger mt-2">Tolak Pesanan</a>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/dark-mode.js"></script>
</body>
</html>