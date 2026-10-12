# Handbook SIFILM-Mini: Praktikum Pemrograman Web

*Panduan belajar HTML5, CSS, Responsive Design, Bootstrap, Wireframe, JavaScript DOM & Event, serta Fetch API & JSON, lengkap dengan penjelasan kode.*

## Bab 0. Pendahuluan

### 0.1 Tentang handbook ini

Handbook ini menemani enam jobsheet praktikum Pemrograman Web. Seluruh jobsheet memakai **satu studi kasus yang sama**, yaitu SIFILM-Mini, aplikasi sederhana untuk mendata film dan anggota. Dengan konten yang tetap, kamu bisa fokus melihat **apa yang berubah di setiap tahap**: dari HTML polos, lalu diberi gaya, dibuat responsif, dipercepat dengan Bootstrap, dirancang lewat wireframe, diberi perilaku dengan JavaScript, sampai mengambil data dari JSON.

Setiap bab disusun dengan pola yang sama: **tujuan**, **konsep**, **kode beserta penjelasannya**, **kesalahan umum**, dan **latihan**.

### 0.2 Gambaran proyek

SIFILM-Mini terdiri dari lima halaman:

| Halaman | File | Fungsi |
| --- | --- | --- |
| Beranda | `index.html` | Ringkasan: total film, total anggota, film yang sedang dipinjam |
| Daftar Film | `film/list.html` | Tabel film (judul, sutradara, tahun, durasi, rating, genre) |
| Tambah Film | `film/tambah.html` | Form input film baru |
| Daftar Anggota | `anggota/list.html` | Tabel anggota (no. anggota, nama, alamat, no. HP) |
| Tambah Anggota | `anggota/tambah.html` | Form input anggota baru |

Alur navigasinya: Beranda → Daftar Film ⇄ Tambah Film, dan Beranda → Daftar Anggota ⇄ Tambah Anggota.

### 0.3 Peta jobsheet

| Jobsheet | Materi | Yang ditambahkan dibanding sebelumnya |
| --- | --- | --- |
| 1 | HTML5 | Struktur semantik, tabel, form dengan validasi bawaan. Tanpa CSS dan JS. |
| 2 | CSS | File `style.css`: variabel, grid, flexbox, pseudo-element. Hanya layar lebar. |
| 3a | Responsive Design | `meta viewport`, media query mobile-first, pembungkus tabel. |
| 3b | Bootstrap | Halaman ditulis ulang dengan komponen dan class Bootstrap 5. |
| 4 | Wireframe | Hanya menambah halaman wireframe dan tautannya di sidebar. |
| 5 | JavaScript DOM & Event | `app.js`: hapus dengan konfirmasi, pencarian real-time, validasi form. |
| 6 | Fetch API & JSON | Data film dan anggota dimuat dari file JSON dengan `fetch`. |

Jobsheet 3 memiliki dua bagian. Jobsheet 4, 5, dan 6 melanjutkan versi Bootstrap (3b).

### 0.4 Struktur folder

```text
sifilm-mini-layout/
├── Jobsheet1/                 HTML5 saja
│   ├── index.html
│   ├── film/      (list.html, tambah.html)
│   └── anggota/   (list.html, tambah.html)
├── Jobsheet2/                 + assets/css/style.css
├── Jobsheet3/
│   ├── responsive-design/     + media query
│   └── bootstrap/             + assets/css/custom.css
├── Jobsheet4/                 + wireframe/index.html
├── Jobsheet5/                 + assets/js/app.js
└── Jobsheet6/                 + assets/js/*.js dan data/*.json
```

Perhatikan bahwa halaman di dalam subfolder (`film/`, `anggota/`) memakai awalan `../` untuk menunjuk ke file di folder induk, misalnya `../assets/css/style.css`. Kesalahan path adalah penyebab paling sering CSS atau JS "tidak jalan".

### 0.5 Persiapan dan cara menjalankan

1. Pasang **Visual Studio Code** dan ekstensi **Live Server**.
2. Jobsheet 1 sampai 5 bisa dibuka langsung dengan klik dua kali `index.html`. Bootstrap dan font dimuat dari internet (CDN), jadi perangkat harus online.
3. Jobsheet 6 **wajib lewat server lokal**. Klik kanan `index.html` lalu pilih *Open with Live Server*, atau jalankan `python -m http.server 8000` di folder `Jobsheet6` dan buka `http://localhost:8000`. Alasannya dijelaskan di Bab 7.
4. Biasakan membuka **DevTools** (tombol F12). Tab *Elements* untuk melihat DOM dan CSS, *Console* untuk pesan error JavaScript, *Network* untuk melihat request `fetch`.

## Bab 1. Jobsheet 1: HTML5

### 1.1 Tujuan

Setelah jobsheet ini kamu mampu:

- menyusun kerangka dokumen HTML5 yang valid;
- memakai elemen **semantik** (`header`, `nav`, `main`, `section`, `footer`);
- membuat tabel dan form yang benar secara struktur dan aksesibilitas;
- memakai validasi form bawaan HTML5 tanpa JavaScript.

### 1.2 Konsep: HTML adalah struktur, bukan tampilan

HTML menjelaskan **arti** sebuah konten: ini judul, ini navigasi, ini tabel. Tampilan diurus CSS. Karena itu Jobsheet 1 sengaja **tidak memiliki CSS**; halaman akan tampil dengan gaya bawaan browser, dan itu normal.

Elemen semantik membuat kode mudah dibaca manusia, dipahami mesin pencari, dan dapat dinavigasi pembaca layar (screen reader). Bandingkan `<div class="atas">` dengan `<header>`: yang kedua langsung memberi tahu perannya.

### 1.3 Kerangka dokumen

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIFILM-Mini | Beranda</title>
</head>
<body>
    ...
</body>
</html>
```

- `<!DOCTYPE html>` memberi tahu browser bahwa ini HTML5. Tanpanya browser masuk *quirks mode* dan menampilkan halaman dengan aturan lama.
- `lang="id"` menyatakan bahasa halaman. Dipakai pembaca layar untuk memilih logat pengucapan dan oleh browser untuk menawarkan terjemahan.
- `<meta charset="UTF-8">` mengatur penyandian karakter agar huruf seperti `&` dan tanda baca Indonesia tampil benar.
- `<title>` muncul di tab browser dan hasil pencarian. Setiap halaman diberi judul berbeda: `SIFILM-Mini | Daftar Film`, dan seterusnya.

### 1.4 Landmark semantik

```html
<body>
    <header>
      <p class="brand"><a href="index.html">SIFILM-Mini</a></p>
    </header>

    <nav aria-label="Navigasi utama"> ... </nav>

    <main> ... </main>

    <footer>
      <p>&copy; 2026 SIFILM-Mini &mdash; Jobsheet 1</p>
    </footer>
</body>
```

| Elemen | Peran |
| --- | --- |
| `header` | Kepala halaman; di sini berisi nama aplikasi |
| `nav` | Blok tautan navigasi utama |
| `main` | Isi utama halaman. **Hanya satu** per halaman |
| `section` | Kelompok konten bertema, sebaiknya punya judul (`h2`) |
| `footer` | Kaki halaman: hak cipta, keterangan |

`&copy;` dan `&mdash;` adalah *character entity*: cara menulis simbol © dan tanda pisah (—) tanpa risiko salah penyandian. `aria-label` memberi nama pada `nav` supaya pembaca layar dapat membedakannya bila ada lebih dari satu navigasi.

### 1.5 Navigasi: daftar bersarang

Menu adalah **daftar tautan**, jadi ditulis dengan `ul` dan `li`. Grup "Film" dan "Anggota" dibuat dengan daftar di dalam daftar.

```html
<nav aria-label="Navigasi utama">
  <ul>
    <li><a href="../index.html">Beranda</a></li>
    <li><span>Film</span>
      <ul>
        <li><a href="../film/list.html">Daftar Film</a></li>
        <li><a href="../film/tambah.html" aria-current="page">Tambah Film</a></li>
      </ul>
    </li>
    ...
  </ul>
</nav>
```

- Tautan memakai **path relatif**. Halaman di folder `film/` mengakses Beranda dengan `../index.html` (naik satu folder).
- `aria-current="page"` menandai tautan halaman yang sedang dibuka. Pembaca layar mengumumkannya, dan di Jobsheet 2 atribut ini juga kita pakai sebagai *selector* CSS untuk menyorot menu aktif. Satu atribut, dua manfaat.
- `<span>Film</span>` adalah label grup. Ia sengaja bukan tautan.

### 1.6 Beranda: `progress` dan `dl`

```html
<section>
  <h2>Ringkasan</h2>
  <p><label for="pinjam">Film sedang dipinjam: 3 dari 12</label></p>
  <progress id="pinjam" value="3" max="12">25%</progress>
  <dl>
    <div><dt>Total Film</dt><dd>12</dd></div>
    <div><dt>Total Anggota</dt><dd>8</dd></div>
    <div><dt>Sedang Dipinjam</dt><dd>3</dd></div>
  </dl>
</section>
```

- `<progress value="3" max="12">` adalah elemen HTML5 bawaan untuk menampilkan kemajuan. Teks di dalamnya (`25%`) hanya tampil di browser yang tidak mendukungnya.
- `<label for="pinjam">` terhubung ke elemen ber-`id="pinjam"`, sehingga progress punya nama yang dibaca pembaca layar.
- `dl` (*description list*) berisi pasangan istilah `dt` dan nilai `dd`. Cocok untuk data "nama: nilai" seperti ringkasan ini. Membungkus pasangan dengan `div` diperbolehkan dan memudahkan penataan CSS nanti.

### 1.7 Tabel data

```html
<table>
  <caption>Daftar film koleksi SIFILM-Mini</caption>
  <thead>
    <tr><th scope="col">Judul</th><th scope="col">Sutradara</th> ... <th scope="col">Aksi</th></tr>
  </thead>
  <tbody>
    <tr>
      <td>Laskar Pelangi</td>
      <td>Riri Riza</td>
      <td>2008</td>
      <td>125 Menit</td>
      <td>7.7 / 10</td>
      <td>Drama</td>
      <td>
        <button type="button" class="btn-edit">Edit</button>
        <button type="button" class="btn-hapus">Hapus</button>
      </td>
    </tr>
  </tbody>
