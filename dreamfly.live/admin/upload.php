<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

$dataFile = "../data/videos.json";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $title = trim($_POST['title']);
  $genre = trim($_POST['genre']);

  
  /* ===== Deskripsi ===== */
  $description = trim($_POST['description']);


  /* ===== UPLOAD COVER ===== */
  if ($_FILES['cover']['error'] !== UPLOAD_ERR_OK) {
    die("Gagal upload cover. Error: " . $_FILES['cover']['error']);
  }

  $allowedImage = ['jpg','jpeg','png','webp'];
  $coverExt = strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION));

  if (!in_array($coverExt, $allowedImage)) {
    die("Format cover tidak didukung!");
  }

$coverExt = strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION));
$coverName = 'cover_' . time() . '_' . uniqid() . '.' . $coverExt;
$coverPath = "../gambar_cover/" . $coverName;


  move_uploaded_file($_FILES['cover']['tmp_name'], $coverPath);

  /* ===== UPLOAD VIDEO ===== */
  if ($_FILES['video']['error'] !== UPLOAD_ERR_OK) {
    die("Gagal upload video. Error: " . $_FILES['video']['error']);
  }

$videoExt = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));
$videoName = 'video_' . time() . '_' . uniqid() . '.' . $videoExt;
$videoPath = "../Videos/" . $videoName;


  move_uploaded_file($_FILES['video']['tmp_name'], $videoPath);

  /* ===== SIMPAN DATA ===== */
  $videos = file_exists($dataFile)
    ? json_decode(file_get_contents($dataFile), true)
    : [];

$videos[] = [
  "title" => $title,
  "description" => $description,
  "genre" => $genre,
  "cover" => "gambar_cover/".$coverName,
  "video" => "Videos/".$videoName
];



  file_put_contents($dataFile, json_encode($videos, JSON_PRETTY_PRINT));

  $success = true;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Upload Video</title>
  <style>
    body{background:#000;color:#fff;font-family:Arial;padding:20px}
    input,button{width:100%;padding:10px;margin-top:10px}
    button{background:#e50914;color:#fff;border:0}
  </style>
</head>
<body>

<h2>Upload Video</h2>
<?php if(isset($success)): ?>
  <p style="color:lime">Upload berhasil!</p>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
  <input type="text" name="title" placeholder="Judul Video" required>
  
  <select name="genre" required>
  <option value="">-- Pilih Genre --</option>
  <option value="Action">Action</option>
  <option value="Drama">Drama</option>
  <option value="Comedy">Comedy</option>
  <option value="Horror">Horror</option>
  <option value="Anime">Anime</option>
</select>

  <textarea name="description"
          placeholder="Deskripsi video"
          required
          style="width:100%;height:80px;padding:10px;margin-top:10px"></textarea>
  <label>Cover Video</label>
  <input type="file" name="cover" accept="image/*" required>
  
  <label style="margin-top:15px;display:block">File Video</label>
  <input type="file" name="video" accept="video/*" required>
  
  <button type="submit">Upload</button>
</form>

<a href="dashboard.php" style="color:#e50914;display:block;margin-top:15px">
  ⬅ Kembali ke Dashboard
</a>

</body>
</html>
