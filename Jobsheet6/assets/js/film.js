// SIFILM-Mini — Jobsheet 6: memuat daftar film dari data/film.json dengan Fetch API
// Fungsi bantu (ambilJSON, buatSel, dst.) ada di app.js, jadi app.js harus dimuat lebih dulu.

function buatBarisFilm(film) {
    const tr = document.createElement("tr");
    tr.append(
        buatSel(film.judul),
        buatSel(film.sutradara),
        buatSel(film.tahun),
        buatSel(film.durasi + " Menit"),
        buatSel(Number(film.rating).toFixed(1) + " / 10"),
        buatSel(kapital(film.genre)),
        buatSelAksi()
    );
    return tr;
}

async function muatDaftarFilm() {
    const tbody = document.querySelector("#tabel-data tbody");
    if (!tbody) return;

    tampilkanLoading(true);
    tbody.replaceChildren();

    try {
        const daftarFilm = await ambilJSON("../data/film.json");
        tbody.replaceChildren(...daftarFilm.map(buatBarisFilm));
    } catch (err) {
        tampilkanGagal(tbody, 7, err);
    } finally {
        tampilkanLoading(false);
        sinkronkanTabel();
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarFilm);
