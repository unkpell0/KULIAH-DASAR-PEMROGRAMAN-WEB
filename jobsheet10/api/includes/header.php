<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Di Vercel: set APP_BASE=/ di Environment Variables.
// Di lokal (APP_BASE tidak diset): pakai perhitungan lama.
if (getenv('APP_BASE') !== false) {
    $base = getenv('APP_BASE');
} else {
    $__jobsheetRoot = dirname(__DIR__);
    $__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
    $__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
    $base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);
}

// Tentukan menu yang sedang aktif dari path script yang berjalan
$__path = $_SERVER['SCRIPT_NAME'] ?? '';
if (str_contains($__path, '/film/')) {
    $__section = 'film';
} elseif (str_contains($__path, '/anggota/')) {
    $__section = 'anggota';
} elseif (basename($__path) === 'index.php') {
    $__section = 'home';
} else {
    $__section = '';
}
$__active = fn(string $s): string => $__section === $s ? ' class="active" aria-current="page"' : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIFILM-Mini<?php echo isset($page_title) ? ' | ' . $page_title : ''; ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>
    <header>
        <h1><a href="<?php echo $base; ?>index.php">SIFILM-Mini</a></h1>
        <button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>
        <nav>
            <ul>
                <?php if (!empty($_SESSION['petugas'])):
                    $__nama = $_SESSION['petugas']['nama'];
                    // huruf pertama (aman untuk karakter UTF-8, tanpa butuh ekstensi mbstring)
                    $__inisial = strtoupper(preg_match('/^./u', $__nama, $__m) ? $__m[0] : '?');
                ?>
                <li><a href="<?php echo $base; ?>index.php"<?php echo $__active('home'); ?>>Beranda</a></li>
                <li><a href="<?php echo $base; ?>film/list.php"<?php echo $__active('film'); ?>>Daftar Film</a></li>
                <li><a href="<?php echo $base; ?>anggota/list.php"<?php echo $__active('anggota'); ?>>Daftar Anggota</a></li>
                <li class="nav-user">
                    <span class="avatar" aria-hidden="true"><?php echo htmlspecialchars($__inisial); ?></span>
                    <span class="nav-user-name"><?php echo htmlspecialchars($__nama); ?></span>
                </li>
                <li>
                    <form method="post" action="<?php echo $base; ?>logout.php" class="form-logout">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>