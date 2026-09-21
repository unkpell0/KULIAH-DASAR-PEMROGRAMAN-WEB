// Memuat data film ke dalam tabel
async function muatDaftarFilm() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    
    // Jika tidak ada tabel di halaman ini, hentikan fungsi
    if (!tbody) return;

    if (loading) loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // Simulasi waktu loading 600ms
        await new Promise((resolve) => setTimeout(resolve, 600));

        // Mengambil data JSON
        const res = await fetch("../data/film.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftarFilm = await res.json();

        // Menyusun baris tabel
        daftarFilm.forEach(function (film) {
            const tr = document.createElement("tr");
            tr.innerHTML = 
                "<td>" + film.judul + "</td>" +
                "<td>" + film.sutradara + "</td>" +
                "<td>" + film.tahun + "</td>" +
                "<td>" + film.durasi + " Menit</td>" +
                "<td>" + film.rating + " / 10</td>" +
                "<td><span style='text-transform: capitalize;'>" + film.genre + "</span></td>" +
                "<td>" +
                "<button type=\"button\">Edit</button> " +
                "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
                "</td>";
            tbody.appendChild(tr);
        });

        // Panggil ulang fungsi hapus dari app.js agar tombol "Hapus" yang baru dibuat bisa diklik
        if (typeof initHapusConfirm === "function") {
            initHapusConfirm();
        }

    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"7\" style=\"text-align:center; color:red;\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        if (loading) loading.style.display = "none";
    }
}

// Jalankan saat HTML selesai dimuat
document.addEventListener("DOMContentLoaded", muatDaftarFilm);