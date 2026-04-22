<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

$id_user = $_SESSION['id_user'];
$username = $_SESSION['username'];

// Ambil statistik kurir (Contoh: pesanan yang perlu dikirim hari ini)
$q_pending = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pesanan WHERE status_pesanan = 'diproses' OR status_pesanan = 'dikirim'");
$data_pending = mysqli_fetch_assoc($q_pending);

$q_done = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pesanan WHERE status_pesanan = 'selesai'");
$data_done = mysqli_fetch_assoc($q_done);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Kurir | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --bg-body: #f4f7f6; --primary: #2c3e50; --accent: #3498db; }
        body { background-color: var(--bg-body); font-family: 'Inter', sans-serif; }
        
        .navbar-custom { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }

        .welcome-section {
            background: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);
            color: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .action-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            text-decoration: none;
            color: var(--primary);
            display: block;
            border: 1px solid transparent;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .action-card:active { transform: scale(0.95); }
        .action-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: var(--accent);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom py-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard_kurir.php">
            <img src="../../assets/images/logo_depot_purnomo.png" alt="Logo" height="30" class="me-2">
            KURIR DEPOT
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link fw-bold px-3" href="dashboard_kurir.php">Home</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="daftar_pengiriman.php">Pengiriman</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="history_pengiriman.php">History</a></li>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-outline-danger btn-sm rounded-pill px-4" href="../auth/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4 mb-5">
    <div class="welcome-section shadow-sm">
        <div class="row align-items-center">
            <div class="col-8">
                <h4 class="fw-bold mb-1">Semangat, <?= htmlspecialchars($username) ?>! 🚛</h4>
                <p class="mb-0 opacity-75 small">Siap mengantar kesegaran hari ini?</p>
            </div>
            <div class="col-4 text-end">
                <i class="bi bi-person-badge display-4 opacity-50"></i>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="stat-card">
                <div class="small text-muted mb-1">Tugas Aktif</div>
                <h3 class="fw-bold mb-0 text-warning"><?= $data_pending['total'] ?></h3>
            </div>
        </div>
        <div class="col-6">
            <div class="stat-card">
                <div class="small text-muted mb-1">Selesai</div>
                <h3 class="fw-bold mb-0 text-success"><?= $data_done['total'] ?></h3>
            </div>
        </div>
    </div>

    <h6 class="fw-bold mb-3 text-uppercase small" style="letter-spacing: 1px;">Menu Navigasi</h6>
    <div class="row g-3">
        <div class="col-12">
            <a href="daftar_pengiriman.php" class="action-card">
                <div class="action-icon"><i class="bi bi-box-seam"></i></div>
                <h6 class="fw-bold mb-1">Pengiriman Masuk</h6>
                <p class="small text-muted mb-0">Lihat daftar galon yang perlu diantar</p>
            </a>
        </div>
        <div class="col-12">
            <a href="history_pengiriman.php" class="action-card">
                <div class="action-icon text-secondary"><i class="bi bi-clock-history"></i></div>
                <h6 class="fw-bold mb-1">Riwayat Pengiriman</h6>
                <p class="small text-muted mb-0">Laporan pengantaran yang sudah selesai</p>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>