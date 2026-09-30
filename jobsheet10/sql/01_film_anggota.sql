-- Jobsheet 8: skema awal database simpus_mini (PostgreSQL)
-- Jalankan setelah membuat database, misal:
--   createdb simpus_mini
--   psql -d simpus_mini -f sql/01_buku_anggota.sql

CREATE TABLE IF NOT EXISTS film (
    id SERIAL PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    sutradara VARCHAR(255) NOT NULL,
    tahun INTEGER NOT NULL,
    durasi INTEGER, -- Disimpan dalam satuan menit
    rating NUMERIC(3,1) NOT NULL DEFAULT 0.0, -- Menyimpan nilai desimal 0.0 hingga 10.0
    genre VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS anggota (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    no_anggota VARCHAR(50) NOT NULL UNIQUE,
    alamat VARCHAR(255),
    no_hp VARCHAR(30)
);