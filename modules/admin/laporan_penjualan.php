<?php

require_once "../../includes/auth_middleware.php";
require_once "../../config/database.php";
require_once "../../functions/laporan_helper.php";

$tanggal_mulai = $_GET['tanggal_mulai'] ?? date("Y-m-01");
$tanggal_selesai = $_GET['tanggal_selesai'] ?? date("Y-m-d");

$data_laporan = ambil_laporan_penjualan(
    $koneksi,
    $tanggal_mulai,
    $tanggal_selesai
);

$total_penjualan = hitung_total_penjualan(
    $koneksi,
    $tanggal_mulai,
    $tanggal_selesai
);

$total_keuntungan = hitung_keuntungan($total_penjualan);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Penjualan</title>
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
    <h2 class="mb-4">Laporan Penjualan</h2>
    <form method="GET" class="row g-3 mb-3">
        <div class="col-auto">
            <input type="date" name="tanggal_mulai" class="form-control" value="<?php echo $tanggal_mulai; ?>">
        </div>
        <div class="col-auto">
            <input type="date" name="tanggal_selesai" class="form-control" value="<?php echo $tanggal_selesai; ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <?php while($data = mysqli_fetch_assoc($data_laporan)) { ?>
        <div class="card card-custom mb-3 p-3">
            <strong>ID Transaksi:</strong> <?php echo $data['id_transaksi']; ?><br>
            <strong>Pesanan:</strong> <?php echo $data['id_pesanan']; ?><br>
            <strong>Pelanggan:</strong> <?php echo $data['username']; ?><br>
            <strong>Total:</strong> <?php echo $data['total_harga']; ?><br>
            <strong>Tanggal:</strong> <?php echo $data['tanggal_transaksi']; ?>
        </div>
    <?php } ?>

    <h3>Total Penjualan : <?php echo $total_penjualan; ?></h3>
    <h3>Total Keuntungan : <?php echo $total_keuntungan; ?></h3>

    <a href="export_laporan.php?tanggal_mulai=<?php echo $tanggal_mulai; ?>&tanggal_selesai=<?php echo $tanggal_selesai; ?>" class="btn btn-secondary mt-3">
        Export Laporan
    </a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>