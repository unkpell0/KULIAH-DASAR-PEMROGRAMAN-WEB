// SIFILM-Mini — Jobsheet 6: Fetch API & JSON
// Materi: fetch(), async/await, response.json(), try/catch/finally, JSON.stringify.
// Berkas ini memuat kode Jobsheet 5 (DOM & event) + fungsi bantu fetch di bagian 0.
// Halaman daftar memakai film.js / anggota.js, Beranda memakai dashboard.js.
// PENTING: fetch() tidak jalan lewat file:// — buka lewat server lokal (Live Server / python -m http.server).

// ===== 0. Fungsi bantu fetch & pembuat elemen tabel =====
const JEDA_SIMULASI_MS = 600; // hanya untuk demo, agar indikator loading sempat terlihat

async function ambilJSON(url) {
    await new Promise(function (resolve) { setTimeout(resolve, JEDA_SIMULASI_MS); });
    const res = await fetch(url);
    if (!res.ok) {
        throw new Error("Gagal mengambil data (status " + res.status + ")");
    }
    return res.json();
}

function pesanGagal(err) {
    let pesan = "Gagal memuat data: " + err.message + ".";
    if (location.protocol === "file:") {
        pesan += " Buka halaman lewat server lokal (mis. ekstensi Live Server), bukan file://.";
    }
    return pesan;
}

function tampilkanLoading(aktif) {
    const el = document.getElementById("loading-indicator");
    if (el) el.classList.toggle("d-none", !aktif);
}

function tampilkanGagal(tbody, jumlahKolom, err) {
    const tr = document.createElement("tr");
    tr.className = "baris-error";
    const td = document.createElement("td");
    td.colSpan = jumlahKolom;
    td.className = "text-center text-danger py-4";
    td.textContent = pesanGagal(err);
    tr.appendChild(td);
    tbody.replaceChildren(tr);
    const info = document.getElementById("info-jumlah");
    if (info) info.textContent = "";
}

function buatSel(teks) {
    const td = document.createElement("td");
    td.textContent = teks; // textContent (bukan innerHTML) agar data JSON tidak dieksekusi sebagai HTML
    return td;
}

function buatSelAksi() {
    const td = document.createElement("td");
    td.className = "text-nowrap";
    const edit = document.createElement("button");
    edit.type = "button";
    edit.className = "btn btn-sm btn-outline-success btn-edit";
    edit.textContent = "Edit";
    const hapus = document.createElement("button");
    hapus.type = "button";
    hapus.className = "btn btn-sm btn-outline-danger btn-hapus";
    hapus.textContent = "Hapus";
    td.append(edit, " ", hapus);
    return td;
}

function kapital(teks) {
    return teks.charAt(0).toUpperCase() + teks.slice(1);
}

// ===== 1. Sinkronisasi tabel: baris kosong + info jumlah data =====
function ambilBarisData(tbody) {
    return tbody.querySelectorAll("tr:not(.baris-kosong):not(.baris-error)");
}

function sinkronkanTabel() {
    const tbody = document.querySelector("#tabel-data tbody");
    if (!tbody) return;
    if (tbody.querySelector(".baris-error")) return; // data gagal dimuat: biarkan pesan error tampil

    // Terapkan filter pencarian (jika ada kolom pencarian di halaman)
    const input = document.getElementById("search-input");
    const kata = input ? input.value.trim().toLowerCase() : "";
    const baris = ambilBarisData(tbody);
    let tampil = 0;

    baris.forEach(function (row) {
        // Cari hanya di kolom data, bukan di kolom Aksi (kolom terakhir)
        const teks = Array.from(row.querySelectorAll("td:not(:last-child)"))
            .map(function (td) { return td.textContent; })
            .join(" ")
            .toLowerCase();
        const cocok = teks.includes(kata);
        row.hidden = !cocok;
        if (cocok) tampil++;
    });

    // Tampilkan / hapus baris pesan "kosong"
    let kosong = tbody.querySelector(".baris-kosong");
    if (tampil === 0) {
        if (!kosong) {
            kosong = document.createElement("tr");
            kosong.className = "baris-kosong";
            const td = document.createElement("td");
            td.colSpan = document.querySelectorAll("#tabel-data thead th").length;
            td.className = "text-center text-secondary py-4";
            kosong.appendChild(td);
            tbody.appendChild(kosong);
        }
        kosong.firstElementChild.textContent = baris.length === 0 ? "Belum ada data." : "Data tidak ditemukan.";
    } else if (kosong) {
        kosong.remove();
    }

    const info = document.getElementById("info-jumlah");
    if (info) info.textContent = "Menampilkan " + tampil + " dari " + baris.length + " data";
}

// ===== 2. Konfirmasi hapus (event delegation: satu listener untuk semua tombol Hapus) =====
function initHapus() {
    const tbody = document.querySelector("#tabel-data tbody");
    if (!tbody) return;

    tbody.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-hapus");
        if (!btn) return;
        const row = btn.closest("tr");
        const nama = row.querySelector("td").textContent;
        if (confirm('Yakin ingin menghapus "' + nama + '"?')) {
            row.remove();
            sinkronkanTabel();
        }
    });
}

