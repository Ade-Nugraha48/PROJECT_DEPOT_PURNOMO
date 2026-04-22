<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

$query = "SELECT * FROM barang ORDER BY id_barang DESC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Stok | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Roboto, sans-serif; }
        
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .product-card {
            background: white;
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .img-container {
            height: 180px;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .img-container img { width: 100%; height: 100%; object-fit: cover; }

        .stock-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.75rem;
        }

        .quick-update-input {
            border-radius: 8px 0 0 8px !important;
            border: 1px solid #dee2e6;
        }

        .btn-add-stock {
            border-radius: 0 8px 8px 0 !important;
        }

        .price-tag {
            color: #2ecc71;
            font-weight: 700;
            font-size: 1.1rem;
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
                <li class="nav-item"><a class="nav-link active" href="manajemen_stok.php">Stok</a></li>
                <li class="nav-item"><a class="nav-link" href="monitoring_transaksi.php">Transaksi</a></li>
                <li class="nav-item"><a class="nav-link btn btn-outline-danger btn-sm ms-lg-3" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="page-header d-md-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="bi bi-box-seam me-2"></i>Manajemen Stok</h2>
            <p class="text-muted mb-0">Pantau dan kelola inventaris Depot Purnomo</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="tambah_barang.php" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Tambah Barang
            </a>
        </div>
    </div>

    <div class="row g-4">
        <?php while($barang = mysqli_fetch_assoc($result)) { 
            // Logika indikator stok
            $stok = (int)$barang['stok_barang'];
            $badgeColor = $stok <= 5 ? 'bg-danger' : ($stok <= 15 ? 'bg-warning text-dark' : 'bg-success');
        ?>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div class="card product-card shadow-sm position-relative">
                <span class="badge stock-badge <?php echo $badgeColor; ?>">
                    Stok: <?php echo $stok; ?>
                </span>

                <div class="img-container">
                    <?php if (!empty($barang['gambar'])): ?>
                        <img src="../../assets/images/<?php echo htmlspecialchars($barang['gambar']); ?>" alt="product">
                    <?php else: ?>
                        <i class="bi bi-image text-muted fs-1"></i>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <h5 class="card-title fw-bold text-truncate mb-1"><?php echo htmlspecialchars($barang['nama_barang']); ?></h5>
                    <p class="price-tag mb-3">Rp <?php echo number_format($barang['harga_barang'],0,',','.'); ?></p>
                    
                    <form method="POST" action="update_stok.php" class="mb-3">
                        <input type="hidden" name="id_barang" value="<?php echo $barang['id_barang']; ?>">
                        <div class="input-group input-group-sm">
                            <input type="number" name="jumlah" class="form-control quick-update-input" placeholder="Tambah unit...">
                            <button class="btn btn-primary btn-add-stock" type="submit">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </form>

                    <div class="d-flex gap-2 mt-auto">
                        <a href="edit_barang.php?id=<?php echo $barang['id_barang']; ?>" class="btn btn-outline-secondary btn-sm w-100 rounded-pill">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <form method="POST" action="hapus_barang.php" class="w-100" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                            <input type="hidden" name="id_barang" value="<?php echo $barang['id_barang']; ?>">
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-pill">
                                <i class="bi bi-trash me-1"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>