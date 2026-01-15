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
  $description = trim($_POST['description']);
  $videoLink = trim($_POST['video_link']); // <-- LINK VIDEO

  /* ===== UPLOAD COVER ===== */
  if ($_FILES['cover']['error'] !== UPLOAD_ERR_OK) {
    die("Gagal upload cover. Error: " . $_FILES['cover']['error']);
  }

  $allowedImage = ['jpg','jpeg','png','webp'];
  $coverExt = strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION));

  if (!in_array($coverExt, $allowedImage)) {
    die("Format cover tidak didukung!");
  }

  $coverName = 'cover_' . time() . '_' . uniqid() . '.' . $coverExt;
  $coverPath = "../gambar_cover/" . $coverName;
  move_uploaded_file($_FILES['cover']['tmp_name'], $coverPath);



  /* ================================
      VIDEO OPSIONAL:
      - jika link diisi → pakai link
      - jika tidak → pakai upload
  ================================== */

  $videoPath = "";

  if ($videoLink !== "") {
      // gunakan link sebagai sumber video
      $videoPath = $videoLink;

  } else {

      // wajibkan upload jika tidak ada link
      if ($_FILES['video']['error'] !== UPLOAD_ERR_OK) {
        die("Harus upload video atau isi link video!");
      }

      $videoExt = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));
      $videoName = 'video_' . time() . '_' . uniqid() . '.' . $videoExt;
      $videoPath = "../Videos/" . $videoName;

      move_uploaded_file($_FILES['video']['tmp_name'], $videoPath);

      // simpan tanpa ../ agar cocok dengan watch sekarang
      $videoPath = "Videos/" . $videoName;
  }


  /* ===== SIMPAN DATA ===== */
  $videos = file_exists($dataFile)
    ? json_decode(file_get_contents($dataFile), true)
    : [];

  $videos[] = [
    "title" => $title,
    "description" => $description,
    "genre" => $genre,
    "cover" => "gambar_cover/".$coverName,
    "video" => $videoPath  // <-- bisa file / link
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
    input,button,select,textarea{width:100%;padding:10px;margin-top:10px}
    button{background:#e50914;color:#fff;border:0}
    .note{opacity:.7;font-size:13px}
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
          style="height:80px"></textarea>

  <label>Cover Video</label>
  <input type="file" name="cover" accept="image/*" required>


  <h3>Video Source</h3>

  <label>🎬 Link Video (Opsional)</label>
  <input type="text" name="video_link" placeholder="https://example.com/video.mp4">

  <p class="note">Jika link diisi, upload video boleh dikosongkan.</p>

  <label>📂 Upload File Video (Opsional)</label>
  <input type="file" name="video" accept="video/*">

  <button type="submit">Simpan</button>
</form>

<a href="dashboard.php" style="color:#e50914;display:block;margin-top:15px">
  ⬅ Kembali ke Dashboard
</a>

</body>
</html>
