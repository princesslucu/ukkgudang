<?php
include("koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nama_barang'])) {
    $nama_toko = $_POST['nama_toko'];
    $nama_barang = $_POST['nama_barang'];
    $jml_barang_keluar = (int)$_POST['jml_barang_keluar'];
    $tgl_keluar = $_POST['tgl_keluar'];
    $harga_barang = (int)$_POST['harga_barang'];
    $sub_total = $harga_barang * $jml_barang_keluar;

    // Pastikan stok cukup sebelum distribusi
    $cekStokQuery = "SELECT jumlah_barang FROM barang WHERE nama_barang = ?";
    $stmtCekStok = $koneksi->prepare($cekStokQuery);
    $stmtCekStok->bind_param("s", $nama_barang);
    $stmtCekStok->execute();
    $stokResult = $stmtCekStok->get_result();
    $stokData = $stokResult->fetch_assoc();

    if (!$stokData || $stokData['jumlah_barang'] < $jml_barang_keluar) {
        die("Error: Stok tidak cukup!");
    }

    // Mulai transaksi
    $koneksi->begin_transaction();


    try {
        // Insert ke tabel distribusi
        $query1 = "INSERT INTO distribusi (nama_toko, nama_barang, tgl_keluar, jml_barang_keluar, harga_barang, sub_total) 
                   VALUES (?, ?, ?, ?, ?, ?)";
        $stmt1 = $koneksi->prepare($query1);
        $stmt1->bind_param("sssiii", $nama_toko, $nama_barang, $tgl_keluar, $jml_barang_keluar, $harga_barang, $sub_total);
        $stmt1->execute();

        // Update stok barang
        $query2 = "UPDATE barang SET jumlah_barang = jumlah_barang - ? WHERE nama_barang = ?";
        $stmt2 = $koneksi->prepare($query2);
        $stmt2->bind_param("is", $jml_barang_keluar, $nama_barang);
        $stmt2->execute();

        // Retrieve toko data
$tokoList = $koneksi->query("SELECT * FROM toko");

        // Commit transaksi
        $koneksi->commit();

        echo "Distribusi berhasil!";
        header("Location: distribusi.php");
        exit();
    } catch (Exception $e) {
        $koneksi->rollback();
        die("Error: " . $e->getMessage());
    }
} else {
    die("Data gagal ditambahkan!");
}
?>