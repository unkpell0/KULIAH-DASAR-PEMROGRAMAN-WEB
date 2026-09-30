<?php
require __DIR__ . '/../includes/auth.php';
require_login('../');

$errors = [];
$nama = $noAnggota = $alamat = $noHp = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $noAnggota = trim($_POST['no_anggota'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $noHp = trim($_POST['no_hp'] ?? '');

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

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO anggota (nama, no_anggota, alamat, no_hp)
                 VALUES (:nama, :no_anggota, :alamat, :no_hp)"
            );
            $stmt->execute([
                'nama' => $nama,
                'no_anggota' => $noAnggota,
                'alamat' => $alamat,
                'no_hp' => $noHp,
            ]);
            $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];
            header('Location: list.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23505') {
                $errors[] = "No. Anggota \"$noAnggota\" sudah terdaftar. Gunakan nomor lain.";
            } else {
                $errors[] = 'Gagal menyimpan data anggota. Coba lagi.';
            }
        }
    }
}

$page_title = "Tambah Anggota";
include __DIR__ . '/../includes/header.php';
?>
        <section>
            <h2>Tambah Anggota</h2>

            <?php if (!empty($errors)): ?>
                <p class="flash flash-error"><?php echo htmlspecialchars(implode(' ', $errors)); ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="tambah.php">
                <?php echo csrf_field(); ?>
                <p>
                    <label for="nama">Nama</label><br>
                    <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" required>
                </p>
                <p>
                    <label for="no_anggota">No. Anggota</label><br>
                    <input type="text" id="no_anggota" name="no_anggota" value="<?php echo htmlspecialchars($noAnggota); ?>" required>
                </p>
                <p>
                    <label for="alamat">Alamat</label><br>
                    <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($alamat); ?>">
                </p>
                <p>
                    <label for="no_hp">No. HP</label><br>
                    <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($noHp); ?>">
                </p>
                <p>
                    <button type="submit">Simpan</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>