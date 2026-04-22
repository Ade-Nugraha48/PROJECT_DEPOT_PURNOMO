<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- gunakan Bootstrap dan stylesheet khusus auth -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/dark-mode.css" rel="stylesheet">
    <link href="../../assets/css/auth.css" rel="stylesheet">
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <!-- logo berada di atas form -->
        <img src="../../assets/images/logo_depot_purnomo.png" alt="Logo" class="logo">
        <h2>Login</h2>
        <!-- form POST mengirim ke proses_login.php -->
        <form method="POST" action="proses_login.php">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" class="btn btn-primary">Login</button>
            <p class="text-center mt-3">
                Belum punya akun? <a href="registrasi.php">Daftar</a>
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