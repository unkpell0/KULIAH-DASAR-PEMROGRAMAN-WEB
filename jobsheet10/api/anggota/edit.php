<?php
require __DIR__ . '/../includes/auth.php';
require_login('../');

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
if ($id <= 0) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Anggota tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = :id");
$stmt->execute(['id' => $id]);
$anggota = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$anggota) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Anggota tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $anggota['nama'] = trim($_POST['nama'] ?? '');
    $anggota['no_anggota'] = trim($_POST['no_anggota'] ?? '');
    $anggota['alamat'] = trim($_POST['alamat'] ?? '');
    $anggota['no_hp'] = trim($_POST['no_hp'] ?? '');

    if ($anggota['nama'] === '') {
        $errors[] = "Nama wajib diisi.";
    } elseif (mb_strlen($anggota['nama']) > 255) {
        $errors[] = "Nama maksimal 255 karakter.";
    }
    if ($anggota['no_anggota'] === '') {
        $errors[] = "No. Anggota wajib diisi.";
    } elseif (mb_strlen($anggota['no_anggota']) > 50) {
        $errors[] = "No. Anggota maksimal 50 karakter.";
    }
    if ($anggota['alamat'] !== '' && mb_strlen($anggota['alamat']) > 255) {
        $errors[] = "Alamat maksimal 255 karakter.";
    }
    if ($anggota['no_hp'] !== '' && !preg_match('/^[0-9+\-\s]{6,30}$/', $anggota['no_hp'])) {
        $errors[] = "No. HP hanya boleh berisi angka, spasi, tanda + atau -.";
    }

    if (empty($errors)) {
        try {
            $upd = $pdo->prepare(
                "UPDATE anggota SET nama = :nama, no_anggota = :no_anggota,
                 alamat = :alamat, no_hp = :no_hp WHERE id = :id"
            );
            $upd->execute([
                'nama' => $anggota['nama'],
                'no_anggota' => $anggota['no_anggota'],
                'alamat' => $anggota['alamat'],
                'no_hp' => $anggota['no_hp'],
                'id' => $id,
            ]);
            $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil diperbarui.'];
            header('Location: list.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23505') {
                $errors[] = "No. Anggota \"{$anggota['no_anggota']}\" sudah dipakai anggota lain.";
            } else {
                $errors[] = 'Gagal memperbarui data anggota. Coba lagi.';
            }
        }
    }
}

$page_title = "Edit Anggota";
include __DIR__ . '/../includes/header.php';
?>
        <section>
            <h2>Edit Anggota</h2>

            <?php if (!empty($errors)): ?>
                <p class="flash flash-error"><?php echo htmlspecialchars(implode(' ', $errors)); ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="edit.php?id=<?php echo $id; ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <p>
                    <label for="nama">Nama</label><br>
                    <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($anggota['nama']); ?>" required>
                </p>
                <p>
                    <label for="no_anggota">No. Anggota</label><br>
                    <input type="text" id="no_anggota" name="no_anggota" value="<?php echo htmlspecialchars($anggota['no_anggota']); ?>" required>
                </p>
                <p>
                    <label for="alamat">Alamat</label><br>
                    <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($anggota['alamat']); ?>">
                </p>
                <p>
                    <label for="no_hp">No. HP</label><br>
                    <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($anggota['no_hp']); ?>">
                </p>
                <p>
                    <button type="submit">Simpan Perubahan</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>