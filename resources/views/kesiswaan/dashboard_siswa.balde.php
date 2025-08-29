<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "siswa") {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Siswa</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Halo, <?= htmlspecialchars($_SESSION["username"]) ?> (Siswa)</h2>
  <p>Anda hanya bisa melihat catatan akademik Anda.</p>
  <a href="logout.php">Logout</a>
</body>
</html>
