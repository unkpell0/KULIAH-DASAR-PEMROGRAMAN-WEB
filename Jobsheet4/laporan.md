# Laporan Praktikum Jobsheet 3: Implementasi Responsive Design

## Identitas Praktikan
| Keterangan | Isi |
| :--- | :--- |
| Nama | Marvelino Husca |
| Kelas | TI 1H |
| NIM | 254107020184 |
| No Absen | 14 |
| Program Studi | D4 Teknik Informatika |

---

## 1. Penjelasan Singkat
Praktikum ini berfokus pada implementasi Responsive Design dimana website akan mengikuti lebar tampilan device pengguna. Ada tiga tampilan yang akan diatur pada website ini yaitu tampilan mobile, tablet dan desktop. 

## 2. Screenshot hasil per halaman

* **Tampilan Desktop vs Mobile**
  Tampilan navbar home yang awalnya menyamping menjadi menurun ke bawah dengan adanya ikon garis tiga (hamburger) pada Mobile. Lalu grid ringkasan yang ditengah akan menurun vertikal menjadi satu kolom saja

  ![alt text](img/tampilandesktop.png)
  ![alt text](img/tampilanmobile.png)

* **Implementasi Hamburger Menu**
  Menu hamburger akan muncul di halaman mobile dan ketika ditekan akan muncul navbar dalam posisi vertikal

  ![alt text](img/hamburger.png)

* **Halaman Daftar Buku & Anggota (Tabel Responsif)**
  Tampilan tabel yang dapat di-scroll secara horizontal di dalam bungkusannya pada layar kecil

  ![alt text](img/tampilantabel.png)

## 3. Latihan Tambahan
**Tabel Responsif (Overflow):** 
   Menyelesaikan masalah tabel yang merusak dimensi layar *mobile* dengan membungkus elemen `<table>` ke dalam `<div class="table-responsive">` yang memiliki properti `overflow-x: auto;`. Area tabel kini dapat digeser (di-*scroll*) secara horizontal tanpa menggeser elemen halaman lainnya.