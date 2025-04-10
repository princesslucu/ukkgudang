<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Gunakan prepared statement untuk mencegah SQL injection
$stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $_SESSION['username'] = $username;
    header("Location: index.php"); // Redirect ke halaman selamat datang
} else {
    ?>
        <script type="text/javascript">
            alert('Username dan Password Salah');
            setTimeout("location.href='login.php'", 1000);
        </script>
        <?php
    }

$stmt->close();
$koneksi->close();
?>