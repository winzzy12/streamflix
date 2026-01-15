<?php
if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], 'watch.php') === false) {
    die("Not Found");
}

$dataFile = __DIR__ . "/data/videos.json";

$videos = file_exists($dataFile)
  ? json_decode(file_get_contents($dataFile), true)
  : [];

$id = isset($_GET['id']) ? (int)$_GET['id'] : -1;

if (!isset($videos[$id])) {
  die("Video tidak ditemukan.");
}

$video = $videos[$id];

// PRIORITAS link eksternal
if (!empty($video['link'])) {
    $videoPath = $video['link'];
} else {
    $videoPath = $video['video'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Player Secure</title>

<style>
body{
  margin:0;
  background:#000;
}
video, iframe{
  width:100%;
  height:100vh;
  border:0;
}
</style>
</head>
<body>

<?php
/* ====== STREAMTAPE / HOST IFRAME ====== */
if (strpos($videoPath, 'byseraguci.com') !== false) {
?>
    <iframe
        src="<?= htmlspecialchars($videoPath) ?>"
        allowfullscreen
        allow="autoplay"
    ></iframe>

<?php
/* ====== VIDEO FILE BIASA ====== */
} else {
?>
    <video
      controls
      playsinline
      preload="metadata"
      controlsList="nodownload noplaybackrate"
    >
      <source src="<?= htmlspecialchars($videoPath) ?>" type="video/mp4">
    </video>
<?php } ?>

</body>
</html>
