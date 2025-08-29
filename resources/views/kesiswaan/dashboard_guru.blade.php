<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "guru") {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Guru</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Halo, <?= htmlspecialchars($_SESSION["username"]) ?> (Guru)</h2>
  <p>Anda bisa melihat dan menambah catatan akademik siswa.</p>
  <a href="logout.php">Logout</a>
</body>
</html>
