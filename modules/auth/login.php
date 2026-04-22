<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #3498db;
        }

        body {
            background: #f8f9fa;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .auth-container {
            width: 100%;
            max-width: 400px;
            padding: 15px;
        }

        .auth-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            text-align: center;
        }

        .logo {
            height: 70px;
            margin-bottom: 20px;
        }

        h2 {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 1.5rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            background-color: #fcfcfc;
            margin-bottom: 20px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            border-color: var(--accent-color);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            background: var(--primary-color);
            border: none;
            font-weight: 600;
            transition: 0.3s;
            color: white;
        }

        .btn-login:hover {
            background: #1a252f;
            transform: translateY(-2px);
        }

        .register-link {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 25px;
        }

        .register-link a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 600;
        }

        .footer-logo {
            position: absolute;
            bottom: 20px;
            opacity: 0.5;
        }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        <img src="../../assets/images/logo_depot_purnomo.png" alt="Logo" class="logo">
        
        <h2>Selamat Datang Kembali</h2>

        <form method="POST" action="proses_login.php">
            <div class="mb-3 text-start">
                <label class="form-label small fw-bold text-muted">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                    <input type="text" name="username" class="form-control border-start-0" placeholder="Masukkan username" required>
                </div>
            </div>

            <div class="mb-4 text-start">
                <label class="form-label small fw-bold text-muted">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                    <input type="password" name="password" id="passwordField" class="form-control border-start-0" placeholder="••••••••" required>
                    <span class="input-group-text bg-light border-start-0" style="cursor: pointer;" onclick="togglePassword()">
                        <i class="bi bi-eye text-muted" id="toggleIcon"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-login shadow-sm">Masuk Sekarang</button>
            
            <p class="register-link">
                Belum punya akun? <a href="registrasi.php">Daftar Akun Baru</a>
            </p>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk melihat password
    function togglePassword() {
        const passwordField = document.getElementById('passwordField');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>