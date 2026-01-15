<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <style>
    body{background:#000;color:#fff;font-family:Arial;padding:20px}
    a{color:#FAFAF9;text-decoration:none}
    .btn{display:inline-block;margin-top:10px;padding:10px;background:#e50914}
  </style>
</head>
<body>
  <h1>Dashboard Admin</h1>
  <a class="btn" href="upload.php">➕Upload Video</a><br><br>
  <a href="logout.php">🚪 Logout</a>
</body>
</html>

<?php
$data = file_exists("../data/videos.json")
  ? json_decode(file_get_contents("../data/videos.json"), true)
  : [];
?>

<h2>Daftar Video</h2>
<?php foreach ($data as $i => $v): ?>
  <div style="margin-bottom:10px">
    <strong><?= htmlspecialchars($v['title']); ?></strong>
    |
    <a href="edit.php?id=<?= $i ?>" style="color:orange">
      ✏️ Edit
    </a>
    |
    <a href="delete.php?id=<?= $i ?>"
       onclick="return confirm('Hapus video ini?')"
       style="color:red">
       🗑 Delete
    </a>
  </div>
<?php endforeach; ?>