</table>
```

- `caption` adalah judul tabel. Ia terikat langsung ke tabelnya, tidak seperti `h2` yang terpisah.
- `thead` memisahkan baris judul kolom dari isi (`tbody`). Pemisahan ini dipakai CSS dan JavaScript nanti, misalnya untuk hanya mencari di `tbody`.
- `th scope="col"` menyatakan sel itu judul **kolom**, sehingga pembaca layar dapat membacakan "Judul: Laskar Pelangi".
- Tombol memakai `type="button"`. Tanpa atribut ini, tombol di dalam form bertindak sebagai *submit*. Class `btn-edit` dan `btn-hapus` belum dipakai di Jobsheet 1, tetapi disiapkan sebagai *hook* untuk CSS (Jobsheet 2) dan JavaScript (Jobsheet 5).

### 1.8 Form dan validasi HTML5

```html
<form id="form-tambah" action="list.html" method="get">
  <fieldset>
    <legend>Detail film</legend>
    <p>
      <label for="judul">Judul</label>
      <input type="text" id="judul" name="judul"
             placeholder="Contoh: Laskar Pelangi" required>
    </p>
    <p>
      <label for="sutradara">Sutradara</label>
      <input type="text" id="sutradara" name="sutradara"
             list="daftar-sutradara" placeholder="Nama sutradara" required>
      <datalist id="daftar-sutradara">
        <option value="Riri Riza"><option value="Gareth Evans">
      </datalist>
    </p>
    <p>
      <label for="tahun">Tahun Rilis</label>
      <input type="number" id="tahun" name="tahun" min="1900" max="2026" required>
    </p>
    <p>
      <label for="genre">Genre</label>
      <select id="genre" name="genre" required>
        <option value="">Pilih Genre</option>
        <option value="drama">Drama</option>
      </select>
    </p>
  </fieldset>
  <p>
    <button type="reset">Reset</button>
    <button type="submit">Simpan</button>
  </p>
</form>
```

**Elemen pembentuk form**

- `form` membungkus semua kontrol. `action` adalah tujuan pengiriman dan `method="get"` menaruh data di URL (`list.html?judul=...`). Karena belum ada server, halaman cukup berpindah ke daftar.
- `fieldset` mengelompokkan kontrol, `legend` memberinya judul.
- `label for="judul"` terhubung ke `input id="judul"`. Mengklik label memfokuskan input, dan pembaca layar tahu fungsi kolom itu. **Nilai `for` harus sama persis dengan `id`.**
- `name` adalah nama field saat data dikirim. `id` untuk label dan CSS/JS. Keduanya berbeda fungsi.

**Atribut validasi (tanpa JavaScript)**

| Atribut | Efek |
| --- | --- |
| `required` | Field tidak boleh kosong |
| `type="number"` | Hanya angka; di HP muncul papan angka |
| `min` / `max` | Batas nilai angka (tahun 1900 sampai 2026) |
| `step="0.1"` | Kelipatan yang diizinkan (rating 7.7 valid) |
| `pattern` | Cocok dengan ekspresi reguler; di anggota: `A[0-9]{3}` = huruf A + 3 angka |
| `title` | Teks petunjuk yang tampil dalam pesan kesalahan `pattern` |
| `type="tel"` | Field telepon (papan nomor di HP) |
| `placeholder` | Contoh isian yang hilang saat mengetik |
| `list` + `datalist` | Saran isian sambil tetap boleh mengetik bebas |

Coba kirim form kosong: browser menolak dan menandai field pertama yang salah. Itu validasi HTML5. Kelemahannya, pesan tidak bisa kamu ubah; di Jobsheet 5 kita membuat validasi sendiri dengan JavaScript.

Tombol `type="reset"` mengosongkan form, dan `type="submit"` mengirimnya.

### 1.9 Kesalahan umum

| Gejala | Penyebab |
| --- | --- |
| Mengklik label tidak memfokuskan input | `for` pada label tidak sama dengan `id` input |
| Validasi `required` diabaikan | Kata `required` salah ketik (misalnya `requried`) |
| Tautan menu menuju halaman 404 | Path relatif salah; ingat awalan `../` di subfolder |
| Tombol "Hapus" mengirim form | Lupa `type="button"` |
| Karakter rusak (misalnya `â€”`) | Lupa `<meta charset="UTF-8">` atau file tidak disimpan sebagai UTF-8 |

### 1.10 Latihan

1. Tambahkan field **Sinopsis** (`textarea`) pada form film, lengkap dengan `label` dan batas `maxlength`.
2. Tambahkan kolom **Prodi** pada form anggota memakai `select`, lalu tambahkan kolomnya di tabel.
3. Validasikan halaman dengan validator W3C (validator.w3.org) dan perbaiki setiap peringatannya.

## Bab 2. Jobsheet 2: CSS

### 2.1 Tujuan

Setelah jobsheet ini kamu mampu menyambungkan CSS ke HTML, memakai variabel CSS, menulis berbagai jenis selector, dan membuat layout dengan CSS Grid dan Flexbox. Markup HTML-nya **tidak berubah** dari Jobsheet 1; yang ditambah hanya satu baris `<link>` dan file `assets/css/style.css`.

### 2.2 Menyambungkan CSS

```html
<link rel="stylesheet" href="../assets/css/style.css">
```

Baris ini ditaruh di dalam `<head>`. Untuk halaman di subfolder, path diawali `../` supaya naik satu folder lebih dulu. Font Hanken Grotesk dan Zilla Slab dimuat dari Google Fonts lewat `<link>` serupa; setiap font punya *fallback* (misalnya `system-ui`) bila internet mati.

### 2.3 Variabel CSS (custom properties)

```css
:root {
  --lamp: #173a31;      /* hijau sidebar */
  --brass: #c79a3e;     /* kuningan: tombol utama & penanda aktif */
  --ink: #1d2a27;
  --paper: #e8ecea;
  --sidebar-w: 248px;
  --font-body: "Hanken Grotesk", "Segoe UI", system-ui, sans-serif;
}

body { font-family: var(--font-body); color: var(--ink); background: var(--paper); }
```

`:root` adalah elemen paling atas dokumen, sehingga variabel di dalamnya berlaku di seluruh halaman. Nilai dipanggil dengan `var(--nama)`. Keuntungannya: mengganti warna tema cukup di satu tempat. Coba ubah `--brass` menjadi `#2f6fbf` dan lihat semua tombol dan penanda aktif ikut berubah.

### 2.4 Reset sederhana

```css
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
```

- `*` memilih semua elemen. `::before` dan `::after` ikut dipilih supaya pseudo-element juga terkena.
- `box-sizing: border-box` membuat `width` sudah **termasuk** padding dan border. Tanpanya, elemen selebar 100% dengan padding akan melebihi layar.
- `margin` dan `padding` dinolkan agar semua jarak berasal dari aturan yang kita tulis sendiri, bukan bawaan browser.

### 2.5 Selector yang dipakai di proyek

| Jenis | Contoh di proyek | Arti |
| --- | --- | --- |
| Elemen | `table`, `nav`, `footer` | Semua elemen bertag itu |
| Class | `.btn-hapus`, `.page-lede` | Elemen ber-`class` itu |
| Turunan | `nav a` | Semua `a` di dalam `nav` (di kedalaman berapa pun) |
| Anak langsung | `main > h1` | Hanya `h1` yang langsung di bawah `main` |
| Atribut | `nav a[aria-current="page"]` | `a` yang punya atribut itu bernilai `page` |
| Pseudo-class | `tbody tr:hover`, `input:focus-visible`, `td:first-child` | Elemen dalam keadaan/posisi tertentu |
| Pseudo-element | `.brand a::before`, `dl div::after` | Bagian virtual yang dibuat CSS |
| Gabungan | `.btn-edit, .btn-hapus` | Koma = aturan berlaku untuk keduanya |

### 2.6 Layout halaman dengan CSS Grid

Sidebar dan konten disusun oleh `body` yang dijadikan grid. HTML-nya hanya berisi `header`, `nav`, `main`, `footer` berurutan, tanpa pembungkus tambahan.

```css
body {
  display: grid;
  grid-template-columns: var(--sidebar-w) minmax(0, 1fr);
  grid-template-rows: auto 1fr auto;
  grid-template-areas:
    "brand main"
    "nav   main"
    "nav   foot";
  min-height: 100vh;
}
header { grid-area: brand; }
nav    { grid-area: nav; }
main   { grid-area: main; }
footer { grid-area: foot; }
```

Baca `grid-template-areas` seperti denah:

```text
+---------+---------------------+
| brand   |                     |
+---------+        main         |
|         |                     |
|  nav    +---------------------+
|         |        foot         |
+---------+---------------------+
```

- Kolom pertama selebar `248px` (variabel `--sidebar-w`), kolom kedua `minmax(0, 1fr)`: ambil sisa ruang, tetapi boleh menyusut sampai nol. Bagian `0` penting agar tabel lebar tidak mendorong kolom keluar layar.
- Baris kedua `1fr` menyerap tinggi sisa sehingga `footer` selalu di dasar, walau isi halaman pendek (didukung `min-height: 100vh`).
- `main` menempati dua baris sekaligus, karena namanya muncul di baris 1 dan 2.

### 2.7 Logo dengan pseudo-element

```css
.brand a::before {
  content: "S";
  display: inline-grid;
  place-items: center;
  width: 1.9rem;
  height: 2.3rem;
  margin-right: 0.65rem;
  background: var(--brass);
  color: var(--lamp);
  border-radius: 2px 5px 5px 2px;
  box-shadow: inset 4px 0 0 rgba(0, 0, 0, 0.18);
}
```

`::before` menyisipkan elemen virtual **sebelum** isi tautan, dan `content` wajib ada agar ia muncul. Hasilnya kotak kuningan berhuruf "S" mirip punggung buku, tanpa file gambar dan tanpa mengubah HTML. `border-radius` dengan empat nilai mengatur sudut berurutan (kiri-atas, kanan-atas, kanan-bawah, kiri-bawah); `inset` pada `box-shadow` membuat garis gelap di tepi kiri sebagai efek punggung.

### 2.8 Navigasi dan penanda halaman aktif

```css
nav ul { list-style: none; }
nav a {
  display: block;
  padding: 0.6rem 1.5rem;
  color: #d8e4dd;
  text-decoration: none;
  border-left: 4px solid transparent;
}
nav a:hover { background: var(--lamp-soft); color: #fff; }
nav a[aria-current="page"] {
  background: var(--lamp-soft);
  border-left-color: var(--brass);
  color: #fff;
  font-weight: 600;
}
```

- `display: block` membuat seluruh baris menu bisa diklik, bukan hanya teksnya.
- Semua tautan diberi `border-left` **transparan** sejak awal. Saat aktif, hanya warnanya yang berganti. Jika border baru ditambahkan saat aktif, teks akan bergeser 4px.
- Selector atribut `[aria-current="page"]` memanfaatkan atribut yang sudah kita tulis di Bab 1. Tidak perlu class `active` terpisah.

### 2.9 Konten dan "kartu"

```css
main { grid-area: main; width: 100%; max-width: 1120px; padding: 2.5rem 3rem; }

section {
  background: var(--sheet);
  border: 1px solid var(--line);
  border-radius: 3px;
  padding: 1.75rem;
  margin-bottom: 1.75rem;
}
```

