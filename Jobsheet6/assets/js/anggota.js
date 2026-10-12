// SIFILM-Mini — Jobsheet 6: memuat daftar anggota dari data/anggota.json dengan Fetch API

function buatBarisAnggota(anggota) {
    const tr = document.createElement("tr");
    tr.append(
        buatSel(anggota.no_anggota),
        buatSel(anggota.nama),
        buatSel(anggota.alamat),
        buatSel(anggota.no_hp),
        buatSelAksi()
    );
    return tr;
}

async function muatDaftarAnggota() {
    const tbody = document.querySelector("#tabel-data tbody");
    if (!tbody) return;

    tampilkanLoading(true);
    tbody.replaceChildren();

    try {
        const daftarAnggota = await ambilJSON("../data/anggota.json");
        tbody.replaceChildren(...daftarAnggota.map(buatBarisAnggota));
    } catch (err) {
        tampilkanGagal(tbody, 5, err);
    } finally {
        tampilkanLoading(false);
        sinkronkanTabel();
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarAnggota);
