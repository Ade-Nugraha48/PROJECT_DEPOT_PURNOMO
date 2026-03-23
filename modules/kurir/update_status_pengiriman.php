<?php

require_once "../../config/database.php";

$id_pengiriman = $_GET['id_pengiriman'];

$query = "UPDATE pengiriman
SET status_pengiriman='dalam_pengiriman'
WHERE id_pengiriman='$id_pengiriman'";

mysqli_query($koneksi, $query);

echo "status pengiriman diperbarui";