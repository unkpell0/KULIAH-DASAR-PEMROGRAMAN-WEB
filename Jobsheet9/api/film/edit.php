<?php
session_start();
$page_title = "Edit Film";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM film WHERE id = :id");
$stmt->execute(['id' => $id]);
$film = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$film) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Film tidak ditemukan'];
    header('Location: list.php');
    exit;
}

$genreList = ['action', 'animasi', 'drama', 'komedi', 'sci-fi', 'thriller'];
?>

<section>
    <h2>Edit Film</h2>
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <form action="proses_edit.php" id="form-tambah" method="post">
        <input type="hidden" name="id" value="<?php echo (int) $film['id']; ?>">
        <p>
            <label for="judul">Judul Film</label><br>
            <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($film['judul']); ?>" required>
        </p>
        <p>
            <label for="sutradara">Sutradara</label><br>
            <input type="text" id="sutradara" name="sutradara" value="<?php echo htmlspecialchars($film['sutradara']); ?>" required>
        </p>
        <p>
            <label for="tahun">Tahun Rilis</label><br>
            <input type="number" id="tahun" name="tahun" min="1900" max="2026" value="<?php echo (int) ($film['tahun']); ?>" required>
        </p>
        <p>
            <label for="durasi">Durasi Menit</label><br>
            <input type="number" id="durasi" name="durasi" min="1" value="<?php echo (int) ($film['durasi']); ?>" required>
        </p>
        <p>
            <label for="rating">Rating (0 - 10)</label><br>
            <input type="number" id="rating" name="rating" min="0" max="10" step="0.1" value="<?php echo htmlspecialchars($film['rating']); ?>" required>
        </p>
        <p>
            <label for="genre">Genre</label><br>
            <select name="genre" id="genre" required>
                <option value="">-- Pilih genre --</option>
                <?php foreach($genreList as $g): ?>
                    <option value="<?php echo $g; ?>" <?php echo ($film['genre'] === $g) ? 'selected' : ''; ?>>
                        <?php echo ucfirst($g); ?>
                    </option>
                    <?php endforeach; ?>
            </select>
        </p>
        <p>
            <button type="submit">Simpan Perubahan</button>
        </p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>