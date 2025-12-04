# TP10DPBO2425C2: Aplikasi Manajemen Data K-Pop (Pola MVVM)

## Tugas Praktikum 10 DPBO

Saya **Najmi Alifah Hilmiya** dengan **NIM 2410393** mengerjakan **Tugas Praktikum 10** dalam mata kuliah *Desain Pemrograman Berorientasi Objek* untuk keberkahan-Nya, maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. **Aamiin.**

Aplikasi berbasis web ini dikembangkan menggunakan PHP Native dan **Pola Arsitektur Model-View-ViewModel (MVVM)** untuk mengelola data terkait dunia K-Pop, meliputi informasi grup, member, album, acara, dan data penjualan.

***

## 1. Struktur Proyek

Proyek ini disusun berdasarkan pemisahan tanggung jawab MVVM:

* **`TP10/config/`**
    * `Database.php`: Kelas untuk membuat koneksi tunggal ke database menggunakan **PDO**.

* **`TP10/models/` (Model)**
    * Bertanggung jawab langsung untuk berinteraksi dengan tabel database, menjalankan operasi **CRUD (Create, Read, Update, Delete)**.
    * Meliputi kelas `Grup`, `Member`, `Album`, `Acara`, dan `Penjualan`.

* **`TP10/viewmodels/` (ViewModel)**
    * Berfungsi sebagai jembatan antara Model dan View.
    * Memuat data dari Model (`loadAllGrup`, `loadGrup`).
    * Menangani logika bisnis, seperti validasi form dan memproses *form submission* (`handleFormSubmission`).
    * Mengelola pesan sukses dan error (`successMessage`, `errorMessage`) untuk ditampilkan di View.

* **`TP10/views/` (View)**
    * Berisi *template* PHP/HTML yang menampilkan antarmuka pengguna (daftar data dan form).
    * Mengakses properti yang telah diolah oleh ViewModel (e.g., `$viewModel->grupList`).

* **`TP10/index.php`**
    * Berfungsi sebagai **Router** utama, memuat ViewModel dan View yang sesuai berdasarkan parameter `page` dan `action` dari URL.

***

## 2. Fitur Utama

Aplikasi ini mendukung operasi CRUD lengkap pada lima entitas data K-Pop:

1.  **Grup**: Mengelola Nama Grup, Agensi, dan Tahun Debut.
2.  **Member**: Mengelola Nama Lengkap, Nama Panggung, Kewarganegaraan, dan **Grup** (Foreign Key).
3.  **Album**: Mengelola Judul Album, Jenis Album, Tanggal Rilis, dan **Grup** (Foreign Key).
4.  **Acara**: Mengelola Nama Acara, Jenis Acara, Lokasi, Tanggal Acara, dan **Grup** (Foreign Key).
5.  **Penjualan**: Mengelola Jumlah Terjual, Negara, Sumber Chart, dan **Album** (Foreign Key).

***

## 3. Skema Database

Aplikasi menggunakan database bernama `db_kpop` dengan relasi antar tabel sebagai berikut:

| Tabel | Kolom Kunci Utama | Kolom Kunci Asing (FK) | Relasi FK ke Tabel |
| :--- | :--- | :--- | :--- |
| **`grup`** | `id` | - | - |
| **`member`** | `id` | `id_grup` | `grup` |
| **`album`** | `id` | `id_grup` | `grup` |
| **`acara`** | `id` | `id_grup` | `grup` |
| **`penjualan`** | `id` | `id_album` | `album` |

*Tabel `member`, `album`, dan `acara` memiliki relasi *one-to-many* ke tabel `grup`, sedangkan tabel `penjualan` memiliki relasi *one-to-many* ke tabel `album`*.

### Detail Khusus Model

* **Model `Album`**: Data daftar album diurutkan berdasarkan `tgl_rilis` (Tanggal Rilis) secara menurun (`DESC`), kemudian berdasarkan `id` secara menurun (`DESC`).
* **Model `Penjualan`**: Data penjualan diurutkan berdasarkan `id` penjualan secara menaik (`ASC`).
* **Model `Acara`**: Data acara diurutkan berdasarkan `id` acara secara menaik (`ASC`).

***

## 4. Teknologi yang Digunakan

| Komponen | Deskripsi |
| :--- | :--- |
| **Bahasa Pemrograman** | PHP Native |
| **Arsitektur** | Model-View-ViewModel (MVVM) |
| **Database** | MySQL / MariaDB |
| **Koneksi DB** | PDO (PHP Data Objects) |
| **Desain Web** | HTML / CSS dasar (table-based layout) |
