<?php
session_start();
require_once "../../includes/auth_middleware.php";
require_once "../../config/database.php";
require_once "../../functions/pesanan_helper.php";

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

// fetch items as in cart.php
$items = [];
$total = 0;
$ids = implode(',', array_keys($cart));
$query = "SELECT * FROM barang WHERE id_barang IN ($ids)";
$res = mysqli_query($koneksi, $query);
while ($row = mysqli_fetch_assoc($res)) {
    $row['quantity'] = $cart[$row['id_barang']];
    $row['subtotal'] = $row['harga_barang'] * $row['quantity'];
    $total += $row['subtotal'];
    $items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <h2 class="mb-4">Konfirmasi Pesanan</h2>
    <table class="table table-custom">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $it): ?>
            <tr>
                <td><?php echo $it['nama_barang']; ?></td>
                <td><?php echo $it['harga_barang']; ?></td>
                <td><?php echo $it['quantity']; ?></td>
                <td><?php echo $it['subtotal']; ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong><?php echo $total; ?></strong></td>
            </tr>
        </tbody>
    </table>
    <form method="POST" action="proses_pesanan.php">
        <button type="submit" class="btn btn-success">Buat Pesanan</button>
        <a href="cart.php" class="btn btn-secondary ms-2">Kembali ke Keranjang</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>