<?php
session_start();
require_once "../../includes/auth_middleware.php";
require_once "../../config/database.php";

$cart = $_SESSION['cart'] ?? [];

// ambil data barang untuk setiap id dalam keranjang
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
    <title>Keranjang Belanja</title>
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
                <li class="nav-item"><a class="nav-link" href="dashboard_pelanggan.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="status_pesanan.php">Status</a></li>
                <li class="nav-item"><a class="nav-link" href="cart.php">Keranjang</a></li>
                <li class="nav-item"><a class="nav-link" href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="main-container">
    <h2 class="mb-4">Keranjang Belanja</h2>
    <?php if (empty($items)): ?>
        <p>Keranjang kosong. <a href="daftar_barang.php">Lihat produk</a></p>
    <?php else: ?>
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $it): ?>
                <tr>
                    <td><?php echo $it['nama_barang']; ?></td>
                    <td><?php echo $it['harga_barang']; ?></td>
                    <td>
                        <form method="POST" action="update_keranjang.php" class="d-flex">
                            <input type="hidden" name="id_barang" value="<?php echo $it['id_barang']; ?>">
                            <input type="number" name="jumlah" value="<?php echo $it['quantity']; ?>" min="1" class="form-control me-2" style="width:80px;">
                            <button type="submit" class="btn btn-sm btn-secondary">Ubah</button>
                        </form>
                    </td>
                    <td><?php echo $it['subtotal']; ?></td>
                    <td><a href="remove_keranjang.php?id_barang=<?php echo $it['id_barang']; ?>" class="btn btn-sm btn-danger">Hapus</a></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td colspan="2"><strong><?php echo $total; ?></strong></td>
                </tr>
            </tbody>
        </table>
        <a href="checkout.php" class="btn btn-primary">Lanjut ke Checkout</a>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/dark-mode.js"></script>
</body>
</html>