`max-width` membatasi lebar teks agar nyaman dibaca di layar sangat lebar, sedangkan `width: 100%` membuatnya mengisi ruang di layar yang lebih sempit. Satuan `rem` relatif terhadap ukuran font dasar, sehingga jarak ikut menyesuaikan bila pengguna memperbesar teks di browser.

### 2.10 Daftar isi bertitik pada ringkasan

```css
dl div { display: flex; align-items: baseline; gap: 0.5rem; padding: 0.35rem 0; }
dl div::after {
  content: "";
  order: 1;
  flex: 1;
  border-bottom: 2px dotted #9aa8a2;
  transform: translateY(-4px);
}
dt { flex: none; }
dd { order: 2; font-size: 1.6rem; font-variant-numeric: tabular-nums; }
```

Ini trik klasik "titik-titik penuntun" seperti pada daftar isi buku. Tiga anak flex disusun: `dt` (teks), titik-titik (`::after`), `dd` (angka). Properti `order` menukar urutan visual: titik (`order: 1`) berada di antara `dt` (bawaan 0) dan `dd` (2). `flex: 1` membuat garis titik menyerap seluruh sisa lebar. `tabular-nums` membuat semua angka sama lebar sehingga rapi sejajar.

### 2.11 Tabel dan tombol

```css
table { width: 100%; border-collapse: collapse; }
th, td { text-align: left; padding: 0.8rem 0.75rem; border-bottom: 1px solid var(--line); }
th { border-bottom: 2px solid var(--ink); }
tbody tr:hover { background: #f4efe1; }

.btn-edit, .btn-hapus {
  background: transparent;
  border: 1.5px solid currentColor;
  border-radius: 3px;
  cursor: pointer;
}
.btn-edit  { color: var(--lamp-soft); }
.btn-hapus { color: var(--danger); }
.btn-hapus:hover { background: var(--danger); color: #fff; }
```

`border-collapse: collapse` menyatukan garis antar sel menjadi satu garis. Kuncinya ada pada `currentColor`: warna border mengikuti warna teks, jadi cukup mengatur `color` di `.btn-edit` atau `.btn-hapus` dan border ikut berubah. Saat hover, latar diisi warna yang sama dan teks menjadi putih.

### 2.12 Form bergaya kartu katalog

```css
fieldset { border: none; border-top: 3px solid var(--rule-red); }
fieldset p {
  display: grid;
  grid-template-columns: 11rem 1fr;   /* label | input */
  align-items: center;
  column-gap: 1.25rem;
  border-bottom: 1px solid var(--rule-blue);
}
input, select {
  width: 100%;
  border: none;
  border-bottom: 2px solid #aebbb5;
  background: transparent;
  font: inherit;
}
input:focus-visible, select:focus-visible { outline: none; box-shadow: 0 2px 0 var(--brass); }
input:user-invalid, select:user-invalid { border-bottom-color: var(--danger); }
```

- Setiap `p` menjadi grid dua kolom, jadi semua label dan input sejajar rapi tanpa tabel.
- `font: inherit` membuat input memakai font halaman. Tanpanya browser memakai font sistem yang berbeda.
- `:focus-visible` menandai field yang sedang aktif lewat keyboard, dan `outline: none` aman dipakai **hanya karena** kita menggantinya dengan indikator lain (garis kuningan).
- `:user-invalid` menandai field merah **setelah pengguna berinteraksi**. Berbeda dengan `:invalid` yang langsung merah saat halaman dibuka karena semua field `required` masih kosong.

### 2.13 Cascade dan specificity

Bila dua aturan mengenai elemen yang sama, yang menang ditentukan **specificity** (kekhususan), lalu **urutan** kemunculan. Urutan kasar dari lemah ke kuat: selector elemen < class/atribut/pseudo-class < `id` < `style` inline < `!important`. Contoh: `.btn-hapus` (class) mengalahkan `button` (elemen) walaupun `button` ditulis belakangan. Bila specificity sama, aturan yang **terakhir** ditulis menang. Gunakan tab *Styles* di DevTools; aturan yang dicoret adalah yang dikalahkan.

### 2.14 Kesalahan umum

| Gejala | Penyebab |
| --- | --- |
| Halaman tetap polos | Path `href` stylesheet salah atau lupa `../` di subfolder |
| Elemen melebar keluar layar | Tidak memakai `box-sizing: border-box` |
| Pseudo-element tidak muncul | Lupa properti `content` |
| Perubahan tidak terlihat | Cache browser; tekan Ctrl+F5 |
| Sidebar menyempit saat tabel lebar | Kolom grid `1fr` tanpa `minmax(0, 1fr)` |

### 2.15 Latihan

1. Ganti tema warna menjadi biru hanya dengan mengubah variabel di `:root`.
2. Buat baris tabel berselang-seling (zebra) memakai `tbody tr:nth-child(even)`.
3. Tambahkan efek `transition` halus pada hover menu sidebar.
4. Perbesar browser hingga 150% lalu persempit jendela. Catat apa yang rusak; ini bahan untuk Jobsheet 3.

## Bab 3. Jobsheet 3: Responsive Design dan Bootstrap

Jobsheet 3 punya dua bagian yang menyelesaikan masalah yang sama dengan cara berbeda. **Bagian A** menyelesaikannya dengan CSS buatan sendiri, **Bagian B** dengan framework Bootstrap. Mengerjakan keduanya memperlihatkan apa yang sebenarnya dilakukan sebuah framework.

### Bagian A. Responsive Design dengan CSS

#### 3A.1 Tujuan

Membuat satu halaman yang nyaman dipakai di HP, tablet, dan desktop, memakai `meta viewport`, pendekatan *mobile-first*, dan media query.

#### 3A.2 Masalahnya

Buka Jobsheet 2 di HP (atau DevTools mode perangkat). Sidebar 248px memakan separuh layar, tabel melebar keluar, dan form sempit. Penyebabnya dua: browser HP tanpa petunjuk akan berpura-pura memiliki layar sekitar 980px lalu memperkecil hasilnya, dan CSS Jobsheet 2 memang hanya dirancang untuk layar lebar.

#### 3A.3 Meta viewport

```html
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

Baris ini wajib di setiap `<head>`. `width=device-width` memerintahkan browser memakai lebar layar sebenarnya, dan `initial-scale=1.0` mencegah pembesaran awal. Tanpa baris ini, media query tidak akan bereaksi dengan benar di HP. Sengaja baris ini **baru ditambahkan di Jobsheet 3**, supaya kamu bisa membandingkan sebelum dan sesudahnya.

#### 3A.4 Mobile-first dan breakpoint

Pendekatan *mobile-first*: aturan dasar ditulis untuk layar paling kecil, lalu **diperluas** dengan `@media (min-width: ...)` untuk layar yang lebih besar. Hasilnya CSS lebih ringkas, karena HP tidak perlu "membatalkan" aturan desktop.

| Rentang | Perangkat | Perubahan |
| --- | --- | --- |
| di bawah 600px | HP | Menu menjadi baris tombol di atas, form 1 kolom |
| 600px ke atas | Tablet | Form 2 kolom (label di kiri), padding lebih lega |
| 900px ke atas | Desktop | Menu menjadi sidebar di kiri (CSS Grid) |

Breakpoint ditentukan oleh **kapan tampilan mulai rusak**, bukan oleh model perangkat tertentu. Persempit jendela perlahan dan catat lebar saat tata letak mulai terasa sesak.

#### 3A.5 Navigasi: baris tombol di HP, sidebar di desktop

Markup HTML-nya sama persis. Yang berubah hanya CSS. Aturan dasar (HP):

```css
nav > ul { display: flex; flex-wrap: wrap; align-items: center; gap: 0.25rem 0.75rem; }
nav > ul > li { display: flex; flex-wrap: wrap; align-items: center; }
nav li ul { display: flex; flex-wrap: wrap; }
nav a { padding: 0.45rem 0.7rem; border-bottom: 3px solid transparent; }
nav a[aria-current="page"] { border-bottom-color: var(--brass); }
```

`display: flex` dengan `flex-wrap: wrap` membuat tautan berjajar menyamping dan otomatis turun ke baris berikutnya bila tidak muat. Penanda halaman aktif berupa garis **bawah**. Pada layar 900px ke atas, aturannya diubah:

```css
@media (min-width: 900px) {
  body { display: grid; grid-template-columns: var(--sidebar-w) minmax(0, 1fr); /* ... */ }
  nav > ul, nav > ul > li, nav li ul { display: block; }
  nav a { padding: 0.6rem 1.5rem; border-bottom: 0; border-left: 4px solid transparent; }
}
```

Daftar kembali menjadi `block` (bertumpuk ke bawah), garis penanda pindah ke sisi **kiri**, dan `body` menjadi grid dua kolom seperti di Jobsheet 2. Karena `display: grid` pada `body` hanya ada di dalam media query, di HP `body` tetap berupa tumpukan vertikal biasa: header, menu, isi, footer.

#### 3A.6 Tabel yang bisa digeser

```html
<div class="table-responsive">
  <table> ... </table>
</div>
```

```css
.table-responsive { overflow-x: auto; }
```

Tabel film punya tujuh kolom, mustahil muat di layar 360px tanpa merusak teks. Solusinya bukan mengecilkan tabel, melainkan membungkusnya: wadah yang memiliki `overflow-x: auto` menggulir **di dalam dirinya sendiri**, sehingga halaman tidak ikut bergeser ke samping.

#### 3A.7 Form 1 kolom lalu 2 kolom

```css
fieldset p { display: grid; grid-template-columns: 1fr; row-gap: 0.15rem; }

