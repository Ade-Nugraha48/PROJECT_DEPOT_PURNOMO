<?php

require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

// Pastikan hanya admin yang bisa akses
if ($_SESSION['id_role'] != 1) {
    header("Location: ../auth/login.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_clear'])) {
    // Hapus semua data history dalam urutan yang benar (child tables dulu)
    $tables_to_clear = ['detail_pesanan', 'pembayaran', 'pengiriman', 'transaksi', 'pesanan', 'audit_log', 'log_stok'];

    foreach ($tables_to_clear as $table) {
        $query = "DELETE FROM $table";
        mysqli_query($koneksi, $query);
    }

    // Reset auto increment jika perlu
    $reset_queries = [
        "ALTER TABLE detail_pesanan AUTO_INCREMENT = 1",
        "ALTER TABLE pembayaran AUTO_INCREMENT = 1",
        "ALTER TABLE pengiriman AUTO_INCREMENT = 1",
        "ALTER TABLE transaksi AUTO_INCREMENT = 1",
        "ALTER TABLE pesanan AUTO_INCREMENT = 1",
        "ALTER TABLE audit_log AUTO_INCREMENT = 1",
        "ALTER TABLE log_stok AUTO_INCREMENT = 1"
    ];

    foreach ($reset_queries as $query) {
        mysqli_query($koneksi, $query);
    }

    $message = "Semua data history telah dihapus!";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clear All Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/dark-mode.css" rel="stylesheet">
    <link href="../../assets/css/admin.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php include __DIR__ . '/../../includes/navbar.php'; ?>
    <div class="main-container">
        <h2 class="mb-4">Clear All Data</h2>
        <p class="text-danger">Peringatan: Tindakan ini akan menghapus semua data history pesanan, transaksi,
            pembayaran, pengiriman, audit log, dan log stok. Data tidak dapat dikembalikan!</p>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" onsubmit="return confirm('Apakah Anda benar-benar yakin ingin menghapus semua data?')">
            <button type="submit" name="confirm_clear" class="btn btn-danger">Hapus Semua Data</button>
            <a href="dashboard_admin.php" class="btn btn-secondary ms-2">Batal</a>
        </form>
    </div>
    <!-- navbar moved to top; unified include used -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../../assets/js/dark-mode.js"></script>
        <script src="../../assets/js/navbar-toggle.js"></script>
</body>

</html>
