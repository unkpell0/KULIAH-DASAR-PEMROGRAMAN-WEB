<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id = (int) ($_POST['id'] ?? 0);
$judul = trim($_POST['judul'] ?? '');
$sutradara = trim($_POST['sutradara'] ?? '');
$tahun = $_POST['tahun'] ?? '';
$durasi = $_POST['durasi'] ?? '';
$rating = $_POST['rating'] ?? '';
$genre = trim($_POST['genre'] ?? '');

if ($id <= 0){
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Film tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

$errors = [];
if ($judul === ''){
    $errors[] = "Judul Film wajib diisi.";
}
if ($sutradara === '') {
    $errors[] = "Sutradara wajib diisi";
}
if (!is_numeric($tahun) || $tahun < 1900 || $tahun > 2026) {
    $errors[] = "Tahun rilis harus di antara 1900-2026";
}
if (!is_numeric($durasi) || $durasi <= 0) {
    $errors[] = "Durasi film harus lebih dari 0 menit";
}
if (!is_numeric($rating) || $rating < 0 || $rating > 10) {
    $errors[] = "Rating harus berada di antara 0 hingga 10.";
}
if ($genre === '') {
    $errors[] = "Genre wajib dipilih.";
}

if (!empty($errors)){
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . $id);
    exit;
}

try {
    $stmt = $pdo->prepare(
        "update film
        set judul = :judul,
        sutradara = :sutradara,
        tahun = :tahun,
        durasi = :durasi,
        rating = :rating,
        genre = :genre
        where id = :id"
    );
    $stmt->execute([
        'judul' => $judul,
        'sutradara' => $sutradara,
        'tahun' => (int) $tahun,
        'durasi' => (int) $durasi,
        'rating' => (float) $rating,
        'genre' => $genre,
        'id' => $id,
    ]);

    if ($stmt->rowCount() === 0){
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Film tidak ditemukan'];
        header('Location: list.php');
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memperbarui data film. Coba lagi.'];
    header('Location: edit.php?id=' . $id);
    exit;
}

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Film berhasil diperbarui.'];
header('Location: list.php');
exit;
?>