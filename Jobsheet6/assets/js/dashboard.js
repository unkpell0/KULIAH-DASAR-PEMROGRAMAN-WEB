// SIFILM-Mini — Jobsheet 6: ringkasan Beranda dihitung dari data/film.json dan data/anggota.json
// Dua request dijalankan paralel dengan Promise.all.

async function muatRingkasan() {
    const elFilm = document.getElementById("total-film");
    if (!elFilm) return;

    try {
        const [film, anggota] = await Promise.all([
            ambilJSON("data/film.json"),
            ambilJSON("data/anggota.json")
        ]);
        const dipinjam = film.filter(function (f) { return f.dipinjam; }).length;
        const persen = film.length === 0 ? 0 : Math.round((dipinjam / film.length) * 100);

        elFilm.textContent = film.length;
        document.getElementById("total-anggota").textContent = anggota.length;
        document.getElementById("total-dipinjam").textContent = dipinjam;

        const bar = document.getElementById("pinjam");   // elemen <progress>
        bar.max = film.length;
        bar.value = dipinjam;
        bar.textContent = persen + "%";
        document.getElementById("label-pinjam").textContent =
            "Film sedang dipinjam: " + dipinjam + " dari " + film.length;
    } catch (err) {
        document.getElementById("ringkasan-error").textContent = pesanGagal(err);
    }
}

document.addEventListener("DOMContentLoaded", muatRingkasan);
