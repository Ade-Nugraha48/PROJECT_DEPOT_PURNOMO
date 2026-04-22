<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

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

$result = mysqli_query($koneksi, $query);

// Menghitung total pendapatan (opsional tapi sangat berguna untuk monitoring)
$total_pendapatan = 0;
$query_total = "SELECT SUM(total_harga) as total FROM transaksi";
$res_total = mysqli_query($koneksi, $query_total);
if($row = mysqli_fetch_assoc($res_total)) {
    $total_pendapatan = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitoring Transaksi | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .main-container { padding: 2rem; }
        .stats-card {
            background: linear-gradient(45deg, #2c3e50, #34495e);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            border: none;
        }
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            padding: 20px;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        .price-text { font-weight: 700; color: #2ecc71; }
        .id-badge { background: #e9ecef; color: #495057; font-family: monospace; padding: 4px 8px; border-radius: 5px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard_admin.php">DEPOT PURNOMO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard_admin.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="daftar_pesanan.php">Pesanan</a></li>
                <li class="nav-item"><a class="nav-link" href="manajemen_stok.php">Stok</a></li>
                <li class="nav-item"><a class="nav-link active" href="monitoring_transaksi.php">Transaksi</a></li>
                <li class="nav-item"><a class="nav-link btn btn-outline-danger btn-sm ms-lg-3" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container main-container">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="fw-bold">Monitoring Transaksi</h2>
            <p class="text-muted">Riwayat pembayaran sukses dari pelanggan.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stats-card shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="fs-1 me-3"><i class="bi bi-wallet2"></i></div>
                    <div>
                        <div class="text-uppercase small" style="opacity: 0.8">Total Pendapatan</div>
                        <h3 class="fw-bold mb-0">Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Tanggal & Waktu</th>
                        <th class="text-end">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($data = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><span class="id-badge">TRX-<?php echo $data['id_transaksi']; ?></span></td>
                        <td><span class="text-muted">#<?php echo $data['id_pesanan']; ?></span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-circle me-2 text-secondary"></i>
                                <span class="fw-medium"><?php echo htmlspecialchars($data['username']); ?></span>
                            </div>
                        </td>
                        <td><?php echo date('d/m/Y H:i', strtotime($data['tanggal_transaksi'])); ?></td>
                        <td class="text-end price-text">
                            Rp <?php echo number_format($data['total_harga'], 0, ',', '.'); ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>