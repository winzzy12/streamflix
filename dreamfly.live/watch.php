<?php
$dataFile = __DIR__ . "/data/videos.json";

$videos = file_exists($dataFile)
  ? json_decode(file_get_contents($dataFile), true)
  : [];

$id = isset($_GET['id']) ? (int)$_GET['id'] : -1;

if (!isset($videos[$id])) {
  die("Video tidak ditemukan.");
}

$video = $videos[$id];
$videoPath = $video['video'];
$title = $video['title'] ?? "Untitled";
$desc = $video['description'] ?? "";
$genre = $video['genre'] ?? "";
?>
<!DOCTYPE html>
<html>
<head>
<title>Watch - <?= htmlspecialchars($title) ?></title>

<link rel="stylesheet" href="Asset/style.css">

<style>
body{
  background:#000;
  color:#fff;
  margin:0;
  min-height:100vh;
  display:flex;
  flex-direction:column;
}

/* area utama tengah */
.center-area{
  flex:1;
  display:flex;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  padding:15px;
  text-align:center;
}

/* video player */
video{
  width:100%;
  max-width:900px;
  border-radius:12px;
  background:#000;
  box-shadow:0 0 20px rgba(255,255,255,.1);
}

/* 🔴 BACK BUTTON MERAH DI BAWAH JUDUL */
.back-btn{
  display:inline-block;
  margin-top:12px;
  padding:10px 22px;
  border-radius:999px;
  background:#d40000;
  color:#fff;
  text-decoration:none;
  font-size:14px;
  font-weight:700;
  border:1px solid #ff4d4d;
  transition:.2s;
  box-shadow:0 0 12px rgba(255,0,0,.35);
}

.back-btn:hover{
  background:#ff0000;
  border-color:#ff7070;
}

/* sembunyikan tombol download */
video::-internal-media-controls-download-button{display:none;}
video::-webkit-media-controls-enclosure{overflow:hidden;}

.title{
  margin-top:15px;
  font-size:22px;
  font-weight:700;
}

.meta{
  opacity:.7;
  margin-top:4px;
}

.desc{
  max-width:850px;
  margin-top:10px;
  opacity:.85;
}
</style>
</head>

<body>

<header class="navbar">
  <h1>STREAMFLIX</h1>
</header>

<div class="center-area">

  <!-- VIDEO -->
  <video
    controls
    playsinline
    preload="metadata"
    controlsList="nodownload noplaybackrate"
  >
    <source src="<?= htmlspecialchars($videoPath) ?>" type="video/mp4">
  </video>

  <!-- JUDUL -->
  <div class="title"><?= htmlspecialchars($title) ?></div>

  <?php if($desc): ?>
    <div class="desc">
      <?= nl2br(htmlspecialchars($desc)) ?>
    </div>
  <?php endif; ?>

 <!-- 🔴 BACK BUTTON DI BAWAH JUDUL -->
  <a href="index.php" class="back-btn">Home</a>

  <a href="javascript:if(history.length>1){history.back()}else{window.location='index.php'}" class="back-btn">
  ⬅ Back
</a>



</div>

<footer class="footer">
  © <?= date('Y') ?> Streamflix. All rights reserved.
</footer>

</body>
</html>
