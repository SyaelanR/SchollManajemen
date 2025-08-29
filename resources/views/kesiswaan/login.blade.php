<?php
session_start();

// Database dummy (sementara)
$users = [
    "siswa1" => "siswa",
    "andi"   => "siswa"
];

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = strtolower(trim($_POST["username"]));
    if (isset($users[$username]) && $users[$username] === "siswa") {
        $_SESSION["username"] = $username;
        $_SESSION["role"] = "siswa";
        header("Location: dashboard_siswa.php");
        exit();
    } else {
        $error = "Login gagal. Username salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Siswa</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Login Siswa</h2>
  <form method="post">
    <input type="text" name="username" placeholder="Nama Siswa" required>
    <button type="submit">Login</button>
  </form>
  <p style="color:red;"><?= $error ?></p>
  <a href="index.php">Kembali</a>
</body>
</html>
