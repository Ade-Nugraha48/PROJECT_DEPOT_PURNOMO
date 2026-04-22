<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

$id_user = $_SESSION['id_user'];

$query = "SELECT * FROM pesanan 
          WHERE id_user='$id_user'
          ORDER BY tanggal_pesanan DESC";

$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Pesanan | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --bg-body: #f4f7f6; --primary: #2c3e50; }
        body { background-color: var(--bg-body); font-family: 'Inter', sans-serif; }

        .order-card {
            background: white;
            border-radius: 15px;
            border: none;
            border-left: 5px solid transparent;
            transition: all 0.3s ease;
        }
        
        /* Warna indikator berdasarkan status */
        .status-menunggu { border-left-color: #f1c40f; }
        .status-diproses { border-left-color: #3498db; }
        .status-dikirim { border-left-color: #e67e22; }
        .status-selesai { border-left-color: #2ecc71; }
        .status-batal { border-left-color: #e74c3c; }

        .badge-status {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .order-id {
            font-family: 'Monospace', sans-serif;
            color: #7f8c8d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard_pelanggan.php">DEPOT PURNOMO</a>
        <a href="dashboard_pelanggan.php" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="bi bi-house-door me-1"></i> Dashboard
        </a>
    </div>
</nav>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h3 class="fw-bold">Riwayat Pesanan</h3>
            <p class="text-muted">Pantau status pengiriman air galon Anda di sini.</p>
        </div>
    </div>

    <div class="row g-3">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($data = mysqli_fetch_assoc($result)) { 
                // Logika Penentuan Gaya Status
                $status = strtolower($data['status_pesanan']);
                $class_border = "status-" . $status;
                $badge_color = match($status) {
                    'menunggu' => 'bg-warning text-dark',
                    'diproses' => 'bg-info text-white',
                    'dikirim'  => 'bg-primary text-white',
                    'selesai'  => 'bg-success text-white',
                    'batal'    => 'bg-danger text-white',
                    default    => 'bg-secondary text-white'
                };
            ?>
            <div class="col-12">
                <div class="card order-card shadow-sm p-4 <?= $class_border ?>">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <span class="order-id">#ID-<?= $data['id_pesanan'] ?></span>
                            <h6 class="fw-bold mt-1 mb-1">Pemesanan Air Galon</h6>
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i> <?= date('d M Y, H:i', strtotime($data['tanggal_pesanan'])) ?>
                            </small>
                        </div>
                        
                        <div class="col-md-4 text-md-center mb-3 mb-md-0">
                            <span class="badge-status <?= $badge_color ?>">
                                <?= strtoupper($data['status_pesanan']) ?>
                            </span>
                        </div>

                        <div class="col-md-4 text-md-end">
                            <a href="detail_pesanan.php?id_pesanan=<?= $data['id_pesanan'] ?>" class="btn btn-light rounded-pill px-4 btn-sm fw-bold border">
                                Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-clipboard-x display-1 text-light"></i>
                <p class="text-muted mt-3">Anda belum pernah melakukan pemesanan.</p>
                <a href="daftar_barang.php" class="btn btn-primary rounded-pill">Pesan Sekarang</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>