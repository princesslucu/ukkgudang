<?php
include ("koneksi.php");

$BarangID = $_POST ["BarangID"];
$nama_barang = $_POST ["nama_barang"];
$jumlah_barang = $_POST ["jumlah_barang"];
$kategori = $_POST ["kategori"];
$tanggal_masuk = $_POST ["tanggal_masuk"];
$harga_barang = $_POST ["harga_barang"];

try {
    $koneksi->query
    ("UPDATE barang SET nama_barang = '$nama_barang', jumlah_barang = '$jumlah_barang', kategori = '$kategori', tanggal_masuk = '$tanggal_masuk', harga_barang = '$harga_barang' WHERE BarangID = '$BarangID'");
    echo "<script>window.location.href='tampil_data.php';</script>";

}catch (exception $e) {
    ?>
    <script type="text/javascript">
        alert('Data gagal diedit');
        setTimeout("location.href='edit.php'", 1000);
    </script>
    <?php
}



?>