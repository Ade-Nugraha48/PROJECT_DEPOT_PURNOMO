<?php
session_start();
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

$id_user = $_SESSION['id_user'];

// Ambil data user terbaru
$query = "SELECT username, no_telp FROM users WHERE id_user = '$id_user'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);

$success_msg = "";
$error_msg = "";

// Proses Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);

    if (!empty($username) && !empty($no_telp)) {
        $update_query = "UPDATE users SET username = '$username', no_telp = '$no_telp' WHERE id_user = '$id_user'";
        if (mysqli_query($koneksi, $update_query)) {
            $_SESSION['username'] = $username; // Update session agar nama di navbar berubah
            $success_msg = "Profil berhasil diperbarui!";
            // Refresh data lokal
            $user['username'] = $username;
            $user['no_telp'] = $no_telp;
        } else {
            $error_msg = "Gagal memperbarui profil.";
        }
    } else {
        $error_msg = "Semua kolom harus diisi.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profil | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary-color: #2c3e50; }
        body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        .navbar-custom { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        
        .profile-card {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            max-width: 500px;
            margin: 40px auto;
        }
        
        .avatar-placeholder {
            width: 80px;
            height: 80px;
            background: #eef2f7;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 20px;
            font-size: 2rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
        }

        .btn-update {
            background: var(--primary-color);
            color: white;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            border: none;
            transition: all 0.3s;
        }

        .btn-update:hover { background: #1a252f; color: white; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-dark" href="dashboard_pelanggan.php">
            <i class="bi bi-chevron-left me-2"></i> PENGATURAN PROFIL
        </a>
    </div>
</nav>

<div class="container px-4">
    <div class="card profile-card">
        <div class="card-body p-4 p-md-5">
            <div class="text-center">
                <div class="avatar-placeholder">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h4 class="fw-bold mb-1"><?= htmlspecialchars($user['username']) ?></h4>
                <p class="text-muted small mb-4">Pelanggan Depot Purnomo</p>
            </div>

            <?php if ($success_msg): ?>
                <div class="alert alert-success border-0 small rounded-3 mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i> <?= $success_msg ?>
                </div>
            <?php endif; ?>

            <?php if ($error_msg): ?>
                <div class="alert alert-danger border-0 small rounded-3 mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $error_msg ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0" style="border-radius: 12px 0 0 12px;">
                            <i class="bi bi-person text-muted"></i>
                        </span>
                        <input type="text" name="username" class="form-control border-start-0" 
                               style="border-radius: 0 12px 12px 0;"
                               value="<?= htmlspecialchars($user['username']) ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Nomor WhatsApp</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0" style="border-radius: 12px 0 0 12px;">
                            <i class="bi bi-whatsapp text-muted"></i>
                        </span>
                        <input type="text" name="no_telp" class="form-control border-start-0" 
                               style="border-radius: 0 12px 12px 0;"
                               value="<?= htmlspecialchars($user['no_telp']) ?>" required>
                    </div>
                    <div class="form-text mt-2" style="font-size: 0.75rem;">
                        Gunakan format angka saja (contoh: 08123456789)
                    </div>
                </div>

                <button type="submit" class="btn btn-update mb-3">
                    Simpan Perubahan
                </button>
                
                <a href="dashboard_pelanggan.php" class="btn btn-link w-100 text-decoration-none text-muted small">
                    Batal
                </a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>