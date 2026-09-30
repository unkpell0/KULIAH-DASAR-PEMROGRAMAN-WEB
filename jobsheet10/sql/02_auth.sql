-- Auth: akun petugas + penyimpanan session di Postgres
CREATE TABLE IF NOT EXISTS petugas (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(128) PRIMARY KEY,
    data TEXT NOT NULL,
    updated_at TIMESTAMPTZ NOT NULL DEFAULT now()
);

-- Buat akun pertama (hash dibuat dulu di terminal):
--   php -r "echo password_hash('PASSWORD_KAMU', PASSWORD_DEFAULT);"
-- INSERT INTO petugas (username, password_hash, nama)
-- VALUES ('admin', '<hash dari perintah di atas>', 'Admin');