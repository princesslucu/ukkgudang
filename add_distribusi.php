<?php
include "koneksi.php";

// Query untuk mengambil data barang dari database (termasuk tanggal masuk)
$query = "SELECT nama_barang, jumlah_barang, harga_barang, tanggal_masuk FROM barang";
$result = mysqli_query($koneksi, $query);

// Konversi hasil query ke array untuk akses di JavaScript
$barangList = [];
while ($row = mysqli_fetch_assoc($result)) {
    $barangList[$row['nama_barang']] = [
        'harga' => $row['harga_barang'],
        'stok' => $row['jumlah_barang'],
        'tanggal_masuk' => $row['tanggal_masuk']
    ];
}

// Query untuk mengambil data toko dari database
$tokoQuery = "SELECT * FROM toko";
$tokoResult = mysqli_query($koneksi, $tokoQuery);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Distribusikan Barang</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data barang dalam bentuk JavaScript Object
            const barangData = <?= json_encode($barangList); ?>;

            function updateDataBarang() {
                const selectedBarang = document.getElementById("nama_barang").value;
                const inputJumlah = document.getElementById("jml_barang_keluar");
                const hargaBarang = document.getElementById("harga_barang");
                const inputTanggalKeluar = document.getElementById("tgl_keluar");

                // Update harga
                hargaBarang.value = barangData[selectedBarang]?.harga || 0;

                // Atur batas jumlah maksimal sesuai stok
                let stok = barangData[selectedBarang]?.stok || 0;
                inputJumlah.max = stok;
                inputJumlah.value = ""; // Reset input jika barang berubah

                // Atur batas minimal tanggal keluar sesuai tanggal masuk
                let tanggalMasuk = barangData[selectedBarang]?.tanggal_masuk;
                inputTanggalKeluar.min = tanggalMasuk ? tanggalMasuk : "";
            }

            function validateJumlah() {
                const selectedBarang = document.getElementById("nama_barang").value;
                const inputJumlah = document.getElementById("jml_barang_keluar");

                let stok = barangData[selectedBarang]?.stok || 0;
                let jumlahKeluar = parseInt(inputJumlah.value) || 0;

                if (jumlahKeluar > stok) {
                    alert("Jumlah barang keluar tidak boleh melebihi stok!");
                    inputJumlah.value = stok; // Set ke nilai maksimal stok
                }
            }

            // Tambahkan event listener untuk perubahan pilihan barang
            document.getElementById("nama_barang").addEventListener("change", updateDataBarang);
            document.getElementById("jml_barang_keluar").addEventListener("change", validateJumlah);
        });
    </script>

    <style>
        body {
            background-color: #f2f2f2;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn {
            background-color: rgb(32, 37, 109);
            color: #fff;
        }
        .btn:hover {
            background-color: rgb(38, 27, 88);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Distribusikan Barang</h2>

        <form action="proses_distribusi.php" method="POST">
            <div class="form-group">
                <label for="nama_toko">Nama Toko:</label>
                <select id="nama_toko" name="nama_toko" class="form-control" required>
                    <option value="" selected disabled>Pilih Toko</option>
                    <?php while ($row = mysqli_fetch_assoc($tokoResult)): ?>
                        <option value="<?= htmlspecialchars($row['nama_toko']); ?>">
                            <?= htmlspecialchars($row['nama_toko']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nama_barang">Nama Barang:</label>
                <select id="nama_barang" name="nama_barang" class="form-control" required>
                    <option value="" selected disabled>Pilih Barang</option>
                    <?php foreach ($barangList as $nama => $info): ?>
                        <option value="<?= htmlspecialchars($nama); ?>">
                            <?= htmlspecialchars($nama); ?> (Stok: <?= htmlspecialchars($info['stok']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="jml_barang_keluar">Jumlah Barang Keluar:</label>
                <input type="number" id="jml_barang_keluar" name="jml_barang_keluar" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="tgl_keluar">Tanggal Keluar:</label>
                <input type="date" id="tgl_keluar" name="tgl_keluar" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Harga Barang:</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" id="harga_barang" name="harga_barang" class="form-control" readonly>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Distribusikan Barang</button>
            <a href="tampil_data.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
        </form>
    </div>
</body>
</html>