<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

// Query ambil data transaksi
$query = "SELECT id_transaksi, id_pesanan, total_harga, tanggal_transaksi 
          FROM transaksi ORDER BY tanggal_transaksi DESC";
$data_laporan = mysqli_query($koneksi, $query);

// Query ambil total ringkasan
$query_total = "SELECT SUM(total_harga) as total_penjualan, COUNT(*) as jumlah_transaksi FROM transaksi";
$result_total = mysqli_query($koneksi, $query_total);
$data_total = mysqli_fetch_assoc($result_total);

$total_penjualan = $data_total['total_penjualan'] ?? 0;
$jumlah_transaksi = $data_total['jumlah_transaksi'] ?? 0;
$total_keuntungan = $total_penjualan * 0.20; // Margin 20%
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Transaksi | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary: #2c3e50; --accent: #27ae60; }
        body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        
        .header-print { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        
        /* Ringkasan Styling */
        .summary-box {
            background: white;
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 20px;
            height: 100%;
            border-bottom: 4px solid transparent;
        }
        .border-blue { border-bottom-color: #3498db; }
        .border-green { border-bottom-color: #2ecc71; }
        .border-gold { border-bottom-color: #f1c40f; }

        /* Table Styling */
        .table-custom {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .table-custom thead {
            background: var(--primary);
            color: white;
        }
        .table-custom th { font-weight: 600; padding: 15px; border: none; }
        .table-custom td { padding: 15px; vertical-align: middle; }

        @media print {
            .btn-print, .nav-back { display: none !important; }
            body { background: white; }
            .summary-box { box-shadow: none; border: 1px solid #eee; }
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="nav-back">
            <a href="dashboard_owner.php" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i> Dashboard
            </a>
        </div>
        <button onclick="window.print()" class="btn btn-primary btn-print rounded-pill px-4 shadow">
            <i class="bi bi-printer me-2"></i> Cetak Laporan
        </button>
    </div>

    <div class="header-print text-center d-block mb-5">
        <h2 class="fw-bold text-uppercase" style="letter-spacing: 2px;">Laporan Transaksi Penjualan</h2>
        <p class="text-muted">Depot Air Minum Purnomo - Update Per: <?= date('d F Y') ?></p>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="summary-box border-blue text-center">
                <p class="text-muted small fw-bold mb-1">TOTAL TRANSAKSI</p>
                <h3 class="fw-bold mb-0"><?= $jumlah_transaksi ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-box border-green text-center">
                <p class="text-muted small fw-bold mb-1">TOTAL PENJUALAN (OMSET)</p>
                <h3 class="fw-bold mb-0 text-success">Rp <?= number_format($total_penjualan, 0, ',', '.') ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-box border-gold text-center">
                <p class="text-muted small fw-bold mb-1">ESTIMASI PROFIT (20%)</p>
                <h3 class="fw-bold mb-0 text-primary">Rp <?= number_format($total_keuntungan, 0, ',', '.') ?></h3>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-custom table-hover">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>ID Transaksi</th>
                    <th>ID Pesanan</th>
                    <th>Tanggal & Waktu</th>
                    <th class="text-end">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if (mysqli_num_rows($data_laporan) > 0): 
                    while($data = mysqli_fetch_assoc($data_laporan)): 
                ?>
                    <tr>
                        <td class="text-center text-muted"><?= $no++ ?></td>
                        <td class="fw-bold">#TRX-<?= $data['id_transaksi'] ?></td>
                        <td><span class="badge bg-light text-dark">PSN-<?= $data['id_pesanan'] ?></span></td>
                        <td><?= date('d M Y, H:i', strtotime($data['tanggal_transaksi'])) ?></td>
                        <td class="text-end fw-bold text-dark">Rp <?= number_format($data['total_harga'], 0, ',', '.') ?></td>
                    </tr>
                <?php 
                    endwhile; 
                else: 
                ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada data transaksi yang tercatat.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>