<?php
$dataFile = __DIR__ . "/data/videos.json";

$videos = file_exists($dataFile)
  ? json_decode(file_get_contents($dataFile), true)
  : [];

$id = isset($_GET['id']) ? (int)$_GET['id'] : -1;

if (!isset($videos[$id])) {
  http_response_code(404);
  die("Video not found");
}

$path = $videos[$id]['video'];

// amankan agar tidak bisa baca file luar folder
$real = realpath($path);
$base = realpath(__DIR__ . "/Videos");

if (strpos($real, $base) !== 0) {
  http_response_code(403);
  die("Access denied");
}

header("Content-Type: video/mp4");
header("Content-Disposition: inline");

// Streaming sederhana
readfile($real);
