<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Film tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM film WHERE id = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() === 0) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Film tidak ditemukan.'];
    } else {
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Film berhasil dihapus.'];
    }
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus data film. Coba lagi.'];
}

header('Location: list.php');
exit;