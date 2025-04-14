<?php
include("koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nama_barang'])) {
    $nama_toko = $_POST['nama_toko'];
    $nama_barang = $_POST['nama_barang'];
    $jml_barang_keluar = (int)$_POST['jml_barang_keluar'];
    $tgl_keluar = $_POST['tgl_keluar'];
    $harga_barang = (int)$_POST['harga_barang'];
    $sub_total = $harga_barang * $jml_barang_keluar;

    // Validasi jumlah barang
    if ($jml_barang_keluar <= 0) {
        echo "<script>alert('Jumlah barang tidak boleh 0 atau kurang!'); window.location.href='add_distribusi.php';</script>";
        exit;
    }

    // Cek stok barang
    $cekStokQuery = "SELECT jumlah_barang FROM barang WHERE nama_barang = ?";
    $stmtCekStok = $koneksi->prepare($cekStokQuery);
    $stmtCekStok->bind_param("s", $nama_barang);
    $stmtCekStok->execute();
    $stokResult = $stmtCekStok->get_result();
    $stokData = $stokResult->fetch_assoc();

    if (!$stokData || $stokData['jumlah_barang'] < $jml_barang_keluar) {
        echo "<script>alert('Stok tidak cukup!'); window.location.href='add_distribusi.php';</script>";
        exit;
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

        // Commit transaksi
        $koneksi->commit();

        echo "<script>alert('Distribusi berhasil!'); window.location.href='distribusi.php';</script>";
        exit();
    } catch (Exception $e) {
        $koneksi->rollback();
        echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "'); window.location.href='add_distribusi.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Data tidak lengkap!'); window.location.href='add_distribusi.php';</script>";
    exit();
}
?>
