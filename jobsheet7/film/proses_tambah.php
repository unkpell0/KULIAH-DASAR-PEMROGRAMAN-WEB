<?php
session_start();

$judul = trim($_POST['judul'] ?? '');
$sutradara = trim($_POST['sutradara'] ?? '');
$tahun = $_POST['tahun'] ?? '';
$durasi = $_POST['durasi'] ?? '';
$rating = $_POST['rating'] ?? '';
$genre = trim($_POST['genre'] ?? '');

$errors = [];

if ($judul === '') {
    $errors[] = "Judul Film wajib diisi.";
}
if ($sutradara === '') {
    $errors[] = "Sutradara wajib diisi.";
}
if (!is_numeric($tahun) || $tahun < 1900 || $tahun > 2026) {
    $errors[] = "Tahun rilis harus di antara 1900-2026.";
}
if (!is_numeric($durasi) || $durasi <= 0) {
    $errors[] = "Durasi film harus lebih dari 0 menit.";
}
if (!is_numeric($rating) || $rating < 0 || $rating > 10) {
    $errors[] = "Rating harus berada di antara 0 hingga 10.";
}
if ($genre === '') {
    $errors[] = "Genre wajib dipilih.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

if (!isset($_SESSION['film'])) {
    $_SESSION['film'] = [];
}

$_SESSION['film'][] = [
    'judul' => $judul,
    'sutradara' => $sutradara,
    'tahun' => (int) $tahun,
    'durasi' => (int) $durasi,
    'rating' => (float) $rating,
    'genre' => $genre,
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data film berhasil ditambahkan.'];
header('Location: list.php');
exit;