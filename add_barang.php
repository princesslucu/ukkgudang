<?php
include "koneksi.php";

if (isset($_POST['tambah'])) {
    $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $jumlah_barang = intval($_POST['jumlah_barang']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $tanggal_masuk = mysqli_real_escape_string($koneksi, $_POST['tanggal_masuk']);
    $harga_barang = floatval($_POST['harga_barang']);

    // Query INSERT
    $sql = "INSERT INTO barang (nama_barang, jumlah_barang, kategori, tanggal_masuk, harga_barang) VALUES (?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("sissd", $nama_barang, $jumlah_barang, $kategori, $tanggal_masuk, $harga_barang);

    if ($stmt->execute()) {
        // Redirect ke tampil_data.php setelah berhasil
        header("Location: tampil_data.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Proses Pencarian
$search_result = [];
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
    $query = "SELECT * FROM barang WHERE nama_barang LIKE '%$search%'";
    $result = $koneksi->query($query);
    while ($row = $result->fetch_assoc()) {
        $search_result[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Barang</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f2f2f2;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Tambah Barang</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="nama_barang">Nama Barang:</label>
            <input type="text" id="nama_barang" name="nama_barang" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="jumlah_barang">Jumlah Barang:</label>
            <input type="number" name="jumlah_barang" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Kategori:</label>
            <select name="kategori" class="form-control" required>
                <option value="" selected disabled>-- Pilih Kategori --</option>
                <option value="1">Parfum perempuan</option>
                <option value="2">Parfum laki-laki</option>
                <?php
            if ($kategori1 != "") {
            echo "<option value='$kategori1'>$kategori1</option>";
          }
            if ($kategori2 != "") {
            echo "<option value='$kategori2'>$kategori2</option>";
          }
          ?>
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal_masuk">Tanggal Masuk:</label>
            <input type="date" id="tanggal_masuk" name="tanggal_masuk" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Harga Barang:</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" name="harga_barang" class="form-control" required>
            </div>
        </div>
        <button type="submit" name="tambah" class="btn btn-primary">Masukkan Barang</button>
        <a href="tampil_data.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>