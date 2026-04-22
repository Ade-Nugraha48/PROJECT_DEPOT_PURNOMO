<?php
require_once "../../includes/auth_middleware.php";
require_once "../../config/database.php";

$id_pesanan = intval($_GET['id_pesanan'] ?? 0);
$id_user = $_SESSION['id_user'];

// pastikan pesanan milik pelanggan
$q0 = "SELECT id_user FROM pesanan WHERE id_pesanan=$id_pesanan";
$r0 = mysqli_query($koneksi, $q0);
$row0 = mysqli_fetch_assoc($r0);
if (!$row0 || $row0['id_user'] != $id_user) {
    die('akses ditolak');
}

// ambil nomor telepon pelanggan dari tabel users
$q1 = "SELECT no_telp FROM users WHERE id_user='$id_user'";
$r1 = mysqli_query($koneksi, $q1);
$u = mysqli_fetch_assoc($r1);
$no_telp = $u['no_telp'] ?? '';

$query = "SELECT 
    barang.nama_barang,
    detail_pesanan.jumlah,
    detail_pesanan.harga_satuan
FROM detail_pesanan
JOIN barang ON detail_pesanan.id_barang = barang.id_barang
WHERE id_pesanan='$id_pesanan'";

$result = mysqli_query($koneksi,$query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/dark-mode.css" rel="stylesheet">
    <link href="../../assets/css/pelanggan.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard_pelanggan.php"><img src="../../assets/images/navbar_logo.png" alt="Depot Purnomo" height="30" class="d-inline-block align-text-top"> Depot Purnomo</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard_pelanggan.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="daftar_barang.php">Daftar Barang</a></li>
                <li class="nav-item"><a class="nav-link" href="status_pesanan.php">Status</a></li>
                <li class="nav-item"><a class="nav-link" href="cart.php">Keranjang</a></li>
                <li class="nav-item"><a class="nav-link" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-container">
    <h2 class="mb-4">Detail Pesanan #<?php echo $id_pesanan; ?></h2>
    <p><strong>No. Telepon:</strong> <?php echo htmlspecialchars($no_telp); ?></p>
    <?php while($data = mysqli_fetch_assoc($result)) { ?>
        <div class="card card-custom mb-3 p-3">
            <strong>Barang:</strong> <?php echo $data['nama_barang']; ?><br>
            <strong>Jumlah:</strong> <?php echo $data['jumlah']; ?><br>
            <strong>Harga:</strong> <?php echo $data['harga_satuan']; ?>
        </div>
    <?php } ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/dark-mode.js"></script>
</body>
</html>