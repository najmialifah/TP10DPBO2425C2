# TP10DPBO2425C2: Aplikasi Manajemen Data K-Pop (Pola MVVM)

## Tugas Praktikum 10 DPBO

Saya **Najmi Alifah Hilmiya** dengan **NIM 2410393** mengerjakan **Tugas Praktikum 10** dalam mata kuliah *Desain Pemrograman Berorientasi Objek* untuk keberkahan-Nya, maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. **Aamiin.**

Aplikasi berbasis web ini dikembangkan menggunakan PHP Native dan **Pola Arsitektur Model-View-ViewModel (MVVM)** untuk mengelola data terkait dunia K-Pop, meliputi informasi grup, member, album, acara, dan data penjualan.

***

## 1. Struktur Proyek

Proyek ini disusun berdasarkan pemisahan tanggung jawab MVVM:

* **`TP10/config/`**: Konfigurasi database.
* **`TP10/models/`**: Logika akses data (CRUD).
* **`TP10/viewmodels/`**: Logika bisnis dan data presentasi.
* **`TP10/views/`**: Antarmuka pengguna (HTML/PHP).
* **`TP10/index.php`**: Router utama aplikasi.

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

***

## 4. Penjelasan Kode Program (Tinjauan Arsitektur MVVM)

### 4.1. Konfigurasi (`TP10/config/Database.php`)

Kelas `Database` bertanggung jawab untuk koneksi database.

* Menggunakan PHP Data Objects (**PDO**) untuk koneksi, memastikan keamanan dan portabilitas.
* Metode `getConnection()` mengembalikan objek koneksi database (`$this->conn`) yang siap digunakan oleh kelas Model.

### 4.2. Model (`TP10/models/`)

Setiap kelas Model (e.g., `Grup.php`, `Album.php`) mewakili satu tabel database.

* **Tanggung Jawab**: Melakukan semua operasi CRUD dengan mengeksekusi *raw* SQL queries menggunakan koneksi PDO.
* **Keamanan**: Sebelum eksekusi `create()` atau `update()`, nilai properti objek (misalnya, `$this->nama_grup`) disanitasi menggunakan `htmlspecialchars(strip_tags())` untuk mitigasi *Cross-Site Scripting* (XSS), meskipun PDO binding sudah memberikan perlindungan SQL Injection.
* **Relasi**: Metode `readAll()` dalam Model untuk entitas yang memiliki Foreign Key (seperti `Album.php` atau `Penjualan.php`) menggunakan klausa **`LEFT JOIN`** untuk mengambil data dari tabel terkait (misalnya, nama grup dari tabel `grup`).

### 4.3. ViewModel (`TP10/viewmodels/`)

ViewModel berfungsi sebagai otak aplikasi, mengelola data yang disajikan dan logika formulir.

* **Pengumpulan Data**: ViewModel memuat data dari Model yang diperlukan untuk tampilan (e.g., `GrupViewModel` memanggil `Grup->readAll()` dan menyimpan hasilnya di `$this->grupList`).
* **Foreign Key (FK) Options**: ViewModel seperti `AlbumViewModel` dan `PenjualanViewModel` secara otomatis memuat daftar opsi FK (misalnya, `$this->grupOptions` atau `$this->albumOptions`) dari Model terkait di konstruktor mereka untuk digunakan dalam dropdown formulir.
* **Penanganan Formulir (`handleFormSubmission`)**: Metode ini melakukan validasi input wajib, dan kemudian memutuskan apakah akan melakukan operasi **Create** (jika tidak ada ID) atau **Update** (jika ada ID) pada Model.

### 4.4. View (`TP10/views/`)

File View hanya berisi kode presentasi HTML/PHP dan tidak mengandung logika bisnis atau akses database.

* **Tampilan Daftar (`_list.php`)**: Memuat ViewModel, memanggil metode `loadAll...()`, dan melakukan perulangan (`foreach`) pada properti daftar ViewModel (e.g., `$viewModel->grupList`) untuk merender baris tabel.
* **Tampilan Formulir (`_form.php`)**:
    * Menggunakan variabel `$is_edit` untuk menyesuaikan judul dan menampilkan *hidden input* ID.
    * Formulir disubmit via **POST** ke dirinya sendiri, di mana ViewModel akan memprosesnya.
    * Bidang input diisi dengan nilai dari ViewModel (e.g., `value="<?php echo htmlspecialchars($viewModel->nama_grup ?? ''); ?>"`) untuk mempertahankan data saat error atau saat mode Edit.
    * Formulir dengan FK (seperti `penjualan_form.php`) merender dropdown `<select>` dengan mengiterasi `$viewModel->albumOptions`, menampilkan judul album dan nama grup untuk memudahkan pengguna memilih.

### 4.5. Router Utama (`TP10/index.php`)

Ini adalah *Controller* yang menentukan halaman mana yang akan dimuat.

* **Routing**: Menggunakan `$_GET['page']` dan `$_GET['action']` untuk menentukan entitas dan operasi yang diminta (list, create, edit, delete).
* **Flow Kontrol**:
    1.  Memuat semua kelas ViewModel.
    2.  Mengecek dan mendekode pesan sukses (`$message`) dari URL.
    3.  Menginstansiasi ViewModel yang sesuai.
    4.  Untuk operasi `delete`, ia memanggil `handleDelete()` pada ViewModel dan melakukan **redirect** ke halaman daftar untuk menghindari permintaan ulang (`header("Location: ...")`).
    5.  Untuk `list`, `create`, atau `edit`, ia menyertakan (`include`) file View yang relevan.

***

## 5. Teknologi yang Digunakan

| Komponen | Deskripsi |
| :--- | :--- |
| **Bahasa Pemrograman** | PHP Native |
| **Arsitektur** | Model-View-ViewModel (MVVM) |
| **Database** | MySQL / MariaDB |
| **Koneksi DB** | PDO (PHP Data Objects) |
| **Desain Web** | HTML / CSS dasar (table-based layout) |
