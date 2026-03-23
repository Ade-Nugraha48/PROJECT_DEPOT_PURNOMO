<?php

require_once "../../includes/auth_middleware.php";
require_once "../../config/database.php";

// tampilkan semua pengiriman yang sudah selesai (riwayat kurir)
$query = "SELECT 
    pengiriman.id_pengiriman,
    pengiriman.status_pengiriman,
    pesanan.id_pesanan,
    users.username
FROM pengiriman
JOIN pesanan ON pengiriman.id_pesanan = pesanan.id_pesanan
JOIN users ON pesanan.id_user = users.id_user
WHERE pengiriman.status_pengiriman = 'selesai'";

$result = mysqli_query($koneksi, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pengiriman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <h2>Riwayat Pengiriman</h2>

    <?php while($data = mysqli_fetch_assoc($result)) { ?>
    <div class="card card-custom p-3 mb-3">
        <p><strong>ID Pengiriman:</strong> <?php echo $data['id_pengiriman']; ?></p>
        <p><strong>Pesanan:</strong> <?php echo $data['id_pesanan']; ?></p>
        <p><strong>Pelanggan:</strong> <?php echo $data['username']; ?></p>
        <p><strong>Status:</strong> <?php echo $data['status_pengiriman']; ?></p>
    </div>
    <?php } ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>