@media (min-width: 600px) {
  fieldset p { grid-template-columns: 11rem 1fr; align-items: center; column-gap: 1.25rem; }
}
```

Di HP, label berada di atas input (satu kolom penuh) karena itu lebih mudah dijangkau jempol. Mulai 600px, label dan input berdampingan.

#### 3A.8 Detail kecil yang penting

- `img, video { max-width: 100%; height: auto; }` membuat media tidak pernah melebihi wadahnya.
- Ukuran font input minimal 16px (`font: inherit`) agar iOS tidak memperbesar halaman otomatis saat input difokuskan.
- Tombol diberi `padding` lebih besar (0.7rem 1.5rem) agar area sentuh cukup besar untuk jari.

#### 3A.9 Cara menguji

1. Buka DevTools lalu aktifkan *Toggle device toolbar* (Ctrl+Shift+M).
2. Pilih perangkat (misalnya iPhone SE) dan juga ubah lebar secara manual dengan menggeser pegangan.
3. Periksa tiga hal di setiap lebar: tidak ada scroll horizontal pada halaman, teks terbaca tanpa dicubit, dan semua tombol mudah ditekan.

#### 3A.10 Kesalahan umum dan latihan

| Gejala | Penyebab |
| --- | --- |
| Tampilan di HP sama seperti desktop yang diperkecil | Lupa `meta viewport` |
| Seluruh halaman bisa digeser ke samping | Ada elemen lebih lebar dari layar, biasanya tabel tanpa pembungkus |
| Aturan media query tidak berlaku | Ditulis **sebelum** aturan dasar yang ingin ditimpa; aturan belakangan menang |
| Aturan tablet ikut tampil di HP | Memakai `max-width` dan `min-width` bercampur dalam satu pendekatan |

**Latihan:** (1) Tambahkan breakpoint 1200px yang melebarkan sidebar menjadi 280px. (2) Ubah tabel anggota menjadi tampilan kartu pada layar di bawah 600px. (3) Tambahkan `@media (prefers-color-scheme: dark)` sederhana untuk warna latar.

### Bagian B. Bootstrap 5

#### 3B.1 Tujuan

Memakai Bootstrap untuk membangun tata letak responsif dan komponen UI memakai class siap pakai, serta menyesuaikan temanya dengan CSS kustom.

#### 3B.2 Apa itu Bootstrap

Bootstrap adalah *framework* CSS (dan sedikit JavaScript) berisi sistem grid, komponen (navbar, card, tabel, form, tombol), dan kelas utilitas. Alih-alih menulis aturan CSS, kamu **menempelkan class pada HTML**. Pada proyek ini ia dimuat dari CDN:

```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="assets/css/custom.css" rel="stylesheet">   <!-- harus PALING AKHIR -->
...
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
```

`custom.css` dimuat **setelah** Bootstrap supaya aturan kita menang bila specificity-nya sama. Skrip `bootstrap.bundle` diperlukan untuk komponen interaktif, dalam proyek ini untuk membuka dan menutup sidebar.

#### 3B.3 Class utilitas yang dipakai

| Class | Arti |
| --- | --- |
| `d-flex`, `d-lg-flex` | `display: flex`; versi `lg` hanya berlaku mulai 992px |
| `d-lg-none` | Sembunyikan mulai ukuran `lg` ke atas |
| `flex-column`, `flex-grow-1` | Arah kolom; elemen menyerap sisa ruang |
| `gap-2`, `mb-3`, `mt-4`, `p-3` | Jarak: `m` margin, `p` padding, `b/t/e/s` sisi, angka = skala 0 sampai 5 |
| `p-3 p-md-4 p-xl-5` | Padding yang membesar seiring lebar layar |
| `text-secondary`, `small`, `fw-semibold` | Warna teks, ukuran kecil, tebal sedang |
| `text-nowrap` | Teks tidak dipatahkan ke baris baru |
| `min-vh-100` | Tinggi minimal 100% tinggi layar |

Breakpoint Bootstrap: `sm` 576px, `md` 768px, `lg` 992px, `xl` 1200px, `xxl` 1400px. Awalan seperti `md-` berarti "mulai ukuran itu ke atas", sehingga Bootstrap juga mobile-first.

#### 3B.4 Anatomi layout halaman

```html
<header class="navbar sticky-top d-lg-none bg-lamp" data-bs-theme="dark">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#sidebar" aria-controls="sidebar" aria-label="Buka menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <span class="navbar-brand font-head mb-0 me-auto ms-3">SIFILM-Mini</span>
  </div>
</header>

<div class="d-lg-flex min-vh-100">
  <aside id="sidebar" class="sidebar offcanvas-lg offcanvas-start" tabindex="-1"
         aria-labelledby="sidebar-title" data-bs-theme="dark">
    <div class="offcanvas-header"> ... tombol btn-close ... </div>
    <div class="offcanvas-body d-flex flex-column flex-grow-1 p-0">
      <nav aria-label="Navigasi utama"> ... </nav>
    </div>
  </aside>

  <div class="content-wrap d-flex flex-column flex-grow-1 min-w-0">
    <main class="flex-grow-1 p-3 p-md-4 p-xl-5"> ... </main>
    <footer class="px-3 px-md-4 px-xl-5 py-3 text-secondary small"> ... </footer>
  </div>
</div>
```

Cara kerjanya:

- **Top bar** (`header`) memiliki `d-lg-none`, jadi hanya tampil di bawah 992px. Tombolnya membawa dua atribut data: `data-bs-toggle="offcanvas"` (jenis aksi) dan `data-bs-target="#sidebar"` (elemen yang dibuka, dicocokkan dengan `id`).
- **Sidebar** memakai `offcanvas-lg`. Di bawah `lg`, ia menjadi panel geser dari kiri (`offcanvas-start`) yang disertai latar gelap. Mulai `lg`, ia otomatis menjadi blok biasa. Satu markup melayani dua perilaku, yang di Bagian A harus kita tulis dengan media query sendiri.
- Wadah luar `d-lg-flex` menjajarkan sidebar dan konten **hanya di layar lg ke atas**; di bawahnya keduanya bertumpuk.
- `min-w-0` (kelas kustom: `min-width: 0`) mencegah wadah flex melebar mengikuti tabel yang lebar, sama seperti `minmax(0, 1fr)` pada grid Jobsheet 2.

#### 3B.5 Grid system

Grid Bootstrap memakai 12 kolom. `row` adalah baris, `col-*` adalah kolom.

```html
<!-- Ringkasan Beranda: 1 kolom di HP, 3 kolom mulai md -->
<div class="row row-cols-1 row-cols-md-3 g-3 mb-4">
  <div class="col"> ...kartu... </div>
  <div class="col"> ...kartu... </div>
  <div class="col"> ...kartu... </div>
</div>

<!-- Satu baris form: label 3 kolom, input 9 kolom, mulai sm -->
<div class="row mb-3">
  <label for="judul" class="col-sm-3 col-form-label fw-semibold">Judul</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="judul" name="judul" required>
  </div>
</div>
```

`row-cols-1 row-cols-md-3` berarti "satu kartu per baris, lalu tiga per baris mulai md". `g-3` memberi jarak antar kolom. Di bawah `sm`, `col-sm-3` dan `col-sm-9` otomatis menjadi lebar penuh, sehingga label berada di atas input, perilaku yang sama dengan form Bagian A.

#### 3B.6 Komponen yang dipakai

```html
<!-- Card -->
<div class="card h-100"><div class="card-body">
  <div class="text-secondary small">Total Film</div>
  <div class="display-6 fw-semibold font-head" id="total-film">12</div>
</div></div>

<!-- Progress -->
<div class="progress" role="progressbar" aria-label="Film sedang dipinjam"
     aria-valuenow="3" aria-valuemin="0" aria-valuemax="12" style="height: 1.5rem">
  <div class="progress-bar bg-brass" id="bar-dipinjam" style="width: 25%">3 dari 12</div>
</div>

<!-- Tabel -->
<div class="table-responsive">
  <table class="table table-hover align-middle mb-0" id="tabel-data"> ... </table>
</div>

<!-- Tombol aksi di sel tabel -->
<button type="button" class="btn btn-sm btn-outline-danger btn-hapus">Hapus</button>
```

- `card h-100` membuat tiga kartu sama tinggi.
- Pada progress, atribut `aria-valuenow` dan kawan-kawan menjelaskan nilainya untuk pembaca layar; lebar visualnya diatur `style="width: 25%"` (3 dibagi 12).
- `table-hover` menyorot baris saat kursor di atasnya, `align-middle` meratakan isi sel secara vertikal, `mb-0` menghapus margin bawah bawaan.
- Class kita sendiri (`btn-hapus`, `bg-brass`) berdampingan dengan class Bootstrap. `btn-hapus` tidak punya gaya Bootstrap, ia ada untuk dicari JavaScript di Jobsheet 5.

#### 3B.7 Menyesuaikan tema: custom.css

Bootstrap 5.3 dikendalikan oleh **CSS variables**, jadi tema diubah tanpa melawan kodenya.

```css
:root {
  --bs-body-font-family: "Hanken Grotesk", "Segoe UI", system-ui, sans-serif;
  --bs-body-bg: var(--paper);
  --bs-border-radius: 3px;
}

/* Tombol warna kuningan: cukup isi variabel milik .btn */
.btn-brass {
  --bs-btn-color: var(--lamp);
  --bs-btn-bg: var(--brass);
  --bs-btn-border-color: var(--brass);
  --bs-btn-hover-bg: #d6aa4f;
  --bs-btn-hover-border-color: #d6aa4f;
}

