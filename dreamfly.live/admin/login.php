<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // akun admin (hardcode, bisa diganti DB)
  if ($username === "admin" && $password === "wira123") {
    $_SESSION['admin'] = true;
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <style>
    body {background:#000;color:#fff;font-family:Arial}
    .box {width:300px;margin:100px auto;background:#111;padding:20px}
    input,button {width:100%;padding:10px;margin-top:10px}
    button {background:#e50914;color:#fff;border:0}
  </style>
</head>
<body>
  <div class="box">
    <h2>Admin Login</h2>
    <?php if($error): ?><p style="color:red"><?= $error ?></p><?php endif; ?>
    <form method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
