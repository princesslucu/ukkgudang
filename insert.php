<?php
include ("koneksi.php");

$nama_barang = $_POST ["nama_barang"];
$jumlah_barang = $_POST ["jumlah_barang"];
$kategori = $_POST ["kategori"];
$tanggal_masuk = $_POST ["tanggal_masuk"];
$harga_barang = $_POST ["harga_barang"];

try {
    $koneksi->query
    ("INSERT INTO barang (nama_barang, jumlah_barang, kategori, tanggal_masuk, harga_barang) VALUE ('$nama_barang', '$jumlah_barang', '$kategori', '$tanggal_masuk', '$harga_barang')");
    echo "<script>window.location.href='tampil_data.php';</script>";

}catch (exception $e) {
    ?>
    <script type="text/javascript">
        alert('Data gagal ditambahkan');
        setTimeout("location.href='tampil_data.php'", 1000);
    </script>
    <?php
}



?>