<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

// Statistik untuk Owner
// 1. Total Pendapatan Bulan Ini
$q_pendapatan = mysqli_query($koneksi, "SELECT SUM(total_harga) as total FROM transaksi WHERE MONTH(tanggal_transaksi) = MONTH(CURRENT_DATE())");
$data_pendapatan = mysqli_fetch_assoc($q_pendapatan);

// 2. Total Pesanan Selesai (Bulan Ini)
$q_orders = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pesanan WHERE status_pesanan = 'selesai' AND MONTH(tanggal_pesanan) = MONTH(CURRENT_DATE())");
$data_orders = mysqli_fetch_assoc($q_orders);

// 3. Produk Terlaris (Opsional sebagai pengganti pelanggan)
$q_top = mysqli_query($koneksi, "SELECT barang.nama_barang, SUM(detail_pesanan.jumlah) as qty 
    FROM detail_pesanan 
    JOIN barang ON detail_pesanan.id_barang = barang.id_barang 
    GROUP BY barang.id_barang ORDER BY qty DESC LIMIT 1");
$data_top = mysqli_fetch_assoc($q_top);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Owner Dashboard | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary: #1a252f; --gold: #f1c40f; --bg-light: #f4f7f6; }
        body { background-color: var(--bg-light); font-family: 'Inter', sans-serif; }
        
        .navbar-owner { background: var(--primary); padding: 1rem 0; }
        .navbar-owner .navbar-brand { color: #fff !important; font-weight: 800; letter-spacing: 1px; }

        .owner-header {
            background: linear-gradient(135deg, #1a252f 0%, #2c3e50 100%);
            color: white;
            border-radius: 24px;
            padding: 40px;
            margin-top: 25px;
            margin-bottom: 35px;
            position: relative;
            overflow: hidden;
        }

        .stat-card {
            border: none;
            border-radius: 20px;
            padding: 30px;
            background: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.03);
            height: 100%;
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .text-gold { color: #f1c40f; }
        .bg-soft-gold { background: #fef9c3; color: #a16207; }
        .bg-soft-green { background: #dcfce7; color: #15803d; }
        .bg-soft-blue { background: #dbeafe; color: #1d4ed8; }

        .report-link {
            text-decoration: none;
            transition: all 0.3s;
        }
        .report-link:hover .stat-card {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-owner">
    <div class="container">
        <a class="navbar-brand" href="#">DEPOT PURNOMO <span class="text-gold">OWNER</span></a>
        <div class="ms-auto">
            <a href="../auth/logout.php" class="btn btn-outline-light btn-sm rounded-pill px-4">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="owner-header">
        <h1 class="fw-bold">Ikhtisar Performa</h1>
        <p class="opacity-75">Data penjualan dan pendapatan real-time bulan ini.</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <a href="laporan_owner.php" class="report-link">
                <div class="stat-card">
                    <div class="icon-circle bg-soft-green">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <h6 class="text-muted fw-bold mb-1 small">TOTAL PENDAPATAN BULAN INI</h6>
                    <h2 class="fw-bold text-dark">Rp <?= number_format($data_pendapatan['total'] ?? 0, 0, ',', '.') ?></h2>
                    <p class="text-success small mb-0 mt-2"><i class="bi bi-graph-up-arrow me-1"></i> Berdasarkan transaksi selesai</p>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="laporan_owner.php" class="report-link">
                <div class="stat-card">
                    <div class="icon-circle bg-soft-blue">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <h6 class="text-muted fw-bold mb-1 small">VOLUME PENJUALAN</h6>
                    <h2 class="fw-bold text-dark"><?= $data_orders['total'] ?> <span class="fs-5 fw-normal text-muted">Pesanan</span></h2>
                    <p class="text-primary small mb-0 mt-2"><i class="bi bi-calendar-event me-1"></i> Periode: <?= date('F Y') ?></p>
                </div>
            </a>
        </div>

        <div class="col-12">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-soft-gold mb-0 me-4">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-bold mb-1 small">PRODUK TERLARIS</h6>
                        <h4 class="fw-bold mb-0"><?= $data_top['nama_barang'] ?? 'Belum ada data' ?></h4>
                    </div>
                </div>
                <div class="text-end d-none d-md-block">
                    <span class="badge bg-soft-gold px-3 py-2 rounded-pill text-dark fw-bold">
                        Terjual <?= $data_top['qty'] ?? 0 ?> Unit
                    </span>
                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-4 px-2">Menu Laporan</h5>
    <div class="row g-3">
        <div class="col-md-4">
            <a href="laporan_owner.php" class="btn btn-white w-100 p-4 shadow-sm rounded-4 text-start border-0">
                <i class="bi bi-file-earmark-pdf text-danger fs-3 d-block mb-2"></i>
                <span class="fw-bold d-block">Laporan Penjualan</span>
                <span class="text-muted small">Lihat detail transaksi harian</span>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>