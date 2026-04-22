<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

$id_user = $_SESSION['id_user'];
$username = $_SESSION['username'];

// Ambil statistik sederhana untuk pelanggan
$q_total_pesan = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pesanan WHERE id_user = '$id_user'");
$data_pesan = mysqli_fetch_assoc($q_total_pesan);

$q_total_belanja = mysqli_query($koneksi, "SELECT SUM(total_harga) as total FROM transaksi 
    JOIN pesanan ON transaksi.id_pesanan = pesanan.id_pesanan 
    WHERE pesanan.id_user = '$id_user'");
$data_belanja = mysqli_fetch_assoc($q_total_belanja);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Pelanggan | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --bg-body: #f4f7f6;
            --primary-color: #2c3e50;
        }
        body { background-color: var(--bg-body); font-family: 'Inter', sans-serif; }
        
        /* Navbar Custom */
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        /* Welcome Section */
        .welcome-card {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border: none;
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            transition: transform 0.3s ease;
        }
        .stat-card:hover { transform: translateY(-5px); }

        /* Action Menu */
        .menu-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            text-decoration: none;
            color: var(--primary-color);
            display: block;
            border: 1px solid transparent;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
        .menu-card:hover {
            border-color: #3498db;
            background-color: #f0f9ff;
        }
        .menu-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #3498db;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-dark" href="dashboard_pelanggan.php">
            <img src="../../assets/images/logo_depot_purnomo.png" alt="Logo" height="30" class="me-2">
            DEPOT PURNOMO
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link px-3 active fw-bold" href="dashboard_pelanggan.php">Home</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="status_pesanan.php">Riwayat</a></li>
                <li class="nav-item">
                    <a class="nav-link px-3 position-relative" href="cart.php">
                        <i class="bi bi-cart3 fs-5"></i>
                        <?php 
                        $cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
                        if($cart_count > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            <?= $cart_count ?>
                        </span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-outline-danger btn-sm rounded-pill px-4" href="../auth/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="welcome-card shadow-sm">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold mb-1">Selamat Datang, <?= htmlspecialchars($username) ?>!</h2>
                <p class="mb-0 opacity-75">Air minum bersih dan higienis siap diantar ke rumah Anda.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="daftar_barang.php" class="btn btn-light btn-lg rounded-pill fw-bold px-4 shadow-sm">
                    <i class="bi bi-plus-lg me-2"></i>Pesan Sekarang
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-5 g-3">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="text-muted small mb-1">Total Pesanan</div>
                <h4 class="fw-bold mb-0"><?= $data_pesan['total'] ?></h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="text-muted small mb-1">Total Belanja</div>
                <h4 class="fw-bold mb-0 text-success">Rp <?= number_format($data_belanja['total'] ?? 0, 0, ',', '.') ?></h4>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-3">Menu Utama</h5>
    <div class="row g-4">
        <div class="col-md-4">
            <a href="daftar_barang.php" class="menu-card shadow-sm">
                <div class="menu-icon"><i class="bi bi-droplet-fill"></i></div>
                <h6 class="fw-bold">Pesan Galon</h6>
                <p class="small text-muted mb-0">Pilih jenis air dan isi ulang galon Anda</p>
            </a>
        </div>
        <div class="col-md-4">
            <a href="status_pesanan.php" class="menu-card shadow-sm">
                <div class="menu-icon"><i class="bi bi-truck"></i></div>
                <h6 class="fw-bold">Status Pesanan</h6>
                <p class="small text-muted mb-0">Lacak pengantaran air Anda secara real-time</p>
            </a>
        </div>
        <div class="col-md-4">
            <a href="edit_profil.php" class="menu-card shadow-sm">
                <div class="menu-icon"><i class="bi bi-person-gear"></i></div>
                <h6 class="fw-bold">Pengaturan Akun</h6>
                <p class="small text-muted mb-0">Update alamat dan nomor telepon pengantaran</p>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>