/* Card, tabel, dan input memakai warna latar body; di tema ini dibuat putih */
.card { --bs-card-bg: #fff; }
.table { --bs-table-bg: transparent; }
```

Bagian terakhir adalah contoh jebakan nyata. Karena kita mengubah warna latar body menjadi abu-hijau, semua card, tabel, dan input ikut abu-hijau, sebab Bootstrap mengisinya dengan `var(--bs-body-bg)`. Solusinya menimpa variabel komponen yang bersangkutan. Prinsipnya: **inspeksi elemen di DevTools, temukan variabel `--bs-...` yang dipakai, lalu timpa.**

Sidebar juga mendapat penyesuaian:

```css
.sidebar {
  --bs-offcanvas-width: var(--sidebar-w);
  --bs-offcanvas-bg: var(--lamp);
}
@media (min-width: 992px) {
  .sidebar { background-color: var(--lamp) !important; flex: 0 0 var(--sidebar-w); }
}
```

Di layar `lg` ke atas Bootstrap memaksa latar offcanvas menjadi transparan dengan `!important`, jadi satu-satunya cara menimpanya adalah `!important` juga. `flex: 0 0 248px` mengunci lebar sidebar dalam wadah flex.

#### 3B.8 CSS manual vs Bootstrap

| Kebutuhan | Bagian A (CSS sendiri) | Bagian B (Bootstrap) |
| --- | --- | --- |
| Sidebar menjadi menu di HP | Media query dan aturan flex/grid sendiri | `offcanvas-lg` + dua atribut `data-bs-*` |
| Tabel bisa digeser | `.table-responsive { overflow-x: auto }` | Class `table-responsive` (sudah ada) |
| Form 1 atau 2 kolom | Grid + media query | `row` + `col-sm-3` / `col-sm-9` |
| Tombol, kartu, progress | Menulis CSS satu per satu | Class `btn`, `card`, `progress` |
| Kontrol penuh atas tampilan | Penuh | Terbatas pada variabel dan penimpaan |

Bootstrap menghemat banyak kode, dengan harga ukuran file lebih besar dan tampilan yang mirip situs lain bila tidak disesuaikan.

#### 3B.9 Kesalahan umum dan latihan

| Gejala | Penyebab |
| --- | --- |
| Sidebar tidak mau terbuka di HP | Skrip `bootstrap.bundle.min.js` tidak dimuat, atau `data-bs-target` tidak cocok dengan `id` |
| Kolom form tidak berdampingan | Lupa membungkus kolom dalam `row` |
| Gaya kustom tidak berlaku | `custom.css` dimuat sebelum Bootstrap |
| Ikon tidak tampil | CDN Bootstrap Icons tidak termuat (periksa koneksi internet) |

**Latihan:** (1) Ubah `--brass` menjadi warna lain dan amati dampaknya. (2) Tambahkan badge jumlah film pada menu "Daftar Film" memakai class `badge`. (3) Ubah tiga kartu ringkasan menjadi `row-cols-2` di HP.

## Bab 4. Jobsheet 4: Wireframe

### 4.1 Tujuan

Memahami fungsi wireframe, membuat wireframe low-fidelity untuk setiap halaman, dan menghubungkannya dengan implementasi. Jobsheet ini **tidak mengubah tampilan aplikasi**; yang ditambahkan hanyalah halaman `wireframe/index.html` dan tautan "Wireframe" di sidebar.

### 4.2 Apa dan mengapa

Wireframe adalah sketsa tata letak halaman yang menunjukkan **apa isi halaman dan di mana letaknya**, tanpa warna, gambar, atau font final. Ia dibuat sebelum (atau bersamaan dengan) coding karena mengubah garis di kertas jauh lebih murah daripada mengubah HTML dan CSS yang sudah jadi.

|  | Low-fidelity | High-fidelity |
| --- | --- | --- |
| Tampilan | Abu-abu, kotak, teks seadanya | Warna, font, ikon, gambar final |
| Alat | Kertas, papan tulis, Figma sederhana | Figma / Adobe XD |
| Tujuan | Menyepakati struktur dan alur | Menyepakati tampilan akhir |
| Waktu | Menit | Jam sampai hari |

Halaman wireframe SIFILM-Mini adalah low-fidelity.

### 4.3 Langkah membuat wireframe

1. **Daftar halaman.** Untuk SIFILM-Mini ada lima, ditambah variasi tampilan mobile.
2. **Tentukan isi tiap halaman.** Daftar Film membutuhkan: judul, tombol tambah, pencarian, tabel, tombol edit dan hapus.
3. **Urutkan menurut prioritas.** Yang paling penting ditaruh paling mudah dilihat.
4. **Gambar tata letak.** Mulai dari kerangka besar (sidebar, konten) lalu isi bagian dalamnya.
5. **Beri anotasi.** Angka pada gambar merujuk ke penjelasan fungsi tiap bagian.
6. **Gambar alur antarhalaman.** Dari halaman mana pengguna menuju halaman mana.
7. **Tinjau dan revisi** sebelum menulis kode.

### 4.4 Wireframe Daftar Film

Desktop (angka = nomor catatan):

```text
+---------------+----------------------------------------------+
| (1)           |  (2) Daftar Film              [Tambah film]  |
| SIFILM-Mini   |  +----------------------------------------+  |
|               |  | (3) [ Cari judul film...      ]        |  |
| Beranda       |  |                                        |  |
| Film          |  | (4) Judul | Sutradara | ... | Aksi (5) |  |
|  > Daftar     |  |     ------+-----------+-----+--------- |  |
|  > Tambah     |  |     ....  | ....      | ... | Edit Hps |  |
| Anggota       |  |     ....  | ....      | ... | Edit Hps |  |
| Wireframe     |  +----------------------------------------+  |
+---------------+----------------------------------------------+
```

Mobile (di bawah 992px):

```text
+-------------------------+
| [=]  SIFILM-Mini        |   (1) top bar + tombol menu
+-------------------------+
| Daftar Film             |
| [Tambah film]           |
| +---------------------+ |
| | [ Cari...         ] | |   (2) pencarian
| | Judul | Sutr. | Thn | |   (3) tabel bisa digeser
| | ...   | ...   | ... | |
| |  < geser >          | |
| +---------------------+ |
+-------------------------+
```

Keputusan desain yang terbaca dari wireframe: tombol "Tambah film" sebagai aksi utama berada di kanan atas judul; pencarian berada **di atas** tabel yang dicari; kolom Aksi paling kanan; pada mobile sidebar tersembunyi di balik tombol menu.

### 4.5 Bagaimana halaman wireframe dibuat

Wireframe di proyek ini murni HTML dan CSS (file `assets/css/wireframe.css`), tanpa gambar. Satu "layar" adalah grid dua kolom:

```css
.wf {
  --wf-line: #6b7280;
  display: grid;
  grid-template-columns: 22% 1fr;         /* sidebar | konten */
  border: 2px solid var(--wf-line);
  background: #fff;
  font: 12px/1.3 ui-monospace, Menlo, Consolas, monospace;
}
.wf-has { position: relative; }           /* penampung penanda angka */
.wf-pin {
  position: absolute; top: -9px; left: -9px;
  width: 18px; height: 18px; border-radius: 50%;
  background: #111827; color: #fff;
}
```

```html
<div class="wf-input wf-has"><span class="wf-pin">3</span>Cari judul film...</div>
```

Penanda angka adalah `span` dengan `position: absolute`. Ia diletakkan relatif terhadap induknya yang diberi `position: relative` (`wf-has`). Pola ini umum dipakai untuk badge notifikasi. Kolom tabel wireframe memakai grid juga, dengan jumlah kolom diatur lewat `grid-template-columns` sehingga mudah diubah.

### 4.6 Aturan praktis wireframe

- Tetap **abu-abu**. Warna mengalihkan diskusi dari struktur ke selera.
- Pakai **teks nyata** untuk label penting ("Simpan", "Cari judul film..."), bukan lorem ipsum, supaya fungsinya jelas.
- Gambar **urutan baca** pengguna, bukan dekorasi.
- Satu wireframe menjawab satu pertanyaan: *di mana letak X dan apa yang terjadi bila ditekan?*
- Buat versi **mobile** untuk halaman yang paling padat.

### 4.7 Latihan dan penilaian mandiri

1. Gambar wireframe halaman baru **Detail Film** (poster, sinopsis, tombol pinjam) untuk desktop dan mobile, di kertas atau Figma.
2. Tambahkan halaman itu ke `wireframe/index.html` dengan menyalin salah satu blok `section` yang ada.
3. Periksa wireframemu: apakah aksi utama jelas, apakah setiap elemen punya catatan, apakah alur dari halaman lain ke halaman ini tergambar?

## Bab 5. Jobsheet 5: JavaScript DOM dan Event

### 5.1 Tujuan

Setelah jobsheet ini kamu mampu memilih dan mengubah elemen halaman lewat JavaScript, menangani event (klik, ketik, kirim form), memakai *event delegation*, dan membuat validasi form sendiri. Tampilan tidak berubah; yang berubah adalah **perilaku**: halaman kini bereaksi terhadap pengguna.

### 5.2 Konsep: DOM

Saat browser membaca HTML, ia membangun **DOM** (*Document Object Model*): pohon objek yang mewakili setiap elemen. JavaScript tidak mengubah file HTML; ia mengubah pohon di memori, dan browser langsung menggambar ulang. Buka tab *Elements* di DevTools, itulah DOM, dan kamu akan melihatnya berubah ketika kamu menghapus baris atau mengetik di pencarian.

Skrip dimuat paling akhir sebelum `</body>`, setelah Bootstrap:

```html
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.js"></script>
```

Di akhir `body`, seluruh HTML sudah ada, sehingga `querySelector` menemukan elemennya. **Satu file `app.js` dipakai oleh kelima halaman**, jadi setiap fungsi memeriksa dulu apakah elemen yang dibutuhkannya ada di halaman itu:

```js
const tbody = document.querySelector("#tabel-data tbody");
if (!tbody) return;      // halaman ini tidak punya tabel: berhenti diam-diam
```

Tanpa pemeriksaan ini, halaman Beranda dan halaman form akan menghasilkan error di Console.

### 5.3 Perkakas DOM yang dipakai

| Perkakas | Fungsi | Contoh di proyek |
| --- | --- | --- |
| `document.querySelector(css)` | Elemen **pertama** yang cocok dengan selector CSS | `"#tabel-data tbody"` |
| `querySelectorAll(css)` | **Semua** yang cocok (NodeList) | semua `td` selain kolom terakhir |
| `document.getElementById(id)` | Ambil elemen lewat `id` | `"search-input"` |
| `el.closest(css)` | Naik ke leluhur terdekat yang cocok | dari tombol ke `tr` |
| `el.textContent` | Baca/ubah teks, **aman** dari HTML | isi pesan, nama film |
| `el.value` | Nilai input | `input.value` |
| `el.hidden` | Sembunyikan/tampilkan elemen | filter baris |
| `el.classList.add/remove/toggle` | Ubah class | `is-invalid`, `is-valid` |
| `document.createElement(tag)` | Membuat elemen baru | baris pesan, alert |
| `el.append(...)`, `insertAdjacentElement(posisi, el)` | Menyisipkan elemen | alert sebelum form |
| `el.remove()` | Menghapus elemen dari DOM | menghapus baris |
| `el.setAttribute(nama, nilai)` | Mengatur atribut | `role`, `aria-label` |

### 5.4 Event

Event adalah kejadian di halaman (klik, ketik, kirim form). Kita mendaftarkan **pendengar** (*listener*) yang dijalankan saat kejadian itu muncul:

```js
elemen.addEventListener("nama-event", function (e) {
    // e = objek event: e.target (elemen yang diklik), e.preventDefault(), dll.
});
```

| Event | Terjadi saat | Dipakai untuk |
| --- | --- | --- |
| `DOMContentLoaded` | HTML selesai dibaca | Titik awal menjalankan semua init |
| `click` | Elemen diklik | Tombol Hapus |
| `input` | Isi kolom berubah (setiap ketikan, termasuk tempel dan hapus) | Pencarian real-time, validasi ulang |
| `change` | Nilai `select` berubah | Validasi ulang genre |
| `submit` | Form dikirim | Validasi form |
| `reset` | Form direset | Membersihkan tanda kesalahan |

**Bubbling dan delegation.** Event "menggelembung" dari elemen yang diklik ke induk-induknya. Karena itu satu listener di `tbody` bisa menangkap klik pada **semua** tombol di dalamnya, termasuk tombol pada baris yang baru dibuat nanti. Teknik ini disebut *event delegation*, dan akan sangat menolong di Jobsheet 6 saat baris tabel dibuat dinamis dari JSON.

### 5.5 Titik masuk

```js
document.addEventListener("DOMContentLoaded", function () {
    initHapus();
    initPencarian();
    initValidasiForm();
    sinkronkanTabel();
});
```

Semua fitur dibungkus dalam fungsi `init...` dengan satu tugas masing-masing, lalu dinyalakan dari satu tempat. Pola ini membuat kode mudah dibaca dan mudah dimatikan satu per satu saat debugging (cukup beri komentar pada satu baris).

### 5.6 Fitur 1: konfirmasi hapus

```js
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
```

Baca baris demi baris:

1. Satu listener `click` dipasang di `tbody`, bukan di tiap tombol (delegation).
2. `e.target` adalah elemen persis yang diklik. `closest(".btn-hapus")` memeriksa apakah itu (atau induknya) tombol Hapus. Jika bukan, `return` dan abaikan klik. Ini juga mencegah error ketika yang diklik adalah sel biasa.
3. `btn.closest("tr")` naik ke baris yang memuat tombol.
4. `row.querySelector("td")` mengambil sel **pertama** dalam baris (judul film atau no. anggota) untuk ditampilkan di pesan konfirmasi.
5. `confirm()` menampilkan kotak OK/Batal dan mengembalikan `true` bila OK. Hanya bila `true`, baris dihapus dengan `row.remove()`.
6. `sinkronkanTabel()` memperbarui teks jumlah data dan pesan "kosong" (dijelaskan berikut).

Perlu diingat: penghapusan hanya terjadi di DOM. **Muat ulang halaman, dan baris kembali** karena datanya masih ada di file HTML. Menyimpan perubahan secara permanen membutuhkan server dan basis data (materi jobsheet berikutnya).

### 5.7 Fitur 2: pencarian real-time

```js
function initPencarian() {
    const input = document.getElementById("search-input");
    if (!input) return;
    input.addEventListener("input", sinkronkanTabel);
}
```

Pendengarnya hanya satu baris. Seluruh pekerjaan ada di `sinkronkanTabel`, yang juga dipakai oleh fitur hapus dan oleh Jobsheet 6:

```js
function sinkronkanTabel() {
    const tbody = document.querySelector("#tabel-data tbody");
    if (!tbody) return;

    const input = document.getElementById("search-input");
    const kata = input ? input.value.trim().toLowerCase() : "";
    const baris = ambilBarisData(tbody);
    let tampil = 0;

    baris.forEach(function (row) {
        const teks = Array.from(row.querySelectorAll("td:not(:last-child)"))
            .map(function (td) { return td.textContent; })
            .join(" ")
            .toLowerCase();
        const cocok = teks.includes(kata);
        row.hidden = !cocok;
        if (cocok) tampil++;
    });

    // ... tampilkan/hapus baris pesan "Data tidak ditemukan" / "Belum ada data" ...

    const info = document.getElementById("info-jumlah");
    if (info) info.textContent = "Menampilkan " + tampil + " dari " + baris.length + " data";
}
```

Penjelasan bagian penting:

- `kata` adalah isi kolom cari, dipangkas spasinya dan dijadikan huruf kecil agar pencarian tidak peka huruf besar-kecil.
- Untuk setiap baris, kita **menggabungkan teks semua sel kecuali yang terakhir** (`td:not(:last-child)`). Sel terakhir berisi tombol "Edit" dan "Hapus"; jika ikut dicari, mengetik "edit" akan mencocokkan setiap baris. `Array.from(...)` mengubah NodeList agar bisa memakai `.map`.
- `teks.includes(kata)` bernilai `true` bila teks baris memuat kata kunci. Kolom cari kosong menghasilkan `""`, dan `includes("")` selalu `true`, sehingga semua baris tampil kembali tanpa kode khusus.
- `row.hidden = !cocok` menyembunyikan baris yang tidak cocok. Baris **tidak dihapus**, hanya disembunyikan, jadi mengosongkan pencarian mengembalikannya.
- Event `input` dipilih dibanding `keyup` karena `input` juga tertangkap saat teks ditempel atau dihapus dengan mouse.

Kalau tidak ada baris yang tampil, fungsi ini membuat satu baris pesan dengan `createElement("tr")` yang `td`-nya memakai `colSpan` sebanyak jumlah kolom tabel, sehingga pesan membentang selebar tabel. Pesannya berbeda: "Belum ada data." bila tabel memang kosong, "Data tidak ditemukan." bila baris ada tetapi semuanya tersaring.

### 5.8 Fitur 3: validasi form

**Alur besarnya**

```text
Pengguna menekan Simpan
  -> event submit; e.preventDefault() (jangan pindah halaman)
  -> untuk setiap field: validasiField() mengembalikan pesan kesalahan atau ""
       ada pesan  -> tampilkanError()  (kotak merah + teks)
       tidak ada  -> tandaiValid()     (kotak hijau)
  -> ada kesalahan? fokus ke field pertama yang salah, selesai
  -> semua benar?  ambil nama, form.reset(), tampilkan alert sukses
```

**Satu aturan generik, bukan per field.** `validasiField` membaca aturan dari atribut HTML yang sudah ada (`required`, `min`, `max`, `pattern`, `title`), sehingga satu fungsi melayani semua field di form film maupun anggota:

```js
function validasiField(el, form) {
    const nilai = el.value.trim();
    const labelEl = form.querySelector('label[for="' + el.id + '"]');
    const nama = labelEl ? labelEl.textContent : "Field ini";

    if (el.required && nilai === "") return nama + " wajib diisi.";
    if (nilai === "") return "";            // field opsional yang dikosongkan

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
    return "";                               // kosong = valid
}
```

- Nama field diambil dari teks `<label for="...">`, sehingga pesan terbaca alami: "Judul wajib diisi."
- Fungsi mengembalikan **teks pesan** bila salah dan **string kosong** bila benar. Kontrak sederhana ini membuat pemanggilnya mudah: `if (pesan) ...`.
- Urutan pengecekan penting: wajib isi, lalu kosong-yang-diizinkan, lalu angka, lalu pola. Alamat anggota bersifat opsional, jadi saat kosong ia langsung lolos.
- Pola dibungkus `^(?:...)$` supaya cocok dengan **seluruh** isi. Tanpa jangkar itu, `A001xyz` lolos untuk pola `A[0-9]{3}` karena sebagian teksnya cocok. Pesan kesalahan pola memakai atribut `title` yang sudah kita tulis di HTML.

**Menampilkan hasil dengan class Bootstrap**

```js
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
```

Bootstrap sudah menyiapkan gayanya. Input ber-class `is-invalid` berbingkai merah, dan elemen `.invalid-feedback` setelahnya otomatis tampil. Kode kita hanya mengatur class dan menyisipkan satu `div`. Bila `div` pesan sudah ada, teksnya cukup diganti sehingga tidak menumpuk setiap kali tombol Simpan ditekan.

**Merangkai semuanya**

```js
function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.noValidate = true;     // matikan balon validasi bawaan browser
    const fields = form.querySelectorAll("input, select");

    form.addEventListener("submit", function (e) {
        e.preventDefault();         // belum ada server: cegah pindah halaman
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

        if (pertamaError) { pertamaError.focus(); return; }

        const utama = form.querySelector("input[type='text']");
        const nama = utama ? utama.value.trim() : "data";
        form.reset();                 // reset dulu
        tampilkanSukses(form, nama);  // lalu tampilkan pesan sukses
    });
    // ... listener input/change untuk validasi ulang, dan listener reset ...
}
```

- `form.noValidate = true` menonaktifkan validasi bawaan HTML5 dari Jobsheet 1 supaya pesan kita sendiri yang tampil. Atribut `required`, `min`, dan lainnya **tetap dipakai**, hanya dibaca oleh JavaScript.
- `e.preventDefault()` membatalkan perilaku bawaan submit (berpindah ke `list.html`). Tanpanya, form akan pindah halaman sebelum pesan sempat terlihat.
- Semua field divalidasi sekaligus dalam satu putaran, bukan berhenti di kesalahan pertama, supaya pengguna melihat semua kesalahan dalam sekali kirim. `pertamaError.focus()` memindahkan kursor ke yang pertama.
- **Urutan `reset` lalu `tampilkanSukses` disengaja.** Listener `reset` menghapus alert sukses lama. Bila `reset()` dipanggil setelah alert dibuat, alert baru ikut terhapus. Nama diambil sebelum reset karena nilai input hilang setelahnya.
- Listener tambahan memvalidasi ulang sebuah field saat pengguna mengetik, tetapi **hanya untuk field yang sudah diberi status**. Pengguna tidak dimarahi sebelum menekan Simpan, dan kotak merah hilang begitu isinya diperbaiki.

**`textContent`, bukan `innerHTML`.** Pesan sukses menampilkan nama yang diketik pengguna. Fungsi `tampilkanSukses` membangunnya dengan `createElement` dan `textContent`. Jika memakai `innerHTML` dengan teks pengguna, orang bisa mengetik `<img src=x onerror=...>` dan menjalankan skrip di halaman (XSS). Aturan praktisnya: **teks dari pengguna atau dari data luar selalu lewat `textContent`.**

### 5.9 Debugging

- `console.log(variabel)` untuk mengintip nilai; hasilnya di tab *Console*.
- Tab *Sources*: klik nomor baris untuk memasang *breakpoint*, eksekusi berhenti di sana dan kamu bisa melihat nilai setiap variabel.
- Error merah di Console menyebut berkas dan nomor baris. Baca dari pesan paling atas.
- Tab *Elements*: lihat apakah class `is-invalid` benar-benar menempel setelah submit.

### 5.10 Kesalahan umum

| Gejala / pesan | Penyebab |
| --- | --- |
| `Cannot read properties of null` | `querySelector` tidak menemukan elemen (selector salah atau skrip dimuat sebelum HTML); lupa `if (!elemen) return` |
| Tombol Hapus tidak bereaksi pada baris baru | Listener dipasang di setiap tombol, bukan memakai delegation |
| Form pindah halaman sebelum pesan terlihat | Lupa `e.preventDefault()` |
| Pesan validasi dobel (browser dan kita) | Lupa `form.noValidate = true` |
| Pencarian cocok ke semua baris saat mengetik "edit" | Ikut mencari di sel Aksi |
| Skrip tidak jalan sama sekali | Path `src` salah (`../assets/js/app.js` di subfolder), cek tab *Network* |

### 5.11 Latihan

1. Tambahkan tombol **Urutkan A-Z** di atas tabel yang mengurutkan baris berdasarkan kolom pertama.
2. Ubah `confirm()` menjadi modal Bootstrap.
3. Tambahkan penghitung karakter di bawah kolom Judul memakai event `input`.
4. Tambahkan aturan: rating harus kelipatan 0.1. Letakkan di `validasiField`.

## Bab 6. Jobsheet 6: Fetch API dan JSON

### 6.1 Tujuan

Setelah jobsheet ini kamu mampu membaca dan menulis JSON, mengambil data dengan `fetch` memakai `async/await`, menampilkan data ke tabel secara dinamis, menangani kegagalan pengambilan data, dan mengubah data form menjadi JSON.

### 6.2 Konsep: memisahkan data dari tampilan

Sampai Jobsheet 5, data film **tertanam di HTML**. Menambah satu film berarti mengedit file HTML. Pada aplikasi nyata, data tinggal di tempat lain (basis data, server) dan halaman hanya *menampilkan*. Jobsheet ini mensimulasikannya: data dipindahkan ke file `.json`, dan JavaScript mengambilnya lalu membangun tabel.

**JSON** (*JavaScript Object Notation*) adalah format teks untuk bertukar data. Contoh satu film di `data/film.json`:

```json
{
    "judul": "Laskar Pelangi",
    "sutradara": "Riri Riza",
    "tahun": 2008,
    "durasi": 125,
    "rating": 7.7,
    "genre": "drama",
    "dipinjam": false
}
```

Aturan JSON yang ketat (lebih ketat dari objek JavaScript):

- Kunci **wajib** diberi tanda kutip ganda: `"judul"`, bukan `judul` atau `'judul'`.
- Tipe yang boleh: string (kutip ganda), angka, `true`/`false`, `null`, array `[ ]`, dan objek `{ }`.
- Tidak boleh ada koma setelah elemen terakhir dan tidak boleh ada komentar.
- Satu kesalahan kecil membuat seluruh file gagal dibaca. Periksa file di jsonlint.com atau di editor.

File `film.json` berisi **array** berisi 12 objek film, dan `anggota.json` berisi array 8 objek (`no_anggota`, `nama`, `alamat`, `no_hp`). Dua fungsi kunci untuk JSON di JavaScript: `JSON.parse(teks)` mengubah teks menjadi objek, dan `JSON.stringify(objek)` melakukan sebaliknya.

### 6.3 Perubahan pada HTML

Halaman daftar kini memiliki `tbody` **kosong** dan sebuah indikator loading:

```html
<div id="loading-indicator" class="d-flex align-items-center gap-2 text-secondary mb-3 d-none" role="status">
  <div class="spinner-border spinner-border-sm" aria-hidden="true"></div><span>Memuat data...</span>
