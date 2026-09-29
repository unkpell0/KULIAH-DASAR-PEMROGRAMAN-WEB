<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_id'])) {
    $hapusId = (int) $_POST['hapus_id'];
    try {
        $del = $pdo->prepare("DELETE FROM anggota WHERE id = :id");
        $del->execute(['id' => $hapusId]);
        if ($del->rowCount() === 0) {
            $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Anggota tidak ditemukan.'];
        } else {
            $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil dihapus.'];
        }
    } catch (PDOException $e) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus data anggota. Coba lagi.'];
    }
    header('Location: list.php');
    exit;
}

$page_title = "Daftar Anggota";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarAnggota = $pdo->query("SELECT * FROM anggota ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
    <div class="section-head">
        <h2>Daftar Anggota</h2>
        <a href="tambah.php" class="btn-create">+ Create</a>
    </div>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <div class="search-box">
        <label for="search-input">Cari Nama Anggota</label>
        <input type="text" id="search-input" placeholder="Ketik nama anggota...">
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No. Anggota</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarAnggota)): ?>
                    <tr>
                        <td colspan="5">Belum ada data anggota. Silakan tambah lewat menu "Tambah Anggota".</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarAnggota as $anggota): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($anggota['no_anggota']); ?></td>
                            <td><?php echo htmlspecialchars($anggota['nama']); ?></td>
                            <td><?php echo htmlspecialchars($anggota['alamat']); ?></td>
                            <td><?php echo htmlspecialchars($anggota['no_hp']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo (int) $anggota['id']; ?>" class="btn-edit">Edit</a>
                                <form method="post" action="list.php" class="form-hapus">
                                    <input type="hidden" name="hapus_id" value="<?php echo (int) $anggota['id']; ?>">
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