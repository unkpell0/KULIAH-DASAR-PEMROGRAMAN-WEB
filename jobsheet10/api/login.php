<?php
require __DIR__ . '/includes/auth.php';

if (!empty($_SESSION['petugas'])) {
    header('Location: index.php');
    exit;
}

// Hash "palsu" supaya password_verify tetap dijalankan walau username tidak ada
// (waktu respons sama -> penyerang tidak bisa menebak username yang terdaftar)
const DUMMY_HASH = '$2y$10$UztbSpgdrH33qye53J.hPONXERbQPyklNOJzTsVdDmjnD15uA5a/6';

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = (string) ($_POST['password'] ?? '');

    $st = $pdo->prepare("SELECT id, nama, password_hash FROM petugas WHERE username = :u");
    $st->execute(['u' => $username]);
    $user = $st->fetch(PDO::FETCH_ASSOC);

    $valid = password_verify($password, $user['password_hash'] ?? DUMMY_HASH);

    if ($user && $valid) {
        session_regenerate_id(true); // ID session baru setelah login (cegah session fixation)
        $_SESSION['petugas'] = ['id' => (int) $user['id'], 'nama' => $user['nama']];
        header('Location: index.php');
        exit;
    }
    $error = 'Username atau password salah.'; // pesan sama untuk kedua kasus
}

$page_title = 'Login';
include __DIR__ . '/includes/header.php';
?>
<section>
    <h2>Login Petugas</h2>
    <?php if ($error): ?>
        <p class="flash flash-error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form id="form-login" method="post" action="login.php">
        <?php echo csrf_field(); ?>
        <p>
            <label for="username">Username</label><br>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" autocomplete="username" required autofocus>
        </p>
        <p>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" autocomplete="current-password" required>
        </p>
        <p>
            <button type="submit">Masuk</button>
        </p>
    </form>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>