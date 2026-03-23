<?php

require_once "../../config/database.php";
require_once "../../functions/laporan_helper.php";

$tanggal_mulai = date("Y-m-01");
$tanggal_selesai = date("Y-m-d");

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

// jumlah transaksi selesai di periode
$total_transaksi = hitung_jumlah_transaksi(
    $koneksi,
    $tanggal_mulai,
    $tanggal_selesai
);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Owner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/owner.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard_owner.php"><img src="../../assets/images/navbar_logo.png" alt="Depot Purnomo" height="30" class="d-inline-block align-text-top"> Depot Purnomo</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard_owner.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-container">
    <h2 class="mb-4">Laporan Owner</h2>

    <?php while($data = mysqli_fetch_assoc($data_laporan)) { ?>
        <div class="card card-custom p-3 mb-3">
            <p><strong>Transaksi:</strong> <?php echo $data['id_transaksi']; ?></p>
            <p><strong>Total:</strong> <?php echo $data['total_harga']; ?></p>
            <p><strong>Tanggal:</strong> <?php echo $data['tanggal_transaksi']; ?></p>
        </div>
    <?php } ?>

    <h3>Total Transaksi : <?php echo $total_transaksi; ?></h3>
    <h3>Total Penjualan : <?php echo $total_penjualan; ?></h3>
    <h3>Total Keuntungan : <?php echo $total_keuntungan; ?></h3>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>