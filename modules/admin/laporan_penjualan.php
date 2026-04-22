<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../functions/laporan_helper.php";

$tanggal_mulai = $_GET['tanggal_mulai'] ?? date("Y-m-01");
$tanggal_selesai = $_GET['tanggal_selesai'] ?? date("Y-m-d");

$data_laporan = ambil_laporan_penjualan($koneksi, $tanggal_mulai, $tanggal_selesai);
$total_penjualan = hitung_total_penjualan($koneksi, $tanggal_mulai, $tanggal_selesai) ?? 0;
$total_keuntungan = hitung_keuntungan($total_penjualan) ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Penjualan | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f4f7f6; }
        .main-container { padding: 2rem; max-width: 1200px; margin: auto; }
        .stat-card {
            border: none;
            border-radius: 15px;
            padding: 1.5rem;
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .bg-gradient-primary { background: linear-gradient(45deg, #4e73df, #224abe); }
        .bg-gradient-success { background: linear-gradient(45deg, #1cc88a, #13855c); }
        .report-table-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .filter-section {
            background: #fff;
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            border: 1px solid #e3e6f0;
        }
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
                <li class="nav-item"><a class="nav-link" href="monitoring_transaksi.php">Transaksi</a></li>
                <li class="nav-item"><a class="nav-link btn btn-outline-danger btn-sm ms-lg-3" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark"><i class="bi bi-file-earmark-bar-graph me-2"></i>Laporan Penjualan</h2>
        <a href="dashboard_admin.php" class="btn btn-outline-secondary btn-sm">Kembali ke Dashboard</a>
    </div>

    <section class="filter-section shadow-sm">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="<?php echo $tanggal_mulai; ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" value="<?php echo $tanggal_selesai; ?>">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter me-1"></i> Tampilkan Laporan
                </button>
                <a href="export_laporan.php?tanggal_mulai=<?php echo $tanggal_mulai; ?>&tanggal_selesai=<?php echo $tanggal_selesai; ?>" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Export
                </a>
            </div>
        </form>
    </section>

    <div class="row g-4 mb-4 text-center">
        <div class="col-md-6">
            <div class="stat-card bg-gradient-primary">
                <div class="small opacity-75">TOTAL OMZET (PENJUALAN)</div>
                <h2 class="fw-bold mb-0">Rp <?php echo number_format($total_penjualan, 0, ',', '.'); ?></h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card bg-gradient-success">
                <div class="small opacity-75">ESTIMASI KEUNTUNGAN</div>
                <h2 class="fw-bold mb-0">Rp <?php echo number_format($total_keuntungan, 0, ',', '.'); ?></h2>
            </div>
        </div>
    </div>

    <div class="report-table-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Pelanggan</th>
                        <th>Tanggal Selesai</th>
                        <th class="text-end">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($data_laporan) > 0): ?>
                        <?php while($data = mysqli_fetch_assoc($data_laporan)): ?>
                        <tr>
                            <td class="fw-bold text-muted">TRX-<?php echo $data['id_transaksi']; ?></td>
                            <td><?php echo htmlspecialchars($data['username']); ?></td>
                            <td><?php echo date('d M Y', strtotime($data['tanggal_selesai'])); ?></td>
                            <td class="text-end fw-bold">Rp <?php echo number_format($data['total_harga'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Tidak ada data untuk periode yang dipilih.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>