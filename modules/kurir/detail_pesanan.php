<?php
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

$id_pesanan = intval($_GET['id_pesanan'] ?? 0);

// Ambil info pelanggan & lokasi
$query_pelanggan = "SELECT users.username, users.no_telp, pesanan.alamat_lengkap, pesanan.latitude, pesanan.longitude 
                    FROM pesanan 
                    JOIN users ON pesanan.id_user = users.id_user 
                    WHERE pesanan.id_pesanan = $id_pesanan";
$result_pelanggan = mysqli_query($koneksi, $query_pelanggan);
$data_pelanggan = mysqli_fetch_assoc($result_pelanggan);

// Ambil rincian barang
$query_items = "SELECT barang.nama_barang, detail_pesanan.jumlah, detail_pesanan.harga_satuan
                FROM detail_pesanan
                JOIN barang ON detail_pesanan.id_barang = barang.id_barang
                WHERE id_pesanan = $id_pesanan";
$result_items = mysqli_query($koneksi, $query_items);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Antaran #<?= $id_pesanan ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        :root { --primary: #2c3e50; }
        body { background-color: #f4f7f6; font-family: 'Inter', sans-serif; }
        
        /* Ukuran Peta */
        #map { 
            height: 280px; 
            width: 100%; 
            border-radius: 15px; 
            z-index: 1; /* Pastikan tidak menimpa navbar */
        }
        
        .info-card {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .btn-navigasi {
            background: #4285F4;
            color: white;
            font-weight: 700;
            border-radius: 12px;
            border: none;
        }

        .item-list { background: #fff; border-radius: 15px; padding: 15px; }
        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px dashed #eee;
        }

        .total-section {
            background: var(--primary);
            color: white;
            border-radius: 15px;
            padding: 20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-white bg-white shadow-sm py-3 sticky-top">
    <div class="container">
        <a href="daftar_pengiriman.php" class="text-decoration-none text-dark fw-bold">
            <i class="bi bi-arrow-left me-2"></i> Detail Antaran
        </a>
    </div>
</nav>

<div class="container py-4">
    <div class="card info-card mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="fw-bold mb-1"><?= htmlspecialchars($data_pelanggan['username']) ?></h5>
                    <p class="text-muted small mb-0"><i class="bi bi-geo-alt-fill text-danger"></i> <?= htmlspecialchars($data_pelanggan['alamat_lengkap']) ?></p>
                </div>
                <a href="https://wa.me/<?= preg_replace('/^0/', '62', $data_pelanggan['no_telp']) ?>" class="btn btn-success btn-sm rounded-circle shadow-sm">
                    <i class="bi bi-whatsapp"></i>
                </a>
            </div>

            <?php if ($data_pelanggan['latitude'] && $data_pelanggan['longitude']): ?>
                <div id="map" class="mb-3"></div>
                
                <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $data_pelanggan['latitude'] ?>,<?= $data_pelanggan['longitude'] ?>" 
                   target="_blank" class="btn btn-navigasi w-100 py-3 shadow-sm">
                    <i class="bi bi-cursor-fill me-2"></i> Buka Rute di Google Maps
                </a>
            <?php else: ?>
                <div class="alert alert-warning small rounded-3 border-0">
                    <i class="bi bi-exclamation-triangle me-2"></i> Koordinat lokasi tidak tersedia.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <h6 class="fw-bold mb-3 px-2 text-uppercase small" style="letter-spacing: 1px;">Barang yang dibawa</h6>
    <div class="item-list shadow-sm mb-4">
        <?php 
        $total_qty = 0;
        $total_price = 0;
        while($item = mysqli_fetch_assoc($result_items)): 
            $total_qty += $item['jumlah'];
            $total_price += ($item['jumlah'] * $item['harga_satuan']);
        ?>
        <div class="item-row">
            <div>
                <span class="fw-bold"><?= $item['nama_barang'] ?></span><br>
                <small class="text-muted text-uppercase" style="font-size: 0.65rem;">Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></small>
            </div>
            <div class="text-end">
                <span class="badge bg-light text-dark border fs-6">x <?= $item['jumlah'] ?></span>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <div class="total-section shadow-lg">
        <div class="d-flex justify-content-between mb-2 opacity-75 small text-uppercase">
            <span>Total Muatan</span>
            <span><?= $total_qty ?> Item</span>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Tagihan COD</h5>
            <h4 class="mb-0 fw-bold text-warning">Rp <?= number_format($total_price, 0, ',', '.') ?></h4>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<?php if ($data_pelanggan['latitude'] && $data_pelanggan['longitude']): ?>
<script>
    // Koordinat dari PHP
    const lat = <?= $data_pelanggan['latitude'] ?>;
    const lng = <?= $data_pelanggan['longitude'] ?>;

    // Inisialisasi Map Leaflet
    const map = L.map('map', {
        center: [lat, lng],
        zoom: 16,
        zoomControl: false // Sembunyikan tombol +/- agar tampilan bersih untuk kurir
    });

    // Gunakan provider OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    // Tambahkan Marker
    L.marker([lat, lng]).addTo(map)
        .bindPopup('Lokasi Pengantaran')
        .openPopup();
</script>
<?php endif; ?>

</body>
</html>