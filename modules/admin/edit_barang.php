<?php
// halaman form edit barang. id dikirim via query string
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

if (!isset($_GET['id'])) {
    // jika tidak ada id, kembali ke daftar
    header('Location: manajemen_stok.php');
    exit;
}

$id = intval($_GET['id']);
// ambil data barang dari database untuk ditampilkan di form
$query = "SELECT * FROM barang WHERE id_barang = $id";
$res = mysqli_query($koneksi, $query);
$barang = mysqli_fetch_assoc($res);
if (!$barang) {
    header('Location: manajemen_stok.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/dark-mode.css" rel="stylesheet">
    <link href="../../assets/css/admin.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="manajemen_stok.php"><img src="../../assets/images/navbar_logo.png" alt="Depot Purnomo" height="30" class="d-inline-block align-text-top"> Depot Purnomo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="manajemen_stok.php">Stok</a></li>
                <li class="nav-item"><a class="nav-link" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-container">
    <h2 class="mb-4">Edit Barang</h2>
    <form method="POST" action="proses_edit_barang.php" enctype="multipart/form-data">
        <input type="hidden" name="id_barang" value="<?php echo $barang['id_barang']; ?>">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" id="nama" class="form-control" value="<?php echo htmlspecialchars($barang['nama_barang']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga_barang" id="harga" class="form-control" value="<?php echo $barang['harga_barang']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok_barang" id="stok" class="form-control" value="<?php echo $barang['stok_barang']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar (jpg/png) <small>(kosongkan untuk tetap menggunakan file lama)</small></label>
            <?php if (!empty($barang['gambar'])): ?>
                <div class="mb-2">
                    <img src="../../assets/images/<?php echo $barang['gambar']; ?>" alt="" width="100">
                </div>
            <?php endif; ?>
            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="manajemen_stok.php" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/dark-mode.js"></script>
</body>
</html>