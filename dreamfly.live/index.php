<?php
// path file JSON
$dataFile = __DIR__ . "/data/videos.json";

// default kosong
$videos = [];

// baca json jika ada
if (file_exists($dataFile)) {
  $json = file_get_contents($dataFile);
  $videos = json_decode($json, true);
}

// query pencarian
$query = isset($_GET['q']) ? trim($_GET['q']) : '';

// filter search
if ($query !== '') {
  $videos = array_filter($videos, function($v) use ($query) {
    return
      stripos($v['title'], $query) !== false ||
      (!empty($v['description']) && stripos($v['description'], $query) !== false);
  });
}

// pastikan array
$videos = is_array($videos) ? $videos : [];
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Streamflix</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS -->
  <link rel="stylesheet" href="Asset/style.css">
</head>

<body>

<header class="navbar">

  <div class="left-area">

    <h1>STREAMFLIX</h1>

    <!-- TAB GENRE -->
    <div class="tabs">
      <a href="action.php">Action</a>
      <a href="drama.php">Drama</a>
      <a href="comedy.php">Comedy</a>
      <a href="horror.php">Horror</a>
      <a href="anime.php">Anime</a>
    </div>

  </div>

  <!-- SEARCH -->
  <form class="search-box" method="GET">
    <input
      type="text"
      name="q"
      placeholder="Search videos..."
      value="<?= htmlspecialchars($query) ?>"
    >
    <button type="submit">🔍</button>
  </form>

</header>


<section class="container">
  <h2>Trending Videos</h2>

  <?php if (empty($videos)): ?>
    <p style="opacity:.7">Video Not Found</p>
  <?php endif; ?>

  <div class="grid">
    <?php foreach ($videos as $i => $v): ?>
      <div class="card">
        <img src="<?= htmlspecialchars($v['cover']) ?>" alt="<?= htmlspecialchars($v['title']) ?>">

        <div class="overlay">
          <h3><?= htmlspecialchars($v['title']) ?></h3>

          <?php if (!empty($v['description'])): ?>
            <p class="desc">
              <?= nl2br(htmlspecialchars($v['description'])) ?>
            </p>
          <?php endif; ?>

          <a class="btn" href="watch.php?id=<?= $i ?>">
            ▶ Play
          </a>

        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<footer class="footer">
  © <?= date('Y') ?> Streamflix. All rights reserved.
</footer>

<script>
function copyLink(url){
  navigator.clipboard.writeText(url);
  alert("Link copied!");
}
</script>

</body>
</html>
