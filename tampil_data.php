<?php
include "koneksi.php";

$sql = $koneksi->query ("SELECT * FROM barang");
$result = $sql->fetch_all(MYSQLI_ASSOC);


// Ambil kata kunci pencarian jika ada
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : "";

// Query untuk menampilkan data berdasarkan pencarian
if ($search) {
    $sql = "SELECT * FROM barang WHERE nama_barang LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM barang";
}

$result = $koneksi->query($sql);

//echo "<pre>";
//print_r ($result);

?>

<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>GudangKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-1/4 bg-gradient-to-b from-gray-800 to-gray-600 text-white p-6">
            <div class="flex items-center mb-8">
            <?php
                session_start();
                if (!isset($_SESSION['username'])) {
                    header("Location: login.php"); // Jika belum login, kembali ke login
                    exit;
                }
                $username = $_SESSION['username']; // Ambil username dari session
                ?>
                <img src="download.jpeg" alt="Profile picture" class="rounded-full w-12 h-12 mr-4"/>
                <div class="text-white">
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($username) ?></h2>
                </div>
            </div>
            <nav>
                <ul>
                    <li class="mb-4">
                        <a href="index.php" class="flex items-center text-gray-300 hover:text-white">
                            <i class="fas fa-home mr-3"></i> Home
                        </a>
                    </li>
                    <li class="mb-4">
      <a href="tampil_data.php" class="flex items-center text-white">
      <i class="fas fa-box mr-3"></i> Barang
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="add_distribusi.php" class="flex items-center text-white">
                            <i class="fas fa-truck-loading mr-3"></i> Distribusi
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="distribusi.php" class="flex items-center text-white">
                            <i class="fas fa-list mr-3"></i> History
                        </a>
                    </li>
                    <li class="mt-auto">
                        <a href="logout.php" class="flex items-center text-gray-300 hover:text-white">
                            <i class="fas fa-sign-out-alt mr-3"></i> Log out
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <!-- Form Pencarian -->
                <div class="relative w-1/2">
                    <form method="GET" action="" class="relative">
                        <input type="text" name="search" class="form-control pl-10 pr-3 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cari Nama Barang..." value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-500">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <!-- Tombol Tambah Barang -->
                <a href="add_barang.php" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-700 transition duration-300">
                    + Tambah Data
                </a>
            </div>

            <!-- Tabel Data Barang -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-2xl font-semibold mb-4">Data Barang</h2>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2">No</th>
                                <th class="border border-gray-300 px-4 py-2">Nama Barang</th>
                                <th class="border border-gray-300 px-4 py-2">Jumlah</th>
                                <th class="border border-gray-300 px-4 py-2">Kategori</th>
                                <th class="border border-gray-300 px-4 py-2">Tanggal Masuk</th>
                                <th class="border border-gray-300 px-4 py-2">Harga</th>
                                <th class="border border-gray-300 px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $No = 1; ?>
                            <?php foreach ($result as $row): ?>
                            <tr class="text-center hover:bg-gray-100">
                                <td class="border border-gray-300 px-4 py-2"><?= $No++ ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['nama_barang']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['jumlah_barang']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['kategori']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['tanggal_masuk']) ?></td>
                                <td class="border border-gray-300 px-4 py-2">Rp <?= number_format($row['harga_barang'], 0, ',', '.') ?></td>
                                <td class="border border-gray-300 px-4 py-2 flex justify-center space-x-2">
                                    <a href="edit.php?id=<?= $row["BarangID"] ?>" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-700 transition duration-300">Edit</a>
                                    <a href="delete.php?id=<?= $row["BarangID"] ?>" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-700 transition duration-300">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
