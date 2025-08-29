<?php
session_start();
if (isset($_SESSION['role'])) {
    // Kalau sudah login langsung ke dashboard sesuai role
    header("Location: dashboard_" . $_SESSION['role'] . ".php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Portal Sekolah</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Selamat Datang di Sistem Sekolah</h2>
  <p>Pilih login sesuai peran Anda:</p>
  <ul>
    <li><a href="login_siswa.php">Login Siswa</a></li>
    <li><a href="login_guru.php">Login Guru</a></li>
    <li><a href="login_admin.php">Login Admin</a></li>
  </ul>
</body>
</html>
