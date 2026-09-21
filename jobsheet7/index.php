<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';

// Menghitung total film dari session
$totalFilm = count($_SESSION['film'] ?? []);
$totalAnggota = count($_SESSION['anggota'] ?? []);
?>
<section>
    <h2>Selamat Datang di Sistem Informasi Film Mini</h2>
    <p>Aplikasi sederhana untuk mengelola data film dan anggota secara dinamis.</p>
</section>

<section>
    <h2>Ringkasan</h2>
    <article>
        <h3>Total Film</h3>
        <p><?php echo $totalFilm; ?></p>
    </article>
    <article>
        <h3>Total Anggota</h3>
        <p><?php echo $totalAnggota; ?></p>
    </article>
    <article>
        <h3>Sedang Dipinjam</h3>
        <p>0</p>
    </article>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>