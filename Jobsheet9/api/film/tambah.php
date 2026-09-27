<?php
$page_title = "Tambah Film";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<section>
    <h2>Tambah Film</h2>
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_tambah.php">
        <p>
            <label for="judul">Judul Film</label><br>
            <input type="text" id="judul" name="judul" required>
        </p>
        <p>
            <label for="sutradara">Sutradara</label><br>
            <input type="text" id="sutradara" name="sutradara" required>
        </p>
        <p>
            <label for="tahun">Tahun Rilis</label><br>
            <input type="number" id="tahun" name="tahun" min="1900" max="2026" required>
        </p>
        <p>
            <label for="durasi">Durasi (Menit)</label><br>
            <input type="number" id="durasi" name="durasi" min="1" required>
        </p>
        <p>
            <label for="rating">Rating (0 - 10)</label><br>
            <input type="number" id="rating" name="rating" min="0" max="10" step="0.1" required>
        </p>
        <p>
            <label for="genre">Genre</label><br>
            <select id="genre" name="genre" required>
                <option value="">-- Pilih Genre --</option>
                <option value="action">Action</option>
                <option value="animasi">Animasi</option>
                <option value="drama">Drama</option>
                <option value="komedi">Komedi</option>
                <option value="sci-fi">Sci-Fi</option>
                <option value="thriller">Thriller</option>
            </select>
        </p>
        <p>
            <button type="submit">Simpan</button>
        </p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>