<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

// Ambil semua barang
$query = "SELECT * FROM barang ORDER BY nama_barang ASC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Produk | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --bg-body: #f4f7f6; --primary: #2c3e50; --accent: #3498db; }
        body { background-color: var(--bg-body); font-family: 'Inter', sans-serif; }
        
        .navbar-custom { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }

        /* Product Card Styling */
        .product-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: white;
            transition: all 0.3s ease;
            height: 100%;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        }

        .img-wrapper {
            background: #f8f9fa;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .img-wrapper img {
            max-height: 80%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        .product-card:hover .img-wrapper img { transform: scale(1.1); }

        .price-tag {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--accent);
        }

        .stock-info {
            font-size: 0.85rem;
            padding: 4px 12px;
            border-radius: 50px;
            background: #eef2f7;
            color: #5d6d7e;
        }

        /* Quantity Input Styling */
        .qty-input {
            border-radius: 10px 0 0 10px !important;
            border: 1px solid #dee2e6;
            max-width: 80px;
            text-align: center;
        }
        .btn-add-cart {
            border-radius: 0 10px 10px 0 !important;
            padding-left: 20px;
            padding-right: 20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard_pelanggan.php">DEPOT PURNOMO</a>
        <div class="d-flex align-items-center">
            <a href="cart.php" class="btn btn-light rounded-pill position-relative me-2">
                <i class="bi bi-cart3"></i>
                <?php 
                $cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
                if($cart_count > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $cart_count ?>
                    </span>
                <?php endif; ?>
            </a>
            <a href="dashboard_pelanggan.php" class="btn btn-outline-secondary btn-sm rounded-pill d-none d-md-inline-block">Kembali</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h3 class="fw-bold mb-0">Katalog Air Minum</h3>
            <p class="text-muted">Pilih produk terbaik untuk kesehatan keluarga Anda</p>
        </div>
    </div>

    <div class="row g-4">
        <?php while ($barang = mysqli_fetch_assoc($result)) { ?>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card product-card shadow-sm">
                    <div class="img-wrapper">
                        <?php if (!empty($barang['gambar'])): ?>
                            <img src="../../assets/images/<?php echo $barang['gambar']; ?>" alt="<?php echo $barang['nama_barang']; ?>">
                        <?php else: ?>
                            <i class="bi bi-droplet text-primary display-4"></i>
                        <?php endif; ?>
                        
                        <div class="position-absolute bottom-0 start-0 m-3">
                            <span class="stock-info fw-medium">Stok: <?php echo $barang['stok_barang']; ?></span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($barang['nama_barang']); ?></h5>
                        <p class="price-tag mb-4">Rp <?php echo number_format($barang['harga_barang'], 0, ',', '.'); ?></p>
                        
                        <form method="POST" action="tambah_keranjang.php">
                            <input type="hidden" name="id_barang" value="<?php echo $barang['id_barang']; ?>">
                            <div class="input-group">
                                <input type="number" name="jumlah" class="form-control qty-input shadow-none" value="1" min="1" max="<?php echo $barang['stok_barang']; ?>" required>
                                <button type="submit" class="btn btn-primary btn-add-cart fw-bold">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>