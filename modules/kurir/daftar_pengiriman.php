<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

// Ambil data pengiriman aktif
$query = "SELECT 
    pengiriman.id_pengiriman,
    pengiriman.status_pengiriman,
    pesanan.id_pesanan,
    pesanan.alamat_lengkap,
    users.username,
    users.no_telp
FROM pengiriman
JOIN pesanan ON pengiriman.id_pesanan = pesanan.id_pesanan
JOIN users ON pesanan.id_user = users.id_user
WHERE pengiriman.status_pengiriman IN ('menunggu_kurir','dalam_pengiriman')
ORDER BY pengiriman.id_pengiriman DESC";

$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tugas Pengiriman | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --bg-body: #f4f7f6; --primary: #2c3e50; }
        body { background-color: var(--bg-body); font-family: 'Inter', sans-serif; padding-bottom: 50px; }
        
        .navbar-custom { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }

        .task-card {
            border: none;
            border-radius: 20px;
            background: white;
            transition: transform 0.2s;
            overflow: hidden;
        }

        .status-strip {
            height: 6px;
            width: 100%;
        }

        .btn-action {
            border-radius: 12px;
            padding: 10px;
            font-weight: 700;
            width: 100%;
        }

        .contact-pill {
            background: #e8f5e9;
            color: #2e7d32;
            text-decoration: none;
            padding: 5px 15px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .contact-pill:hover { background: #c8e6c9; color: #1b5e20; }

        .address-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 12px;
            border-left: 3px solid #dee2e6;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard_kurir.php">
            <i class="bi bi-chevron-left me-2"></i> TUGAS PENGIRIMAN
        </a>
    </div>
</nav>

<div class="container mt-4">
    <?php if(isset($_GET['completed']) && $_GET['completed'] == 1): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> Pesanan berhasil diselesaikan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while($data = mysqli_fetch_assoc($result)): 
            $is_waiting = ($data['status_pengiriman'] === 'menunggu_kurir');
            $status_color = $is_waiting ? 'bg-warning' : 'bg-primary';
        ?>
        <div class="card task-card shadow-sm mb-4">
            <div class="status-strip <?= $status_color ?>"></div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">ID Pesanan #<?= $data['id_pesanan'] ?></span>
                        <h5 class="fw-bold mb-0 mt-1"><?= htmlspecialchars($data['username']) ?></h5>
                    </div>
                    <span class="badge <?= $is_waiting ? 'bg-warning text-dark' : 'bg-primary text-white' ?> rounded-pill px-3">
                        <?= $is_waiting ? 'Siap Kirim' : 'Sedang Jalan' ?>
                    </span>
                </div>

                <div class="address-box mb-3">
                    <p class="small text-muted mb-1"><i class="bi bi-geo-alt-fill me-1"></i> Alamat Pengiriman:</p>
                    <p class="mb-0 fw-medium small text-dark"><?= htmlspecialchars($data['alamat_lengkap']) ?></p>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <a href="https://wa.me/<?= preg_replace('/^0/', '62', $data['no_telp']) ?>" target="_blank" class="contact-pill me-2">
                        <i class="bi bi-whatsapp me-2"></i> Hubungi WhatsApp
                    </a>
                </div>

                <div class="row g-2">
                    <div class="col-4">
                        <a href="detail_pesanan.php?id_pesanan=<?= $data['id_pesanan'] ?>" class="btn btn-outline-secondary btn-action border-0 bg-light text-muted">
                            <i class="bi bi-eye"></i> <span class="d-none d-md-inline">Detail</span>
                        </a>
                    </div>
                    <div class="col-8">
                        <?php if ($is_waiting): ?>
                            <a href="terima_pengiriman.php?id_pengiriman=<?= $data['id_pengiriman'] ?>" class="btn btn-primary btn-action shadow-sm">
                                <i class="bi bi-bicycle me-2"></i> Ambil Pesanan
                            </a>
                        <?php else: ?>
                            <a href="verifikasi_selelsai.php?id_pengiriman=<?= $data['id_pengiriman'] ?>" class="btn btn-success btn-action shadow-sm">
                                <i class="bi bi-check2-all me-2"></i> Tandai Sampai
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-mailbox display-1 text-light"></i>
            <h5 class="mt-3 text-muted">Belum ada tugas baru.</h5>
            <p class="small text-muted">Santai dulu sejenak!</p>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>