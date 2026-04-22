<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

$id_pesanan = mysqli_real_escape_string($koneksi, $_GET['id_pesanan']);

// Ambil info dasar pesanan (tanggal & nama pelanggan)
$query_info = "SELECT pesanan.tanggal_pesanan, users.username 
               FROM pesanan 
               JOIN users ON pesanan.id_user = users.id_user 
               WHERE pesanan.id_pesanan = '$id_pesanan'";
$res_info = mysqli_query($koneksi, $query_info);
$info = mysqli_fetch_assoc($res_info);

// Ambil rincian item
$query = "SELECT 
    barang.nama_barang,
    detail_pesanan.jumlah,
    detail_pesanan.harga_satuan
FROM detail_pesanan
JOIN barang ON detail_pesanan.id_barang = barang.id_barang
WHERE id_pesanan = '$id_pesanan'";

$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Transaksi #<?= $id_pesanan ?> | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --admin-bg: #f4f7f6; --dark-panel: #2c3e50; }
        body { background-color: var(--admin-bg); font-family: 'Inter', sans-serif; }
        .navbar-custom { background: var(--dark-panel); padding: 15px; }
        .navbar-brand, .nav-link { color: white !important; }
        
        .detail-card {
            background: white;
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .detail-header {
            background: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 20px;
        }
        .table-items thead {
            background: #f8f9fa;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }
        .total-row {
            background: #fdfdfd;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard_admin.php">DEPOT PURNOMO <span class="badge bg-primary ms-2" style="font-size: 0.6rem;">ADMIN</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard_admin.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="daftar_pesanan.php">Pesanan</a></li>
                <li class="nav-item"><a class="nav-link" href="monitoring_transaksi.php">Transaksi</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="../auth/logout.php"><i class="bi bi-box-arrow-right"></i></a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Detail Transaksi</h2>
            <p class="text-muted">ID Pesanan: #<?= $id_pesanan ?></p>
        </div>
        <a href="monitoring_transaksi.php" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card detail-card">
        <div class="detail-header">
            <div class="row">
                <div class="col-md-6">
                    <small class="text-muted d-block">Pelanggan</small>
                    <h5 class="fw-bold"><?= htmlspecialchars($info['username'] ?? 'Tidak Diketahui') ?></h5>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted d-block">Waktu Transaksi</small>
                    <h5 class="fw-bold"><?= date('d F Y, H:i', strtotime($info['tanggal_pesanan'])) ?></h5>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-items mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Nama Barang</th>
                        <th class="text-center">Harga Satuan</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end pe-4">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    while($data = mysqli_fetch_assoc($result)): 
                        $subtotal = $data['jumlah'] * $data['harga_satuan'];
                        $grand_total += $subtotal;
                    ?>
                    <tr>
                        <td class="ps-4 fw-medium"><?= $data['nama_barang'] ?></td>
                        <td class="text-center text-muted">Rp <?= number_format($data['harga_satuan'], 0, ',', '.') ?></td>
                        <td class="text-center font-monospace"><?= $data['jumlah'] ?></td>
                        <td class="text-end pe-4 fw-bold text-dark">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="3" class="text-end ps-4 py-3 fw-bold">TOTAL PEMBAYARAN</td>
                        <td class="text-end pe-4 py-3 fw-bold text-primary fs-5">Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <div class="mt-4 text-center">
        <button onclick="window.print()" class="btn btn-light text-muted border-0">
            <i class="bi bi-printer me-2"></i> Cetak Invoice
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>