// ===== 3. Pencarian real-time =====
function initPencarian() {
    const input = document.getElementById("search-input");
    if (!input) return;
    input.addEventListener("input", sinkronkanTabel);
}

// ===== 4. Validasi form (client-side) =====
function validasiField(el, form) {
    const nilai = el.value.trim();
    const labelEl = form.querySelector('label[for="' + el.id + '"]');
    const nama = labelEl ? labelEl.textContent : "Field ini";

    if (el.required && nilai === "") return nama + " wajib diisi.";
    if (nilai === "") return ""; // field opsional yang dikosongkan

    if (el.type === "number") {
        const angka = Number(nilai);
        if (Number.isNaN(angka)) return "Masukkan angka yang valid.";
        const punyaMin = el.min !== "";
        const punyaMax = el.max !== "";
        if (punyaMin && punyaMax && (angka < Number(el.min) || angka > Number(el.max))) {
            return nama + " harus di antara " + el.min + " dan " + el.max + ".";
        }
        if (punyaMin && angka < Number(el.min)) return nama + " minimal " + el.min + ".";
        if (punyaMax && angka > Number(el.max)) return nama + " maksimal " + el.max + ".";
    }

    if (el.pattern && !new RegExp("^(?:" + el.pattern + ")$").test(nilai)) {
        return el.title || "Format " + nama + " tidak sesuai.";
    }
    return "";
}

function tampilkanError(el, pesan) {
    el.classList.add("is-invalid");
    el.classList.remove("is-valid");
    let fb = el.parentElement.querySelector(".invalid-feedback");
    if (!fb) {
        fb = document.createElement("div");
        fb.className = "invalid-feedback";
        el.insertAdjacentElement("afterend", fb);
    }
    fb.textContent = pesan;
}

function tandaiValid(el) {
    el.classList.remove("is-invalid");
    if (el.value.trim() !== "") el.classList.add("is-valid");
    else el.classList.remove("is-valid");
}

function bersihkanStatus(form) {
    form.querySelectorAll(".is-invalid, .is-valid").forEach(function (el) {
        el.classList.remove("is-invalid", "is-valid");
    });
    form.querySelectorAll(".invalid-feedback").forEach(function (fb) { fb.remove(); });
}

function hapusAlertSukses(form) {
    const lama = form.parentElement.querySelector(".alert-sukses");
    if (lama) lama.remove();
}

function tampilkanSukses(form, nama, data) {
    hapusAlertSukses(form);

    const alert = document.createElement("div");
    alert.className = "alert alert-success alert-dismissible fade show alert-sukses";
    alert.setAttribute("role", "alert");

    const teks = document.createElement("span");
    teks.append('Data "');
    const tebal = document.createElement("strong");
    tebal.textContent = nama;
    teks.append(tebal, '" berhasil divalidasi (simulasi — belum disimpan ke server).');

    const tutup = document.createElement("button");
    tutup.type = "button";
    tutup.className = "btn-close";
    tutup.setAttribute("data-bs-dismiss", "alert");
    tutup.setAttribute("aria-label", "Tutup");

    // Data form diubah menjadi JSON — format yang sama dengan isi data/*.json.
    // Di jobsheet berikutnya, string ini dikirim ke server: fetch(url, { method: "POST", body: json })
    const json = JSON.stringify(data, null, 2);
    console.log(json);
    const pre = document.createElement("pre");
    pre.className = "small mb-0 mt-2";
    pre.textContent = json;
    teks.append(pre);

    alert.append(teks, tutup);
    form.insertAdjacentElement("beforebegin", alert);
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.noValidate = true; // matikan bubble bawaan browser agar pesan Bootstrap yang tampil
    const fields = form.querySelectorAll("input, select");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // belum ada server: cegah pindah halaman
        let pertamaError = null;

        fields.forEach(function (el) {
            const pesan = validasiField(el, form);
            if (pesan) {
                tampilkanError(el, pesan);
                if (!pertamaError) pertamaError = el;
            } else {
                tandaiValid(el);
            }
        });

        if (pertamaError) {
            pertamaError.focus();
            return;
        }
        const utama = form.querySelector("input[type='text']");
        const nama = utama ? utama.value.trim() : "data";
        const data = Object.fromEntries(new FormData(form)); // ambil semua field sebagai objek
        form.reset();                 // reset dulu (sekaligus membersihkan status validasi)
        tampilkanSukses(form, nama, data);  // lalu tampilkan pesan sukses
    });

    // Validasi ulang saat user mengetik, tapi hanya untuk field yang sudah diberi status
    fields.forEach(function (el) {
        const ulang = function () {
            if (!el.classList.contains("is-invalid") && !el.classList.contains("is-valid")) return;
            const pesan = validasiField(el, form);
            if (pesan) tampilkanError(el, pesan);
            else tandaiValid(el);
        };
        el.addEventListener("input", ulang);
        el.addEventListener("change", ulang);
    });

    form.addEventListener("reset", function () {
        bersihkanStatus(form);
        hapusAlertSukses(form);
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initHapus();
    initPencarian();
    initValidasiForm();
    // sinkronkanTabel() dipanggil oleh film.js / anggota.js setelah data JSON selesai dimuat
});
