<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$nama = trim($_POST['nama'] ?? '');
$noAnggota = trim($_POST['no_anggota'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');

$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
} elseif (mb_strlen($nama) > 255) {
    $errors[] = "Nama maksimal 255 karakter.";
}
if ($noAnggota === '') {
    $errors[] = "No. Anggota wajib diisi.";
} elseif (mb_strlen($noAnggota) > 50) {
    $errors[] = "No. Anggota maksimal 50 karakter.";
}
if ($alamat !== '' && mb_strlen($alamat) > 255) {
    $errors[] = "Alamat maksimal 255 karakter.";
}
if ($noHp !== '' && !preg_match('/^[0-9+\-\s]{6,30}$/', $noHp)) {
    $errors[] = "No. HP hanya boleh berisi angka, spasi, tanda + atau -.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO anggota (nama, no_anggota, alamat, no_hp)
         VALUES (:nama, :no_anggota, :alamat, :no_hp)
         RETURNING id"
    );
    $stmt->execute([
        'nama' => $nama,
        'no_anggota' => $noAnggota,
        'alamat' => $alamat,
        'no_hp' => $noHp,
    ]);
} catch (PDOException $e) {
    // Kode 23505 = unique_violation di PostgreSQL (no_anggota sudah dipakai)
    if ($e->getCode() === '23505') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => "No. Anggota \"$noAnggota\" sudah terdaftar. Gunakan nomor lain."];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menyimpan data anggota. Coba lagi.'];
    }
    header('Location: tambah.php');
    exit;
}

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;