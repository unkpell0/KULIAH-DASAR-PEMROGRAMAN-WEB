<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
if ($id <= 0) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Film tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM film WHERE id = :id");
$stmt->execute(['id' => $id]);
$film = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$film) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Film tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $film['judul'] = trim($_POST['judul'] ?? '');
    $film['sutradara'] = trim($_POST['sutradara'] ?? '');
    $film['tahun'] = $_POST['tahun'] ?? '';
    $film['durasi'] = $_POST['durasi'] ?? '';
    $film['rating'] = $_POST['rating'] ?? '';
    $film['genre'] = trim($_POST['genre'] ?? '');

    if ($film['judul'] === '') $errors[] = "Judul Film wajib diisi.";
    if ($film['sutradara'] === '') $errors[] = "Sutradara wajib diisi.";
    if (!is_numeric($film['tahun']) || $film['tahun'] < 1900 || $film['tahun'] > 2026) $errors[] = "Tahun rilis harus di antara 1900-2026.";
    if (!is_numeric($film['durasi']) || $film['durasi'] <= 0) $errors[] = "Durasi film harus lebih dari 0 menit.";
    if (!is_numeric($film['rating']) || $film['rating'] < 0 || $film['rating'] > 10) $errors[] = "Rating harus berada di antara 0 hingga 10.";
    if ($film['genre'] === '') $errors[] = "Genre wajib dipilih.";

    if (empty($errors)) {
        try {
            $upd = $pdo->prepare(
                "UPDATE film SET judul = :judul, sutradara = :sutradara, tahun = :tahun,
                 durasi = :durasi, rating = :rating, genre = :genre WHERE id = :id"
            );
            $upd->execute([
                'judul' => $film['judul'],
                'sutradara' => $film['sutradara'],
                'tahun' => (int) $film['tahun'],
                'durasi' => (int) $film['durasi'],
                'rating' => (float) $film['rating'],
                'genre' => $film['genre'],
                'id' => $id,
            ]);
            $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Film berhasil diperbarui.'];
            header('Location: list.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Gagal memperbarui data film. Coba lagi.';
        }
    }
}

$page_title = "Edit Film";
include __DIR__ . '/../includes/header.php';
?>
<section>
    <h2>Edit Film</h2>
    <?php if (!empty($errors)): ?>
        <p class="flash flash-error"><?php echo htmlspecialchars(implode(' ', $errors)); ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="edit.php?id=<?php echo $id; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <p>
            <label for="judul">Judul Film</label><br>
            <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars((string) $film['judul']); ?>" required>
        </p>
        <p>
            <label for="sutradara">Sutradara</label><br>
            <input type="text" id="sutradara" name="sutradara" value="<?php echo htmlspecialchars((string) $film['sutradara']); ?>" required>
        </p>
        <p>
            <label for="tahun">Tahun Rilis</label><br>
            <input type="number" id="tahun" name="tahun" min="1900" max="2026" value="<?php echo htmlspecialchars((string) $film['tahun']); ?>" required>
        </p>
        <p>
            <label for="durasi">Durasi (Menit)</label><br>
            <input type="number" id="durasi" name="durasi" min="1" value="<?php echo htmlspecialchars((string) $film['durasi']); ?>" required>
        </p>
        <p>
            <label for="rating">Rating (0 - 10)</label><br>
            <input type="number" id="rating" name="rating" min="0" max="10" step="0.1" value="<?php echo htmlspecialchars((string) $film['rating']); ?>" required>
        </p>
        <p>
            <label for="genre">Genre</label><br>
            <select id="genre" name="genre" required>
                <option value="">-- Pilih Genre --</option>
                <?php foreach (['action', 'animasi', 'drama', 'komedi', 'sci-fi', 'thriller'] as $g): ?>
                <option value="<?php echo $g; ?>" <?php echo ($film['genre'] === $g) ? 'selected' : ''; ?>><?php echo ucfirst($g); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <button type="submit">Simpan Perubahan</button>
        </p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>