</div>
<table class="table table-hover align-middle mb-0" id="tabel-data">
  <thead>...</thead>
  <tbody></tbody>
</table>
```

Indikator memakai class `d-none` (Bootstrap: `display: none`) sehingga tersembunyi bawaan, dan JavaScript yang menampilkannya saat data sedang diambil. Skrip dimuat dengan **urutan yang penting**:

```html
<script src="../assets/js/app.js"></script>
<script src="../assets/js/film.js"></script>
```

`film.js` memakai fungsi yang didefinisikan di `app.js` (`ambilJSON`, `buatSel`, `sinkronkanTabel`, dst.), jadi `app.js` harus dimuat lebih dulu. Beranda memakai `dashboard.js`, dan halaman anggota memakai `anggota.js`.

### 6.4 Fetch, Promise, dan async/await

`fetch(url)` meminta berkas lewat jaringan. Karena jaringan butuh waktu, `fetch` tidak langsung memberi hasil, melainkan sebuah **Promise**: janji bahwa hasilnya akan datang nanti. Kata kunci `await` menunggu janji itu selesai **tanpa membekukan halaman**, dan hanya boleh dipakai di dalam fungsi `async`.

```js
const JEDA_SIMULASI_MS = 600; // hanya untuk demo, agar indikator loading sempat terlihat

