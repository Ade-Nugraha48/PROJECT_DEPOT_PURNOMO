<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi</title>
    <!-- gunakan CSS yang sama seperti halaman login -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/dark-mode.css" rel="stylesheet">
    <link href="../../assets/css/auth.css" rel="stylesheet">
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <img src="../../assets/images/logo_depot_purnomo.png" alt="Logo" class="logo">
        <h2>Daftar Akun</h2>
        <!-- form pendaftaran pelanggan dikirim ke proses_registrasi.php -->
        <form method="POST" action="proses_registrasi.php">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <input type="text" name="no_telp" class="form-control" placeholder="No. Telepon" required>
            <button type="submit" class="btn btn-primary">Daftar</button>
            <p class="text-center mt-3">
                Sudah punya akun? <a href="login.php">Login</a>
            </p>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/dark-mode.js"></script>
<footer class="text-center mt-4">
    <img src="../../assets/images/logo_depot_purnomo.png" alt="Depot Purnomo" height="50">
</footer>
</body>
</html>