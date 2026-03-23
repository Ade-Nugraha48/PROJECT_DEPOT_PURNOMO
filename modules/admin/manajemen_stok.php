<?php

// halaman ini hanya boleh diakses admin, middleware akan cek sesi
require_once "../../includes/auth_middleware.php";
require_once "../../config/database.php";

// ambil semua baris dari tabel barang untuk ditampilkan
$query = "SELECT * FROM barang";

$result = mysqli_query($koneksi, $query);

?>
<!-- tampilkan daftar barang dalam bentuk kartu -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/admin.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="../../assets/images/navbar_logo.png" alt="Depot Purnomo" height="30" class="d-inline-block align-text-top"> Depot Purnomo</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="tambah_barang.php">Tambah Barang</a></li>
                <li class="nav-item"><a class="nav-link" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-container">
    <h2>Manajemen Stok</h2>
    <p><a href="tambah_barang.php" class="btn btn-primary mb-3">Tambah Barang Baru</a></p>

<?php while($barang = mysqli_fetch_assoc($result)) { ?>

<!-- setiap barang ditampilkan sebagai kartu info -->
<div class="card card-custom p-3 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <?php if (!empty($barang['gambar'])): ?>
                <img src="../../assets/images/<?php echo $barang['gambar']; ?>" alt="" width="80">
            <?php else: ?>
                <span class="badge bg-secondary">no image</span>
            <?php endif; ?>
        </div>
        <div class="col">
            <strong><?php echo $barang['nama_barang']; ?></strong><br>
            Harga: <?php echo $barang['harga_barang']; ?><br>
            Stok: <?php echo $barang['stok_barang']; ?>
        </div>
        <div class="col-auto">
            <!-- form kecil untuk menambah stok barang -->
            <form method="POST" action="update_stok.php" class="d-flex">
                <input type="hidden" name="id_barang" value="<?php echo $barang['id_barang']; ?>">
                <input type="number" name="jumlah" class="form-control me-2" placeholder="Tambah">
                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
        <div class="col-auto">
            <!-- tombol edit dan hapus -->
            <a href="edit_barang.php?id=<?php echo $barang['id_barang']; ?>" class="btn btn-sm btn-warning me-2">Edit</a>
            <form method="POST" action="hapus_barang.php" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                <input type="hidden" name="id_barang" value="<?php echo $barang['id_barang']; ?>">
                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </form>
        </div>
    </div>
</div>

<?php } ?>
</div> <!-- .main-container -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>