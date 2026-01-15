<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

$dataFile = "../data/videos.json";
$id = isset($_GET['id']) ? (int)$_GET['id'] : -1;

if (!file_exists($dataFile)) {
  die("Data tidak ditemukan.");
}

$videos = json_decode(file_get_contents($dataFile), true);
$videos = is_array($videos) ? $videos : [];

if (!isset($videos[$id])) {
  die("Video tidak valid.");
}

/* === UPDATE JUDUL === */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $newTitle = trim($_POST['title']);

  if ($newTitle === '') {
    $error = "Judul tidak boleh kosong.";
  } else {
    $videos[$id]['title'] = $newTitle;
    file_put_contents($dataFile, json_encode($videos, JSON_PRETTY_PRINT));
    header("Location: dashboard.php?edited=1");
    exit;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Judul Video</title>
  <style>
    body{background:#000;color:#fff;font-family:Arial;padding:20px}
    input,button{width:100%;padding:10px;margin-top:10px}
    button{background:#e50914;color:#fff;border:0}
  </style>
</head>
<body>

<h2>Edit Judul Video</h2>

<?php if(isset($error)): ?>
  <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="post">
  <input type="text" name="title"
         value="<?= htmlspecialchars($videos[$id]['title']) ?>"
         required>
  <button type="submit">💾 Simpan</button>
</form>

<a href="dashboard.php" style="color:red">⬅ Kembali</a>

</body>
</html>
