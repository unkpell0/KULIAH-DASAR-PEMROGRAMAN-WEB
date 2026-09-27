<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id = (int) ($_POST['id'] ?? 0);

if($id <= 0) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Anggota tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

try {
    $stmt = $pdo->prepare("delete from anggota where id = :id");
    $stmt->execute(['id' => $id]);
    
    if ($stmt->rowCount() === 0){
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Anggota tidak ditemukan.'];
    } else {
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil dihapus.'];
    }
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus data anggota. Coba lagi.'];
}

header('Location: list.php');
exit;