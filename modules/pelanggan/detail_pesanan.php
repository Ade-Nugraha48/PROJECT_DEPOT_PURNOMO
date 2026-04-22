<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

$id_pesanan = intval($_GET['id_pesanan'] ?? 0);
$id_user = $_SESSION['id_user'];

// Pastikan pesanan milik pelanggan yang sedang login
$q_check = "SELECT * FROM pesanan WHERE id_pesanan = $id_pesanan AND id_user = $id_user";
$r_check = mysqli_query($koneksi, $q_check);
$pesanan = mysqli_fetch_assoc($r_check);

if (!$pesanan) {
    header("Location: status_pesanan.php");
    exit();
}

// Ambil info pelanggan
$q_user = "SELECT username, no_telp FROM users WHERE id_user = '$id_user'";
$r_user = mysqli_query($koneksi, $q_user);
$user_info = mysqli_fetch_assoc($r_user);

// Ambil rincian barang
$query_items = "SELECT 
    barang.nama_barang,
    detail_pesanan.jumlah,
    detail_pesanan.harga_satuan
FROM detail_pesanan
JOIN barang ON detail_pesanan.id_barang = barang.id_barang
WHERE id_pesanan = $id_pesanan";

$result_items = mysqli_query($koneksi, $query_items);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pesanan #<?= $id_pesanan ?> | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --bg-body: #f4f7f6; --primary: #2c3e50; }
        body { background-color: var(--bg-body); font-family: 'Inter', sans-serif; }
        
        .invoice-card {
            background: white;
            border-radius: 20px;
            border: none;
            overflow: hidden;
        }
        .invoice-header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 40px;
        }
        .invoice-body { padding: 40px; }
        
        .status-badge {
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            background: rgba(255,255,255,0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .table-items thead {
            border-bottom: 2px solid #f8f9fa;
        }
        .table-items th {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            color: #adb5bd;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4">
                <a href="status_pesanan.php" class="text-decoration-none text-muted">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Riwayat Pesanan
                </a>
            </div>

            <div class="card invoice-card shadow-lg">
                <div class="invoice-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="mb-1 opacity-75">ID Pesanan</p>
                            <h3 class="fw-bold mb-0">#TRX-<?= $id_pesanan ?></h3>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <span class="status-badge">
                                <?= strtoupper($pesanan['status_pesanan']) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="invoice-body">
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted text-uppercase small mb-3">Informasi Pelanggan</h6>
                            <p class="mb-1 fw-bold"><?= htmlspecialchars($user_info['username']) ?></p>
                            <p class="mb-0 text-muted small"><i class="bi bi-telephone me-1"></i> <?= htmlspecialchars($user_info['no_telp']) ?></p>
                        </div>
                        <div class="col-md-6 text-md-end mt-4 mt-md-0">
                            <h6 class="fw-bold text-muted text-uppercase small mb-3">Tanggal Pesan</h6>
                            <p class="mb-0 fw-bold"><?= date('d F Y', strtotime($pesanan['tanggal_pesanan'])) ?></p>
                            <p class="text-muted small"><?= date('H:i', strtotime($pesanan['tanggal_pesanan'])) ?> WIB</p>
                        </div>
                    </div>

                    <div class="table-responsive mb-5">
                        <table class="table table-items align-middle">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $grand_total = 0;
                                while($data = mysqli_fetch_assoc($result_items)): 
                                    $subtotal = $data['jumlah'] * $data['harga_satuan'];
                                    $grand_total += $subtotal;
                                ?>
                                <tr>
                                    <td class="fw-bold py-3 text-dark"><?= $data['nama_barang'] ?></td>
                                    <td class="text-center"><?= $data['jumlah'] ?></td>
                                    <td class="text-end text-muted">Rp <?= number_format($data['harga_satuan'], 0, ',', '.') ?></td>
                                    <td class="text-end fw-bold">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end py-4 fw-bold">Total Bayar</td>
                                    <td class="text-end py-4">
                                        <h4 class="fw-bold text-primary mb-0">Rp <?= number_format($grand_total, 0, ',', '.') ?></h4>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="text-center bg-light rounded-4 p-4 mt-2">
                        <p class="small text-muted mb-0">Terima kasih telah memesan di <strong>Depot Purnomo</strong>.</p>
                        <p class="small text-muted">Jika ada kendala pengiriman, hubungi kami via WhatsApp.</p>
                        <a href="https://wa.me/NOMOR_ADMIN_DISINI" class="btn btn-outline-success btn-sm rounded-pill px-4 mt-2">
                            <i class="bi bi-whatsapp me-2"></i>Hubungi Admin
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 d-print-none">
                <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-printer me-2"></i> Cetak Bukti Pesanan
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>