async function ambilJSON(url) {
    await new Promise(function (resolve) { setTimeout(resolve, JEDA_SIMULASI_MS); });
    const res = await fetch(url);
    if (!res.ok) {
        throw new Error("Gagal mengambil data (status " + res.status + ")");
    }
    return res.json();
}
```

1. Baris pertama hanya menunda 600 milidetik agar spinner terlihat; berkas lokal dimuat terlalu cepat untuk dilihat mata. Hapus baris ini di proyek nyata.
2. `await fetch(url)` menghasilkan objek **Response** (status dan isi belum dibaca).
3. **Jebakan terpenting:** `fetch` hanya gagal (*reject*) bila jaringan putus. Respons `404 Not Found` tetap dianggap "berhasil". Karena itu kita memeriksa `res.ok` (bernilai `true` untuk status 200 sampai 299) dan melempar error sendiri bila `false`.
4. `res.json()` membaca isi respons dan mengubahnya menjadi objek JavaScript. Ini juga mengembalikan Promise, dan karena `ambilJSON` adalah fungsi `async`, pemanggilnya cukup `await ambilJSON(...)`.

Fungsi ini dibuat **sekali** dan dipakai film.js, anggota.js, dan dashboard.js, sehingga penanganan error seragam.

### 6.5 Memuat daftar film

```js
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
```

**`buatBarisFilm`: satu objek menjadi satu baris.**

- `buatSel(teks)` (di app.js) membuat `td` dan mengisinya dengan `textContent`, lagi-lagi bukan `innerHTML`, karena data dari berkas luar tidak boleh dianggap aman.
- `toFixed(1)` memaksa satu angka desimal sehingga `9` tampil sebagai `9.0 / 10`. `kapital("sci-fi")` menjadi `Sci-fi`, karena di JSON genre ditulis huruf kecil.
- `buatSelAksi()` membuat sel berisi tombol Edit dan Hapus dengan class Bootstrap yang sama seperti baris statis di Jobsheet 5.

**`muatDaftarFilm`: urutan kerja.**

1. Tampilkan spinner dan kosongkan `tbody`.
2. `try`: tunggu `ambilJSON`, lalu `daftarFilm.map(buatBarisFilm)` mengubah **array data** menjadi **array baris**. Tanda `...` (*spread*) mengurai array itu menjadi argumen, dan `replaceChildren` mengganti seluruh isi `tbody` dalam satu langkah (lebih efisien daripada menambahkan baris satu per satu).
3. `catch`: bila terjadi error di mana pun dalam `try`, tampilkan pesan di tabel, bukan membiarkan halaman diam.
4. `finally`: dijalankan **apa pun hasilnya**. Spinner selalu disembunyikan, dan tabel disinkronkan (jumlah data, pesan kosong).

**Mengapa `sinkronkanTabel()` tidak lagi dipanggil saat halaman dibuka?** Di Jobsheet 5, fungsi itu dipanggil pada `DOMContentLoaded`. Di Jobsheet 6 pemanggilan itu dihapus: saat itu tabel masih kosong, sehingga pengguna akan sekilas melihat "Belum ada data." selagi menunggu. Sekarang tabel disinkronkan hanya setelah data tiba.

**Fitur lama tetap bekerja tanpa diubah.** Baris tabel kini dibuat *setelah* halaman dimuat, tetapi tombol Hapus berfungsi karena listener-nya dipasang di `tbody` (delegation, Bab 5.4). Pencarian juga tetap jalan karena `sinkronkanTabel` membaca baris yang ada **pada saat mengetik**. Inilah hasil nyata dari desain di Jobsheet 5.

### 6.6 Path itu relatif terhadap halaman HTML

Perhatikan dua pemanggilan ini:

```js
ambilJSON("../data/film.json");   // di film.js, dipakai dari film/list.html
ambilJSON("data/film.json");      // di dashboard.js, dipakai dari index.html
```

Path di `fetch` dihitung dari **lokasi halaman HTML yang membuka skrip**, bukan lokasi file JavaScript-nya. `film/list.html` berada satu tingkat di bawah root, jadi perlu `../`. `index.html` berada di root, jadi tidak perlu. Salah path adalah penyebab error `404` yang paling umum.

### 6.7 Penanganan error

```js
function pesanGagal(err) {
    let pesan = "Gagal memuat data: " + err.message + ".";
    if (location.protocol === "file:") {
        pesan += " Buka halaman lewat server lokal (mis. ekstensi Live Server), bukan file://.";
    }
    return pesan;
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
```

Aplikasi yang baik **tidak gagal diam-diam**. Pengguna melihat pesan merah di dalam tabel, dengan petunjuk khusus bila halaman dibuka lewat `file://`. Baris pesan diberi class `baris-error`, dan `sinkronkanTabel` mengenalinya serta tidak menimpanya dengan "Belum ada data." Cobalah sendiri: ubah `film.json` menjadi `filem.json` di `film.js` dan lihat pesan `status 404`.

### 6.8 Dashboard: dua request paralel

```js
const [film, anggota] = await Promise.all([
    ambilJSON("data/film.json"),
    ambilJSON("data/anggota.json")
]);
const dipinjam = film.filter(function (f) { return f.dipinjam; }).length;
const persen = film.length === 0 ? 0 : Math.round((dipinjam / film.length) * 100);

elFilm.textContent = film.length;
document.getElementById("total-anggota").textContent = anggota.length;
document.getElementById("total-dipinjam").textContent = dipinjam;

const bar = document.getElementById("bar-dipinjam");
bar.style.width = persen + "%";
bar.textContent = dipinjam + " dari " + film.length;
```

- `Promise.all([...])` menjalankan dua permintaan **bersamaan** dan menunggu keduanya selesai. Jika dijalankan berurutan (`await` satu per satu) waktu tunggunya dijumlah; paralel hanya selama yang terlama.
- `const [film, anggota] = ...` adalah *destructuring* array: elemen pertama masuk ke `film`, kedua ke `anggota`.
- Angka ringkasan tidak lagi ditulis manual. Total film = panjang array, dipinjam = jumlah objek berisi `"dipinjam": true` (disaring dengan `filter`), dan persen untuk lebar progress bar. Hasilnya: 12 film, 8 anggota, 3 dipinjam, 25%.
- Atribut `aria-valuenow` dan `aria-valuemax` pada elemen progress juga diperbarui, agar pembaca layar mendapat angka yang benar.
- Pengecekan `film.length === 0 ? 0 : ...` mencegah pembagian dengan nol.

### 6.9 Dari form ke JSON

Saat form valid, Jobsheet 6 menampilkan data form dalam format JSON:

```js
const data = Object.fromEntries(new FormData(form));   // ambil semua field sebagai objek
form.reset();
tampilkanSukses(form, nama, data);
// di dalam tampilkanSukses:
const json = JSON.stringify(data, null, 2);             // objek -> teks JSON (rapi, indentasi 2)
```

`new FormData(form)` mengumpulkan semua field berdasarkan atribut **`name`** (itulah beda `name` dan `id` yang dibahas di Bab 1.8), dan `Object.fromEntries` mengubahnya menjadi objek. Hasilnya, misalnya:

```json
{
  "judul": "Film Uji",
  "sutradara": "Tester",
  "tahun": "2020",
  "durasi": "90",
  "rating": "7.5",
  "genre": "drama"
}
```

Perhatikan bahwa **semua nilai berupa string** (`"2020"`, bukan `2020`), karena begitulah form bekerja. Server atau kode kita yang kelak mengubahnya menjadi angka. Pada aplikasi dengan server, string JSON inilah yang dikirim seperti ini (contoh, tidak aktif di proyek):

```js
fetch("api/film", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: json
});
```

### 6.10 Melihat request di DevTools

Buka tab *Network*, muat ulang halaman daftar film, lalu klik `film.json`. Tab *Headers* menunjukkan status `200`, *Response* menampilkan isi JSON mentah, dan *Timing* menunjukkan lamanya. Ubah *Throttling* menjadi *Slow 3G* dan muat ulang: spinner akan terlihat lebih lama, seperti di jaringan lambat sungguhan.

### 6.11 Kesalahan umum

| Gejala / pesan | Penyebab |
| --- | --- |
| Tabel menampilkan "Failed to fetch" | Halaman dibuka lewat `file://`; gunakan server lokal |
| `status 404` | Path JSON salah (ingat `../` dari subfolder) atau nama file salah |
| `Unexpected token ... in JSON` | File JSON tidak valid: koma sisa, kutip tunggal, atau komentar |
| `ambilJSON is not defined` | `app.js` tidak dimuat, atau dimuat **setelah** `film.js` |
| `Cannot use 'await' outside an async function` | Fungsi pemanggil lupa diberi `async` |
| Tabel kosong tanpa pesan apa pun | Lupa `await` sehingga yang dipakai masih Promise, bukan datanya |
| Data tampil `undefined` | Nama properti salah ketik (`judul` vs `Judul`); JSON peka huruf besar-kecil |

### 6.12 Latihan

1. Tambahkan film ke `film.json`, lalu muat ulang. Tidak ada HTML yang diubah, dan inilah intinya.
2. Tambahkan kolom **Status** di tabel film ("Dipinjam" atau "Tersedia") berdasarkan properti `dipinjam`.
3. Tambahkan `data/peminjaman.json` dan tampilkan daftar peminjaman di halaman baru.
4. Tampilkan pesan "Data kosong" bila JSON berupa array kosong `[]`. Periksa dulu bagaimana `sinkronkanTabel` menanganinya.

## Bab 7. Rangkuman dan Pemecahan Masalah

### 7.1 Perjalanan satu fitur dari Jobsheet 1 ke 6

Tabel **Daftar Film** adalah contoh terbaik untuk melihat bagaimana tiap jobsheet menambah satu lapisan:

| Jobsheet | Keadaan tabel Daftar Film |
| --- | --- |
| 1 | `table`, `thead`, `tbody`, `caption` dengan data tertanam; tampil polos |
| 2 | Diberi garis, jarak, hover baris, tombol berwarna |
| 3a | Dibungkus `.table-responsive` agar bisa digeser di HP |
| 3b | Memakai class `table table-hover align-middle` dan tombol `btn` Bootstrap |
| 4 | Dirancang di wireframe: posisi pencarian, kolom Aksi |
| 5 | Bisa dicari real-time dan dihapus dengan konfirmasi |
| 6 | Isinya dimuat dari `film.json`; punya spinner dan pesan error |

Perhatikan bahwa **tidak ada lapisan yang membuang lapisan sebelumnya**. HTML semantik dari Jobsheet 1 tetap menjadi fondasi sampai Jobsheet 6.

### 7.2 Alur data di Jobsheet 6

```text
Pengguna membuka film/list.html (lewat http://localhost)
  -> browser memuat HTML, CSS Bootstrap, lalu app.js dan film.js
  -> DOMContentLoaded: muatDaftarFilm() jalan
  -> spinner tampil; ambilJSON("../data/film.json") meminta berkas ke server
  -> server membalas JSON -> res.json() menjadi array objek
  -> map(buatBarisFilm) membuat 12 elemen <tr> -> replaceChildren memasangnya
  -> finally: spinner hilang; sinkronkanTabel() menulis "Menampilkan 12 dari 12 data"
  -> pengguna mengetik di pencarian -> event input -> sinkronkanTabel() menyaring baris
  -> pengguna menekan Hapus -> listener di tbody menangkap klik -> baris dihapus
```

### 7.3 Mengapa Jobsheet 6 tidak jalan lewat file://

Saat sebuah halaman dibuka dengan alamat `file:///...`, browser menganggap setiap berkas lokal sebagai *asal* (origin) terpisah dan **melarang halaman membaca berkas lain lewat `fetch`**. Ini kebijakan keamanan: kalau diizinkan, halaman web sembarang bisa membaca berkas pribadi di komputermu. Lewat `http://localhost:...`, halaman dan JSON berasal dari server dan asal yang sama, sehingga `fetch` diizinkan.

Cara menjalankan server lokal:

- **Live Server** di VS Code: klik kanan `index.html`, pilih *Open with Live Server*.
- **Python:** di dalam folder `Jobsheet6` jalankan `python -m http.server 8000`, lalu buka `http://localhost:8000`.
- **Node.js:** `npx serve` di folder `Jobsheet6`.

Cek singkat: **alamat di browser harus diawali `http://`, bukan `file://`.** Jika memakai `file://`, tabel akan menampilkan pesan yang menjelaskan hal ini (lihat Bab 6.7).

### 7.4 Contekan cepat

**Pola fetch yang bisa dipakai ulang**

```js
async function muat() {
    try {
        const res = await fetch("data/x.json");
        if (!res.ok) throw new Error("status " + res.status);
        const data = await res.json();
        // ... pakai data ...
    } catch (err) {
        // tampilkan pesan error ke pengguna
    } finally {
        // bersihkan: sembunyikan loading
    }
}
```

**Layout cepat**

| Kebutuhan | CSS | Bootstrap |
| --- | --- | --- |
| Susun menyamping | `display: flex` | `d-flex` |
| Jarak antar item | `gap: 0.5rem` | `gap-2` |
| Rata kanan | `justify-content: flex-end` | `justify-content-end` |
| Sembunyikan di HP | media query + `display: none` | `d-none d-md-block` |
| Kolom grid | `grid-template-columns: 1fr 1fr` | `row` + `col-6` |

### 7.5 Pemecahan masalah lintas jobsheet

| Gejala | Periksa |
| --- | --- |
| Gaya (CSS) tidak muncul | Path `<link>` (awalan `../` di subfolder), nama file, cache (Ctrl+F5); tab *Network* menunjukkan 404? |
| Bootstrap/ikon tidak muncul | Internet mati; CDN diblokir; periksa tab *Network* |
| JavaScript tidak jalan | Console: ada error merah? Path `<script>`? Skrip dimuat di akhir `body`? |
| Elemen "null" di Console | Selector salah ketik; `id` tidak ada di halaman itu |
| Perubahan kode tidak terlihat | Cache; simpan file (Ctrl+S); muat ulang keras |
| Halaman lebar menggeser ke samping di HP | Tabel tanpa `.table-responsive`; elemen dengan lebar tetap |
| `fetch` gagal | Halaman dibuka lewat `file://`; path JSON salah; JSON tidak valid |

Tiga kebiasaan debugging yang paling menolong: **baca pesan error dari atas**, **buka tab Network** untuk memastikan berkas benar-benar termuat, dan **kecilkan masalah** dengan memberi komentar pada fitur lain sampai penyebabnya ketemu.

### 7.6 Glosarium

| Istilah | Arti singkat |
| --- | --- |
| Semantik | Elemen HTML yang namanya menjelaskan peran kontennya (`nav`, `main`) |
| Selector | Pola CSS untuk memilih elemen (`.kelas`, `#id`, `nav a`) |
| Specificity | Tingkat kekhususan selector yang menentukan aturan mana yang menang |
| Box model | Cara elemen dihitung: konten, padding, border, margin |
| Flexbox / Grid | Dua sistem tata letak CSS (satu dimensi / dua dimensi) |
| Viewport | Area tampilan halaman di layar perangkat |
| Media query | Aturan CSS yang berlaku hanya pada kondisi tertentu (misalnya lebar layar) |
| Mobile-first | Menulis CSS untuk layar kecil dulu, lalu memperluas ke layar besar |
| Breakpoint | Lebar layar tempat tata letak berubah |
| Framework CSS | Pustaka komponen dan class siap pakai (Bootstrap) |
| Offcanvas | Panel yang bergeser masuk dari tepi layar |
| Wireframe | Sketsa tata letak halaman tanpa gaya visual |
| DOM | Pohon objek yang mewakili halaman di memori browser |
| Event | Kejadian di halaman (klik, ketik, kirim form) |
| Event delegation | Memasang satu listener di induk untuk menangani event anak-anaknya |
| JSON | Format teks untuk bertukar data |
| Promise | Objek yang mewakili hasil operasi yang selesai nanti |
| async / await | Sintaks untuk menulis kode asinkron seperti kode berurutan |
| CDN | Jaringan server yang menyajikan pustaka (Bootstrap) lewat internet |
| XSS | Serangan menyuntikkan skrip lewat teks yang ditampilkan sebagai HTML |

### 7.7 Daftar periksa akhir

**Jobsheet 1:** kelima halaman memakai elemen semantik; semua `label` terhubung ke `input`; form menolak input kosong; tidak ada error di validator W3C.

**Jobsheet 2:** semua halaman tersambung ke `style.css`; warna hanya diatur lewat variabel; menu aktif tersorot memakai `aria-current`.

**Jobsheet 3:** `meta viewport` ada di semua halaman; tidak ada scroll horizontal pada lebar 360px; sidebar berubah menjadi menu di bawah breakpoint; versi Bootstrap memakai grid, offcanvas, card, dan form Bootstrap.

**Jobsheet 4:** wireframe memuat kelima halaman dan minimal satu tampilan mobile; setiap elemen penting bernomor dan punya catatan; alur antarhalaman tergambar.

**Jobsheet 5:** hapus meminta konfirmasi dan memperbarui jumlah data; pencarian tidak mencocokkan tombol Aksi; form menampilkan pesan per field dan memfokuskan field salah pertama.

**Jobsheet 6:** data film dan anggota berasal dari JSON; ada indikator loading; kegagalan memuat menampilkan pesan, bukan tabel kosong; Beranda menghitung ringkasan dari JSON.

### 7.8 Langkah selanjutnya

Semua perubahan di jobsheet ini hilang saat halaman dimuat ulang, karena data hanya hidup di memori browser. Langkah wajar berikutnya adalah menambahkan **server dan basis data** (misalnya PHP dengan PostgreSQL) sehingga data tersimpan permanen. Fondasinya sudah siap: struktur HTML yang rapi, tampilan yang responsif, validasi di sisi klien, dan kebiasaan memisahkan data dari tampilan lewat JSON. Yang tinggal diganti hanyalah sumber datanya, dari berkas `.json` menjadi respons server, dan `fetch` dengan `method: "POST"` untuk mengirim data form.
