<?php
include("koneksi.php");
$BarangID = $_GET["id"];

$sql = "SELECT * FROM barang WHERE BarangID=$BarangID";
$result = mysqli_query($koneksi, $sql);
$barang = mysqli_fetch_assoc($result);

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

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 16px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color:rgb(23, 10, 58);
            color: #fff;
            cursor: pointer;
        }

        .btn:hover {
            background-color:rgb(25, 9, 39);
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Edit Barang</h2>

    <?php if ($barang): ?>
        <form action="update.php" method="POST">
            <input type="hidden" name="BarangID" value="<?php echo $barang['BarangID']; ?>">

            <div class="form-group">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" name="nama_barang" value="<?php echo $barang['nama_barang']; ?>" required>
            </div>

            <div class="form-group">
                <label for="jumlah_barang">Jumlah Barang:</label>
                <input type="number" name="jumlah_barang" value="<?php echo $barang['jumlah_barang']; ?>">
            </div>

            <div class="form-group">
              <label>Kategori:</label>
              <select name="kategori" required>
              <option value="" selected disabled>-- Pilih Kategori --</option>
              <option value="1">Parfum perempuan</option>
              <option value="2">Parfum laki laki</option>
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
                <input type="date" name="tanggal_masuk" value="<?php echo $barang['tanggal_masuk']; ?>">
            </div>

            <div>
                <label class="form-label">Harga Barang:</label>
                <div class="input-group">
                  <span class="input-group-text">Rp</span>
                <input type="number" name="harga_barang" class="form-control" required>
            </div>
                </div>
            <button type="submit" class="btn btn-primary">Update Barang</button>
            <a href="tampil_data.php" class="btn btn-secondary">Kembali</a>
        </form>
    <?php else: ?>
        <p>Barang tidak ditemukan.</p>
    <?php endif; ?>
</div>
</body>
</html>