# Panduan Hosting InfinityFree & Akses Aplikasi via HP (Mobile) - Hiranya Art House

Dokumen ini menjelaskan langkah demi langkah untuk mempublikasikan (deploy) aplikasi web **Hiranya** ke layanan web hosting gratis **InfinityFree**, sehingga dapat diakses melalui internet menggunakan **link URL** dari Handphone (HP) maupun komputer dari mana saja.

---

## 📋 Fitur yang Tersedia untuk Deployment

1. **Link Akses Online**: Diberikan subdomain gratis (contoh: `https://hiranya.infinityfreeapp.com`).
2. **Support PHP 8+ & MySQL**: Kompatibel penuh dengan kode dan database Hiranya.
3. **Database Backup & Restore**: Dukungan **Export SQL / Excel** dan **Import SQL** melalui Admin Dashboard maupun phpMyAdmin.

---

## 🚀 Langkah 1: Export Database SQL dari Localhost (Komputer)

Sebelum mengunggah website, Anda perlu mengekspor data dan struktur database dari komputer Anda:

### Opsi A (Menggunakan Admin Dashboard Hiranya - Paling Mudah)
1. Buka aplikasi di localhost: `http://localhost/hiranya/login.php`
2. Login sebagai **Admin**.
3. Buka menu **Database & System Tools** (atau Tab Backup).
4. Klik tombol **Download SQL Backup**.
5. File database berformat `.sql` akan terunduh (contoh: `hiranya_backup_2026-07-21_13-00-00.sql`).

### Opsi B (Menggunakan phpMyAdmin Localhost)
1. Buka `http://localhost/phpmyadmin` di browser.
2. Pilih database `hiranya`.
3. Klik tab **Export** di bagian atas -> klik **Go**.
4. Simpan file `hiranya.sql`.

---

## 🌐 Langkah 2: Pendaftaran & Pembuatan Domain di InfinityFree

1. Buka situs [https://infinityfree.com](https://infinityfree.com) lalu klik **Register Now**.
2. Masukkan Email & Password akun Anda, lalu lakukan verifikasi via email.
3. Setelah masuk ke Dashboard InfinityFree, klik tombol **+ Create Account**.
4. **Pilih Domain Type**:
   - Pilih **Subdomain** (Gratis).
   - Masukkan nama subdomain pilihan Anda (contoh: `hiranya-arthouse`).
   - Pilih ekstensi domain (contoh: `.infinityfreeapp.com` atau `.lovestoblog.com`).
   - Hasil link Anda kelak: `https://hiranya-arthouse.infinityfreeapp.com`
5. Klik **Check Availability** -> Jika tersedia, masukkan password akun hosting -> Klik **Create Account**.

---

## 🗄️ Langkah 3: Membuat Database MySQL di InfinityFree

1. Pada Dashboard Akun Hosting InfinityFree Anda, klik **Control Panel** (vPanel).
2. Jika ada persetujuan *ToS*, klik **I Approve**.
3. Cari menu **Databases** -> pilih **MySQL Databases**.
4. Pada kolom **Create New Database**, masukkan nama database: `hiranya` lalu klik **Create Database**.
5. Nama database penuh akan terbentuk (contoh: `if0_38123456_hiranya`).
6. Catat rincian koneksi MySQL yang tertera di halaman tersebut:
   - **MySQL Hostname**: contoh `sql105.infinityfree.com` atau `sql201.epizy.com`
   - **MySQL Username**: contoh `if0_38123456`
   - **MySQL Password**: Password VPanel / Akun Hosting Anda
   - **Database Name**: contoh `if0_38123456_hiranya`

---

## 📥 Langkah 4: Import Database SQL ke InfinityFree

1. Di halaman **MySQL Databases** di Control Panel InfinityFree, cari database yang baru dibuat.
2. Klik tombol **phpMyAdmin** di sebelah kanan nama database.
3. Setelah phpMyAdmin terbuka di tab baru, klik tab **Import** di menu atas.
4. Klik **Choose File** / **Browse**, lalu pilih file `.sql` yang telah di-export pada **Langkah 1**.
5. Gulir ke bawah lalu klik tombol **Go** / **Import**.
6. Tunggu hingga muncul pesan hijau bahwa seluruh tabel (`users`, `artworks`, `auctions`, `bids`, `orders`, dll) berhasil di-import.

---

## 📤 Langkah 5: Upload File Website ke InfinityFree

### Menggunakan File Manager Online (Tanpa Aplikasi Tambahan)
1. Buka Dashboard InfinityFree akun Anda -> klik **File Manager**.
2. Masuk ke dalam folder **`htdocs`** (Hapus file `index2.html` bawaan jika ada).
3. Upload seluruh file & folder proyek `hiranya` Anda ke dalam folder `htdocs`:
   - File utama (`index.php`, `config.php`, `login.php`, `admin_dashboard.php`, `admin_restore.php`, `admin_backup.php`, dll).
   - Folder pendukung (`assets/`, `api/`, `partials/`, `uploads/`, `vendor/`).

> 💡 *Tips (PENTING)*: Pastikan folder `vendor/` dan folder `uploads/` ikut ter-upload agar fitur Excel Export (PhpSpreadsheet) dan gambar karya seni berfungsi dengan baik.

---

## ⚙️ Langkah 6: Update Pengaturan Database (`config.php`)

1. Di dalam **File Manager** InfinityFree (di folder `htdocs`), klik kanan file **`config.php`** -> **Edit**.
2. Ubah variabel koneksi database menggunakan data dari **Langkah 3**:

```php
<?php
// Pengaturan Database InfinityFree Production
$db_host = "sql105.infinityfree.com"; // Sesuaikan dengan MySQL Hostname InfinityFree Anda
$db_user = "if0_38123456";           // Sesuaikan dengan Username InfinityFree Anda
$db_pass = "PasswordVpanelAnda";     // Sesuaikan dengan Password VPanel Anda
$db_name = "if0_38123456_hiranya";   // Sesuaikan dengan Nama DB InfinityFree Anda

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$theme_class = (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark') ? 'dark-mode' : '';
?>
```
3. Klik **Save & Close**.

---

## 📱 Langkah 7: Mengakses Website dari Handphone (HP)

1. Buka aplikasi Browser di HP / Smartphone Anda (Google Chrome, Safari, Samsung Internet, Edge, dll).
2. Ketikkan link domain InfinityFree Anda, misalnya:
   `https://hiranya-arthouse.infinityfreeapp.com`
3. Website **Hiranya Art House** sekarang sudah tampil secara online dan responsif di HP!
4. Pengguna & Admin dapat melakukan:
   - Registrasi & Login pengguna.
   - Menjelajahi katalog karya seni & mengikuti lelang (Bidding) secara langsung.
   - Admin dapat membuka Admin Dashboard di HP untuk memantau pesanan, melakukan **Export Excel**, **Download SQL Backup**, maupun **Import / Restore SQL** sewaktu-waktu.

---

## 🔄 Menggunakan Fitur Export & Import di Admin Dashboard

Aplikasi Hiranya kini dilengkapi fitur manajemen database terpadu:
- **Download SQL Backup**: Mengunduh snapshot database `.sql` dari server.
- **Import / Restore SQL**: Mengunggah file `.sql` untuk memulihkan tabel & data secara otomatis tanpa perlu membuka phpMyAdmin.
- **Export Excel Report**: Mengunduh laporan penjualan & lelang berformat `.xlsx`.

Semua fitur ini dapat diakses melalui halaman **Admin Dashboard** -> Tab **Backup & Utilities**.
