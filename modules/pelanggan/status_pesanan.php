<?php

require_once "../../includes/auth_middleware.php";
require_once "../../config/database.php";

$id_user = $_SESSION['id_user'];

$query = "SELECT * FROM pesanan 
WHERE id_user='$id_user'
ORDER BY tanggal_pesanan DESC";

$result = mysqli_query($koneksi, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/pelanggan.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard_pelanggan.php"><img src="../../assets/images/navbar_logo.png" alt="Depot Purnomo" height="30" class="d-inline-block align-text-top"> Depot Purnomo</a>
        <div class="collapse navbar-collapse">
            <?php $cart_count = array_sum($_SESSION['cart'] ?? []); ?>
        <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard_pelanggan.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="daftar_barang.php">Daftar Barang</a></li>
                <li class="nav-item"><a class="nav-link" href="cart.php">Keranjang <?php if($cart_count>0) echo '<span class="badge bg-light text-dark">'.$cart_count.'</span>'; ?></a></li>
                <li class="nav-item"><a class="nav-link" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-container">
    <h2 class="mb-4">Status Pesanan</h2>

    <div class="list-group">
    <?php while($data = mysqli_fetch_assoc($result)) { ?>
        <div class="list-group-item">
            <strong>ID Pesanan:</strong> <?php echo $data['id_pesanan']; ?><br>
            <strong>Status:</strong> <?php echo $data['status_pesanan']; ?><br>
            <a href="detail_pesanan.php?id_pesanan=<?php echo $data['id_pesanan']; ?>" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail</a>
        </div>
    <?php } ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>