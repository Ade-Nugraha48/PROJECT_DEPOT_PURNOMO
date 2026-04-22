<?php
session_start();
require_once __DIR__ . "/../../includes/auth_middleware.php";
require_once __DIR__ . "/../../config/database.php";

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

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
    <title>Konfirmasi Checkout | Depot Purnomo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary: #2c3e50; }
        body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        .checkout-card { background: white; border-radius: 20px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        #map { height: 350px; width: 100%; border-radius: 15px; margin-bottom: 10px; }
        .order-summary { background: #fcfcfc; border-radius: 15px; padding: 20px; border: 1px solid #eee; }
        .btn-checkout { border-radius: 12px; padding: 12px; font-weight: 700; background: #27ae60; border: none; }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-5 order-lg-2 mb-4">
            <div class="checkout-card p-4">
                <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>
                <div class="order-summary mb-4">
                    <?php foreach ($items as $it): ?>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <div>
                            <span class="fw-bold d-block"><?= $it['nama_barang']; ?></span>
                            <small class="text-muted"><?= $it['quantity']; ?> x Rp <?= number_format($it['harga_barang'], 0, ',', '.'); ?></small>
                        </div>
                        <span class="fw-bold">Rp <?= number_format($it['subtotal'], 0, ',', '.'); ?></span>
                    </div>
                    <?php endforeach; ?>
                    <div class="d-flex justify-content-between pt-2">
                        <h5 class="fw-bold">Total</h5>
                        <h5 class="fw-bold text-success">Rp <?= number_format($total, 0, ',', '.'); ?></h5>
                    </div>
                </div>
                <a href="cart.php" class="btn btn-light w-100 rounded-3 text-muted">
                    <i class="bi bi-pencil-square me-2"></i>Ubah Keranjang
                </a>
            </div>
        </div>

        <div class="col-lg-7 order-lg-1">
            <div class="checkout-card p-4">
                <h4 class="fw-bold mb-4">Informasi Pengiriman</h4>
                <form method="POST" action="proses_pesanan.php">
                    <div class="mb-4">
                        <label class="form-label fw-bold small">Alamat Lengkap</label>
                        <textarea class="form-control rounded-3" name="alamat_lengkap" rows="3" required placeholder="Contoh: Jl. Melati No. 4, RT 01/02, Perumahan Indah"></textarea>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-bold small mb-0">Pin Lokasi Peta</label>
                            <button type="button" onclick="getLocation()" class="btn btn-sm btn-outline-primary border-0 rounded-pill">
                                <i class="bi bi-crosshair me-1"></i> Gunakan Lokasi Saya
                            </button>
                        </div>
                        <div id="map"></div>
                        <div class="alert alert-info py-2 small rounded-3">
                            <i class="bi bi-info-circle me-2"></i> Geser pin merah tepat di lokasi rumah Anda.
                        </div>
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">
                    </div>

                    <button type="submit" class="btn btn-success btn-checkout w-100 shadow-sm">
                        <i class="bi bi-bag-check-fill me-2"></i> Buat Pesanan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script async src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    var map = L.map('map').setView([-7.2504, 112.7688], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var marker = L.marker([-7.2504, 112.7688], {draggable: true}).addTo(map);

    marker.on('dragend', function(e) {
        var pos = marker.getLatLng();
        document.getElementById('latitude').value = pos.lat;
        document.getElementById('longitude').value = pos.lng;
    });
    
    function getLocation() {
        map.locate({setView: true, maxZoom: 16});
    }
    map.on('locationfound', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementById('latitude').value = e.latlng.lat;
        document.getElementById('longitude').value = e.latlng.lng;
    });
</script>

</body>
</html>

