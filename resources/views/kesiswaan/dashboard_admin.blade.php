<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Halo, <?= htmlspecialchars($_SESSION["username"]) ?> (Admin)</h2>
  <p>Anda bisa mengelola data siswa & guru.</p>
  <a href="logout.php">Logout</a>
</body>
</html>
