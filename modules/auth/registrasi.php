<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun | Depot Purnomo</title>
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 40px 0; /* Memberi ruang di layar kecil */
        }

        .auth-container {
            width: 100%;
            max-width: 450px;
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
            height: 60px;
            margin-bottom: 15px;
        }

        h2 {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        .subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #495057;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            background-color: #fcfcfc;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            border-color: var(--accent-color);
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
            background-color: #f8f9fa;
            border-color: #e0e0e0;
            color: #6c757d;
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            background: var(--primary-color);
            border: none;
            font-weight: 600;
            color: white;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-register:hover {
            background: #1a252f;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .login-link {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 25px;
        }

        .login-link a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        <img src="../../assets/images/logo_depot_purnomo.png" alt="Logo" class="logo">
        
        <h2>Daftar Akun</h2>
        <p class="subtitle">Buat akun untuk mulai memesan air di Depot Purnomo</p>

        <form method="POST" action="proses_registrasi.php">
            <div class="mb-3 text-start">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Pilih username" required>
                </div>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="passField" class="form-control" placeholder="Buat password" required>
                    <button class="btn btn-outline-light border text-muted" type="button" onclick="togglePass()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <div class="mb-4 text-start">
                <label class="form-label">No. Telepon / WhatsApp</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                    <input type="tel" name="no_telp" class="form-control" placeholder="0812xxxx" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
                </div>
            </div>

            <button type="submit" class="btn btn-register shadow-sm">Daftar Sekarang</button>
            
            <p class="login-link">
                Sudah punya akun? <a href="login.php">Masuk di sini</a>
            </p>
        </form>
    </div>
</div>

<script>
    function togglePass() {
        const passField = document.getElementById('passField');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passField.type === 'password') {
            passField.type = 'text';
            eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            passField.type = 'password';
            eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>