<?php
// lokasi file JSON
$dataFile = __DIR__ . "/data/videos.json";

// baca data
$videos = [];

if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $videos = json_decode($json, true);

    if (!is_array($videos)) {
        $videos = [];
    }
}

// filter khusus Action
$actionVideos = array_filter($videos, function($v){
    return isset($v['genre']) && strtolower($v['genre']) === 'comedy';
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Streamflix - Comedy</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="/Asset/style.css">
</head>

<body>

<header class="navbar">
    <div class="left-area">
  <a href="/index.php" class="text-button">STREAMFLIX</a>
      <!-- TAB GENRE -->
    <div class="tabs">
      <a href="action.php">Action</a>
      <a href="drama.php">Drama</a>
      <a href="comedy.php">Comedy</a>
      <a href="horror.php">Horror</a>
      <a href="anime.php">Anime</a>
    </div>
</header>

<main class="container">
  <h2>Comedy Movies</h2>

  <div class="video-grid">

    <?php foreach ($actionVideos as $i => $v): ?>
      <div class="card">

        <img src="<?= htmlspecialchars($v['cover']) ?>"
             alt="<?= htmlspecialchars($v['title']) ?>">

        <h3><?= htmlspecialchars($v['title']) ?></h3>

        <p class="desc">
          <?= nl2br(htmlspecialchars($v['description'])) ?>
        </p>

          <a class="btn" href="watch.php?id=<?= $i ?>">
            ▶ Play
          </a>

      </div>
    <?php endforeach; ?>

    <?php if (empty($actionVideos)): ?>
      <p>There are no videos in this genre.</p>
    <?php endif; ?>

  </div>
</main>

<footer class="footer">
  © <?= date('Y') ?> Streamflix. All rights reserved.
</footer>

</body>
</html>
