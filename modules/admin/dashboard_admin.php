<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="../../assets/css/dark-mode.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #2c3e50;
            --accent-color: #3498db;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }

        /* Sidebar Style */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background: var(--primary-color);
            color: white;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 15px 25px;
            border-radius: 0;
            transition: 0.3s;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left: 4px solid var(--accent-color);
        }

        /* Content Adjustment */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            transition: all 0.3s;
        }

        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }

        .card-custom:hover {
            transform: translateY(-5px);
        }

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-lg-none">
    <div class="container-fluid">
        <span class="navbar-brand">Depot Purnomo</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="manajemen_stok.php">Stok</a></li>
                <li class="nav-item"><a class="nav-link" href="daftar_pesanan.php">Pesanan</a></li>
                <li class="nav-item"><a class="nav-link" href="monitoring_transaksi.php">Transaksi</a></li>
                <li class="nav-item"><a class="nav-link" href="laporan_penjualan.php">Laporan</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="d-flex">
    <nav class="sidebar d-none d-lg-block">
        <div class="p-4 text-center">
            <img src="../../assets/images/navbar_logo.png" alt="Logo" height="40" class="mb-3">
            <h5 class="fw-bold">Depot Purnomo</h5>
            <hr>
        </div>
        <div class="nav flex-column">
            <a href="#" class="nav-link active"><i class="fas fa-home me-2"></i> Dashboard</a>
            <a href="manajemen_stok.php" class="nav-link"><i class="fas fa-boxes me-2"></i> Manajemen Stok</a>
            <a href="daftar_pesanan.php" class="nav-link"><i class="fas fa-shopping-cart me-2"></i> Kelola Pesanan</a>
            <a href="monitoring_transaksi.php" class="nav-link"><i class="fas fa-chart-line me-2"></i> Transaksi</a>
            <a href="laporan_penjualan.php" class="nav-link"><i class="fas fa-file-alt me-2"></i> Laporan</a>
            <div class="mt-5 p-3">
                <a href="../auth/logout.php" class="btn btn-outline-light w-100 btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <main class="main-content w-100">
        <header class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold">Dashboard Overview</h2>
            <div class="user-profile">
                <span class="text-muted me-2">Halo, Admin</span>
                <i class="fas fa-user-circle fa-2x"></i>
            </div>
        </header>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <a href="daftar_pesanan.php" class="text-decoration-none">
                    <div class="card card-custom p-4 text-center bg-white text-dark">
                        <i class="fas fa-shopping-basket fa-2x text-primary mb-3"></i>
                        <h5>Pesanan</h5>
                        <p class="text-muted mb-0">Kelola pesanan masuk</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="manajemen_stok.php" class="text-decoration-none">
                    <div class="card card-custom p-4 text-center bg-white text-dark">
                        <i class="fas fa-warehouse fa-2x text-success mb-3"></i>
                        <h5>Stok</h5>
                        <p class="text-muted mb-0">Update ketersediaan</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="monitoring_transaksi.php" class="text-decoration-none">
                    <div class="card card-custom p-4 text-center bg-white text-dark">
                        <i class="fas fa-history fa-2x text-warning mb-3"></i>
                        <h5>Transaksi</h5>
                        <p class="text-muted mb-0">Pantau arus uang</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="laporan_penjualan.php" class="text-decoration-none">
                    <div class="card card-custom p-4 text-center bg-white text-dark">
                        <i class="fas fa-print fa-2x text-info mb-3"></i>
                        <h5>Laporan</h5>
                        <p class="text-muted mb-0">Cetak laporan rutin</p>
                    </div>
                </a>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>