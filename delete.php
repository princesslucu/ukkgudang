<?php
Include ("koneksi.php");
$BarangID = $_GET ["id"];

try {

mysqli_query ($koneksi, "DELETE FROM barang WHERE BarangID = $BarangID");

header ("location: tampil_data.php");

}catch (exception $e) {

echo "Hapus data gagal" . $e->getMessage();
}