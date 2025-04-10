<?php
include "koneksi.php";
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION['username']; // Ambil username dari session

?>

<!DOCTYPE html>
<html lang="id">
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
                <img src="download.jpeg" alt="Profile picture" class="rounded-full w-12 h-12 mr-4"/>
                <div class="text-white">
                    <h2 class="text-xl font-semibold"><?= htmlspecialchars($username) ?></h2>
                </div>
            </div>
            <nav>
                <ul>
      <li class="mb-4">
       <a class="flex items-center text-gray-300 hover:text-white" href="index.php">
        <i class="fas fa-home mr-3">
        </i>
        Home
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
                            <i class="fas fa-list mr-3"></i>History
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
                    </div>
                    <div class="grid grid-cols-3 gap-6">
                    <!-- Upcoming Section -->
                    <div class="col-span-3 flex flex-col items-center text-center">
    <h2 class="text-2xl font-semibold mb-4">
        WELCOME <?= htmlspecialchars($username) ?>
    </h2>
    <div class="w-full max-w-lg">
    <img src="perfumegudang.jpeg" alt="Foto Profil" class="w-full h-auto rounded-lg border border-gray-300 shadow-lg object-cover">
    <div>
</div>


                </div>
                </div>
                </body>
                </html>
