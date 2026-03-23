<?php
// halaman daftar barang untuk pelanggan yang sudah login
require_once "../../includes/auth_middleware.php";
require_once "../../config/database.php";

// ambil data semua barang dari database
$query = "SELECT * FROM barang";
$result = mysqli_query($koneksi, $query);
?>
<!-- tampilkan dengan bootstrap grid -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Barang</title>
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
                <li class="nav-item"><a class="nav-link" href="status_pesanan.php">Status</a></li>
                <li class="nav-item"><a class="nav-link" href="cart.php">Keranjang <?php if($cart_count>0) echo '<span class="badge bg-light text-dark">'.$cart_count.'</span>'; ?></a></li>
                <li class="nav-item"><a class="nav-link" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-container">
    <h2 class="mb-4">Daftar Barang</h2>

    <div class="row">
        <?php while($barang = mysqli_fetch_assoc($result)) { ?>
        <div class="col-md-6">
            <div class="card card-custom p-3">
                <?php if (!empty($barang['gambar'])): ?>
                    <img src="../../assets/images/<?php echo $barang['gambar']; ?>" class="img-fluid mb-2" alt="<?php echo $barang['nama_barang']; ?>">
                <?php endif; ?>
                <h5><?php echo $barang['nama_barang']; ?></h5>
                <p>Harga: <?php echo $barang['harga_barang']; ?></p>
                <p>Stok: <?php echo $barang['stok_barang']; ?></p>
                <!-- form untuk memesan barang langsung -->
                <form method="POST" action="tambah_keranjang.php" class="d-flex">
                    <input type="hidden" name="id_barang" value="<?php echo $barang['id_barang']; ?>">
                    <input type="number" name="jumlah" class="form-control me-2" placeholder="Jumlah" required>
                    <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                </form>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>