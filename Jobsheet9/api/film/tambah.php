<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$errors = [];
$judul = $sutradara = $tahun = $durasi = $rating = $genre = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $sutradara = trim($_POST['sutradara'] ?? '');
    $tahun = $_POST['tahun'] ?? '';
    $durasi = $_POST['durasi'] ?? '';
    $rating = $_POST['rating'] ?? '';
    $genre = trim($_POST['genre'] ?? '');

    if ($judul === '') $errors[] = "Judul Film wajib diisi.";
    if ($sutradara === '') $errors[] = "Sutradara wajib diisi.";
    if (!is_numeric($tahun) || $tahun < 1900 || $tahun > 2026) $errors[] = "Tahun rilis harus di antara 1900-2026.";
    if (!is_numeric($durasi) || $durasi <= 0) $errors[] = "Durasi film harus lebih dari 0 menit.";
    if (!is_numeric($rating) || $rating < 0 || $rating > 10) $errors[] = "Rating harus berada di antara 0 hingga 10.";
    if ($genre === '') $errors[] = "Genre wajib dipilih.";

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO film (judul, sutradara, tahun, durasi, rating, genre)
                 VALUES (:judul, :sutradara, :tahun, :durasi, :rating, :genre)"
            );
            $stmt->execute([
                'judul' => $judul,
                'sutradara' => $sutradara,
                'tahun' => (int) $tahun,
                'durasi' => (int) $durasi,
                'rating' => (float) $rating,
                'genre' => $genre,
            ]);
            $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data film berhasil ditambahkan.'];
            header('Location: list.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Gagal menyimpan data film. Coba lagi.';
        }
    }
}

$page_title = "Tambah Film";
include __DIR__ . '/../includes/header.php';
?>
<section>
    <h2>Tambah Film</h2>
    <?php if (!empty($errors)): ?>
        <p class="flash flash-error"><?php echo htmlspecialchars(implode(' ', $errors)); ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="tambah.php">
        <p>
            <label for="judul">Judul Film</label><br>
            <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($judul); ?>" required>
        </p>
        <p>
            <label for="sutradara">Sutradara</label><br>
            <input type="text" id="sutradara" name="sutradara" value="<?php echo htmlspecialchars($sutradara); ?>" required>
        </p>
        <p>
            <label for="tahun">Tahun Rilis</label><br>
            <input type="number" id="tahun" name="tahun" min="1900" max="2026" value="<?php echo htmlspecialchars((string) $tahun); ?>" required>
        </p>
        <p>
            <label for="durasi">Durasi (Menit)</label><br>
            <input type="number" id="durasi" name="durasi" min="1" value="<?php echo htmlspecialchars((string) $durasi); ?>" required>
        </p>
        <p>
            <label for="rating">Rating (0 - 10)</label><br>
            <input type="number" id="rating" name="rating" min="0" max="10" step="0.1" value="<?php echo htmlspecialchars((string) $rating); ?>" required>
        </p>
        <p>
            <label for="genre">Genre</label><br>
            <select id="genre" name="genre" required>
                <option value="">-- Pilih Genre --</option>
                <?php foreach (['action', 'animasi', 'drama', 'komedi', 'sci-fi', 'thriller'] as $g): ?>
                <option value="<?php echo $g; ?>" <?php echo ($genre === $g) ? 'selected' : ''; ?>><?php echo ucfirst($g); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <button type="submit">Simpan</button>
        </p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>