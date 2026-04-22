<?php
session_start();
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

$cart = $_SESSION['cart'] ?? [];

$items = [];
$total = 0;
if (!empty($cart)) {
    $ids = implode(',', array_keys($cart));
    $query = "SELECT * FROM barang WHERE id_barang IN ($ids)";
    $res = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_assoc($res)) {
        $row['quantity'] = $cart[$row['id_barang']];
        $row['subtotal'] = $row['harga_barang'] * $row['quantity'];
        $total += $row['subtotal'];
        $items[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang Saya | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --bg-body: #f8f9fa; --primary: #2c3e50; }
        body { background-color: var(--bg-body); font-family: 'Inter', sans-serif; }

        .cart-item-card {
            background: white;
            border-radius: 15px;
            border: none;
            transition: all 0.2s ease;
        }
        .cart-item-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .summary-card {
            background: white;
            border-radius: 20px;
            border: 2px solid #edf2f7;
            position: sticky;
            top: 100px;
        }

        .qty-control {
            max-width: 130px;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 5px;
        }
        .qty-control input {
            background: transparent;
            border: none;
            text-align: center;
            font-weight: bold;
            width: 50px;
        }

        .btn-update {
            background: #e2e8f0;
            border: none;
            color: #4a5568;
            padding: 2px 8px;
            border-radius: 5px;
            font-size: 0.75rem;
        }

        .empty-cart-icon {
            font-size: 5rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-light bg-white border-bottom py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-dark" href="dashboard_pelanggan.php">
            <i class="bi bi-chevron-left me-2"></i> Keranjang Belanja
        </a>
    </div>
</nav>

<div class="container py-5">
    <?php if (empty($items)): ?>
        <div class="text-center py-5">
            <div class="empty-cart-icon"><i class="bi bi-cart-x"></i></div>
            <h4 class="fw-bold">Keranjangmu Kosong</h4>
            <p class="text-muted">Sepertinya kamu belum memilih produk apa pun.</p>
            <a href="daftar_barang.php" class="btn btn-primary rounded-pill px-5 py-2 mt-3">Mulai Belanja</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <div class="col-lg-8">
                <h5 class="fw-bold mb-4">Item (<?= count($items) ?>)</h5>
                
                <?php foreach ($items as $it): ?>
                <div class="card cart-item-card p-3 mb-3 shadow-sm">
                    <div class="row align-items-center g-3">
                        <div class="col-auto">
                            <div class="bg-light rounded-3 p-2" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-droplet-half text-primary fs-2"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="fw-bold mb-1"><?= $it['nama_barang'] ?></h6>
                            <p class="small text-muted mb-0">Harga Satuan: Rp <?= number_format($it['harga_barang'], 0, ',', '.') ?></p>
                            <h6 class="text-primary fw-bold mt-2 d-md-none">Rp <?= number_format($it['subtotal'], 0, ',', '.') ?></h6>
                        </div>
                        <div class="col-md-auto">
                            <form method="POST" action="update_keranjang.php" class="d-flex flex-column align-items-center">
                                <input type="hidden" name="id_barang" value="<?= $it['id_barang'] ?>">
                                <div class="qty-control d-flex align-items-center mb-1">
                                    <input type="number" name="jumlah" value="<?= $it['quantity'] ?>" min="1" class="form-control-sm">
                                </div>
                                <button type="submit" class="btn-update shadow-sm">Update Qty</button>
                            </form>
                        </div>
                        <div class="col-md-2 text-end d-none d-md-block">
                            <p class="small text-muted mb-1">Subtotal</p>
                            <h6 class="fw-bold text-dark">Rp <?= number_format($it['subtotal'], 0, ',', '.') ?></h6>
                        </div>
                        <div class="col-auto">
                            <a href="remove_keranjang.php?id_barang=<?= $it['id_barang'] ?>" class="btn btn-outline-danger btn-sm border-0 rounded-circle">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="col-lg-4">
                <div class="card summary-card shadow-sm p-4">
                    <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Harga (<?= count($items) ?> Produk)</span>
                        <span class="fw-bold">Rp <?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Biaya Pengantaran</span>
                        <span class="text-success fw-bold">GRATIS</span>
                    </div>
                    <hr class="border-secondary opacity-10">
                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="fw-bold">Total Tagihan</h5>
                        <h5 class="fw-bold text-primary">Rp <?= number_format($total, 0, ',', '.') ?></h5>
                    </div>
                    <a href="checkout.php" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow">
                        Lanjut ke Pembayaran
                    </a>
                    <a href="daftar_barang.php" class="btn btn-link w-100 text-muted mt-2 text-decoration-none small">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Item Lagi
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>