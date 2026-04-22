<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

$query = "SELECT 
    pesanan.id_pesanan,
    users.username,
    pesanan.status_pesanan,
    pesanan.tanggal_pesanan
    FROM pesanan
    JOIN users ON pesanan.id_user = users.id_user
    ORDER BY pesanan.tanggal_pesanan DESC";

$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Pesanan | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../../assets/css/admin.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .main-container { padding: 2rem; }
        .card-table {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            background: #fff;
        }
        .table thead { background-color: #f1f3f5; }
        .table th { border: none; padding: 1rem; color: #495057; }
        .table td { vertical-align: middle; padding: 1rem; border-bottom: 1px solid #f1f3f5; }
        .badge-status { font-weight: 500; padding: 0.5em 0.8em; border-radius: 6px; }
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
                <li class="nav-item"><a class="nav-link active" href="daftar_pesanan.php">Pesanan</a></li>
                <li class="nav-item"><a class="nav-link" href="manajemen_stok.php">Stok</a></li>
                <li class="nav-item"><a class="nav-link " href="monitoring_transaksi.php">Transaksi</a></li>
                <li class="nav-item"><a class="nav-link btn btn-outline-danger btn-sm ms-lg-3" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Daftar Pesanan</h2>
        <span class="text-muted">Total: <?php echo mysqli_num_rows($result); ?> Pesanan</span>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> Pesanan berhasil divalidasi!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card card-table overflow-hidden">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($data = mysqli_fetch_assoc($result)): 
                        // Logika warna badge
                        $badgeClass = 'bg-secondary';
                        $statusText = str_replace('_', ' ', $data['status_pesanan']);
                        
                        if($data['status_pesanan'] === 'menunggu_pembayaran') $badgeClass = 'bg-warning text-dark';
                        elseif($data['status_pesanan'] === 'diproses') $badgeClass = 'bg-info text-white';
                        elseif($data['status_pesanan'] === 'selesai') $badgeClass = 'bg-success';
                        elseif($data['status_pesanan'] === 'ditolak') $badgeClass = 'bg-danger';
                    ?>
                    <tr>
                        <td class="fw-bold text-primary">#<?php echo $data['id_pesanan']; ?></td>
                        <td><?php echo date('d M Y, H:i', strtotime($data['tanggal_pesanan'])); ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-circle me-2 fs-5 text-muted"></i>
                                <?php echo htmlspecialchars($data['username']); ?>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-status <?php echo $badgeClass; ?>">
                                <?php echo ucwords($statusText); ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group shadow-sm">
                                <a href="detail_transaksi.php?id_pesanan=<?php echo $data['id_pesanan']; ?>" 
                                   class="btn btn-sm btn-outline-secondary" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                                <?php if($data['status_pesanan'] === 'menunggu_pembayaran'): ?>
                                    <a href="validasi_pesanan.php?id_pesanan=<?php echo $data['id_pesanan']; ?>" 
                                       class="btn btn-sm btn-primary" title="Validasi">
                                        <i class="bi bi-check-lg"></i>
                                    </a>
                                    <a href="tolak_pesanan.php?id_pesanan=<?php echo $data['id_pesanan']; ?>" 
                                       class="btn btn-sm btn-danger" title="Tolak"
                                       onclick="return confirm('Yakin ingin menolak pesanan ini?')">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>