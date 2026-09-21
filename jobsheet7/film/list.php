<?php
$page_title = "Daftar Film";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarFilm = $_SESSION['film'] ?? [];
?>
<section>
    <h2>Daftar Film</h2>
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <div class="search-box">
        <label for="search-input">Cari Judul Film</label>
        <input type="text" id="search-input" placeholder="Ketik judul film...">
    </div>

    <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Judul Film</th>
                <th>Sutradara</th>
                <th>Tahun</th>
                <th>Durasi</th>
                <th>Rating</th>
                <th>Genre</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($daftarFilm)): ?>
            <tr>
                <td colspan="7">Belum ada data film. Silakan tambah lewat menu "Tambah Film".</td>
            </tr>
            <?php else: ?>
                <?php foreach ($daftarFilm as $film): ?>
                <tr>
                    <td><?php echo htmlspecialchars($film['judul']); ?></td>
                    <td><?php echo htmlspecialchars($film['sutradara']); ?></td>
                    <td><?php echo htmlspecialchars($film['tahun']); ?></td>
                    <td><?php echo htmlspecialchars($film['durasi']); ?> Menit</td>
                    <td><?php echo htmlspecialchars($film['rating']); ?> / 10</td>
                    <td style="text-transform: capitalize;"><?php echo htmlspecialchars($film['genre']); ?></td>
                    <td>
                        <button type="button">Edit</button>
                        <button type="button" class="btn-hapus">Hapus</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>