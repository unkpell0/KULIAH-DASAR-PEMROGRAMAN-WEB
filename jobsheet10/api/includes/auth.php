<?php
/**
 * Auth + session. Di Vercel (serverless) file session PHP tidak bertahan
 * antar-request, jadi session disimpan di tabel `sessions` (Postgres).
 * Sisa kode tetap memakai $_SESSION seperti biasa.
 */
require_once __DIR__ . '/koneksi.php';

class PgSessionHandler implements SessionHandlerInterface, SessionUpdateTimestampHandlerInterface
{
    private PDO $pdo;
    private int $ttl;

    public function __construct(PDO $pdo, int $ttl)
    {
        $this->pdo = $pdo;
        $this->ttl = $ttl;
    }

    public function open(string $path, string $name): bool { return true; }
    public function close(): bool { return true; }

    public function read(string $id): string|false
    {
        $st = $this->pdo->prepare(
            "SELECT data FROM sessions WHERE id = :id
             AND updated_at > now() - make_interval(secs => {$this->ttl})"
        );
        $st->execute(['id' => $id]);
        $row = $st->fetchColumn();
        // data di-base64 supaya aman dari karakter null di serialisasi session
        return $row === false ? '' : (string) base64_decode($row);
    }

    public function write(string $id, string $data): bool
    {
        $st = $this->pdo->prepare(
            "INSERT INTO sessions (id, data, updated_at) VALUES (:id, :data, now())
             ON CONFLICT (id) DO UPDATE SET data = EXCLUDED.data, updated_at = now()"
        );
        return $st->execute(['id' => $id, 'data' => base64_encode($data)]);
    }

    public function destroy(string $id): bool
    {
        return $this->pdo->prepare("DELETE FROM sessions WHERE id = :id")->execute(['id' => $id]);
    }

    public function gc(int $max_lifetime): int|false
    {
        $st = $this->pdo->prepare(
            "DELETE FROM sessions WHERE updated_at < now() - make_interval(secs => {$this->ttl})"
        );
        $st->execute();
        return $st->rowCount();
    }

    // Dipakai session.use_strict_mode: tolak ID session yang tidak dikenal server
    public function validateId(string $id): bool
    {
        $st = $this->pdo->prepare(
            "SELECT 1 FROM sessions WHERE id = :id
             AND updated_at > now() - make_interval(secs => {$this->ttl})"
        );
        $st->execute(['id' => $id]);
        return (bool) $st->fetchColumn();
    }

    public function updateTimestamp(string $id, string $data): bool
    {
        return $this->pdo->prepare("UPDATE sessions SET updated_at = now() WHERE id = :id")
            ->execute(['id' => $id]);
    }
}

if (session_status() === PHP_SESSION_NONE) {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

    ini_set('session.use_strict_mode', '1');
    session_set_cookie_params([
        'lifetime' => 0,          // cookie hilang saat browser ditutup
        'path'     => '/',
        'secure'   => $https,     // true di Vercel (HTTPS), false di lokal (HTTP)
        'httponly' => true,       // tidak bisa dibaca JavaScript
        'samesite' => 'Lax',
    ]);
    session_set_save_handler(new PgSessionHandler($pdo, 7200), true); // sesi berlaku 2 jam
    session_start();
}

function require_login(string $base = ''): void
{
    if (empty($_SESSION['petugas'])) {
        header('Location: ' . $base . 'login.php');
        exit;
    }
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . csrf_token() . '">';
}

// Semua request POST wajib membawa token yang cocok dengan token di session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $t = $_POST['csrf'] ?? '';
    if (!is_string($t) || empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $t)) {
        http_response_code(419);
        exit('Sesi form tidak valid atau kedaluwarsa. Muat ulang halaman lalu coba lagi.');
    }
}