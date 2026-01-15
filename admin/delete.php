<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : -1;
$dataFile = "../data/videos.json";

if (!file_exists($dataFile)) {
  die("Data tidak ditemukan.");
}

$videos = json_decode(file_get_contents($dataFile), true);
$videos = is_array($videos) ? $videos : [];

if (!isset($videos[$id])) {
  die("Video tidak valid.");
}

/* === PATH FILE === */
$coverPath = "../" . $videos[$id]['cover'];
$videoPath = "../" . $videos[$id]['video'];

/* === DELETE FILE FISIK === */
if (file_exists($coverPath)) {
  unlink($coverPath);
}

if (file_exists($videoPath)) {
  unlink($videoPath);
}

/* === DELETE DATA JSON === */
unset($videos[$id]);

// rapikan index array
$videos = array_values($videos);

// simpan ulang JSON
file_put_contents($dataFile, json_encode($videos, JSON_PRETTY_PRINT));

header("Location: dashboard.php?deleted=1");
exit;
