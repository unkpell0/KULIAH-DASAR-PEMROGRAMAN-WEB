<?php
require __DIR__ . '/../includes/auth.php';
require_login('../');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_id'])) {
    $hapusId = (int) $_POST['hapus_id'];
    try {
        $del = $pdo->prepare("DELETE FROM film WHERE id = :id");
        $del->execute(['id' => $hapusId]);
        if ($del->rowCount() === 0) {
            $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Film tidak ditemukan.'];
        } else {
            $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Film berhasil dihapus.'];
        }
    } catch (PDOException $e) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus data film. Coba lagi.'];
    }
    header('Location: list.php');
    exit;
}

$page_title = "Daftar Film";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarFilm = $pdo->query("SELECT * FROM film ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
    <div class="section-head">
        <h2>Daftar Film</h2>
        <a href="tambah.php" class="btn-create">+ Create</a>
    </div>
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
                                <a href="edit.php?id=<?php echo (int) $film['id']; ?>" class="btn-edit">Edit</a>
                                <form method="post" action="list.php" class="form-hapus">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="hapus_id" value="<?php echo (int) $film['id']; ?>">
                                    <button type="submit" class="btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>