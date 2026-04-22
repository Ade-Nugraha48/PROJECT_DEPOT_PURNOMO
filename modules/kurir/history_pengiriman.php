<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

// Ambil riwayat pengiriman yang sudah selesai
$query = "SELECT 
    pengiriman.id_pengiriman,
    pengiriman.status_pengiriman,
    pesanan.id_pesanan,
    pesanan.alamat_lengkap,
    pesanan.tanggal_pesanan,
    users.username,
    users.no_telp
FROM pengiriman
JOIN pesanan ON pengiriman.id_pesanan = pesanan.id_pesanan
JOIN users ON pesanan.id_user = users.id_user
WHERE pengiriman.status_pengiriman = 'selesai'
ORDER BY pengiriman.id_pengiriman DESC";

$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Tugas | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --bg-body: #f4f7f6; --success-soft: #e8f5e9; }
        body { background-color: var(--bg-body); font-family: 'Inter', sans-serif; }
        
        .navbar-custom { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }

        .history-card {
            border: none;
            border-radius: 15px;
            background: white;
            border-left: 5px solid #2ecc71; /* Hijau indikator selesai */
            transition: opacity 0.3s;
        }
        
        .history-card .order-id {
            font-size: 0.75rem;
            font-weight: 800;
            color: #95a5a6;
            letter-spacing: 1px;
        }

        .done-badge {
            background: var(--success-soft);
            color: #2e7d32;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 50px;
            text-transform: uppercase;
        }

        .customer-name {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 2px;
        }

        .history-info {
            font-size: 0.85rem;
            color: #7f8c8d;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard_kurir.php">
            <i class="bi bi-clock-history me-2"></i> RIWAYAT TUGAS
        </a>
        <a href="dashboard_kurir.php" class="btn btn-light btn-sm rounded-pill">Dashboard</a>
    </div>
</nav>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Selesai Dikirim</h5>
        <span class="badge bg-secondary rounded-pill"><?= mysqli_num_rows($result) ?> Tugas</span>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while($data = mysqli_fetch_assoc($result)): ?>
        <div class="card history-card shadow-sm mb-3">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="order-id mb-1 text-uppercase">TRX-<?= $data['id_pesanan'] ?></div>
                        <div class="customer-name"><?= htmlspecialchars($data['username']) ?></div>
                        <div class="history-info">
                            <i class="bi bi-geo-alt me-1"></i> <?= htmlspecialchars($data['alamat_lengkap']) ?>
                        </div>
                    </div>
                    <div class="col-auto text-end">
                        <span class="done-badge mb-2 d-inline-block">
                            <i class="bi bi-check-lg me-1"></i> Selesai
                        </span>
                        <div class="small text-muted" style="font-size: 0.7rem;">
                            <?= date('d/m/y', strtotime($data['tanggal_pesanan'])) ?>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                    <a href="https://wa.me/<?= preg_replace('/^0/', '62', $data['no_telp']) ?>" class="text-decoration-none small text-success">
                        <i class="bi bi-whatsapp me-1"></i> Hubungi Lagi
                    </a>
                    <a href="detail_pesanan.php?id_pesanan=<?= $data['id_pesanan'] ?>" class="text-decoration-none small text-muted">
                        Detail <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-journal-x display-1 text-light"></i>
            <p class="text-muted mt-3">Belum ada riwayat pengiriman.</p>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>