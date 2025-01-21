## Sistem Pengelolaan Data Pengaduan Pelanggan

Sistem Pengelolaan Data Pengaduan Pelanggan adalah aplikasi berbasis web yang bertujuan untuk membantu perusahaan dalam menerima, mencatat, dan menindaklanjuti pengaduan pelanggan secara efisien.

### Fitur Utama
- **Pengaduan Pelanggan: Pelanggan dapat mengajukan pengaduan melalui formulir.**
- **Manajemen Pengaduan: Admin dapat memantau dan mengelola pengaduan pelanggan.**
- **Laporan Pengaduan: Admin dapat menghasilkan laporan pengaduan untuk analisis.**

### Teknologi yang Digunakan
- **Framework: Laravel 11**
- **Database: MySQL**
- **Frontend: Blade Template Engine, Bootstrap**
- **Versi PHP: >= 8.2**

### Cara Instalasi
Clone repositori ini ke komputer Anda:
- **git clone https://github.com/username/Sistem-Pengelolaan-Data-Pengaduan-Pelanggan.git**

Masuk ke direktori proyek:
- **cd Sistem-Pengelolaan-Data-Pengaduan-Pelanggan**

Install dependensi menggunakan Composer:
- **composer install**

Salin file .env.example menjadi .env:
- **cp .env.example .env**

Konfigurasi file .env sesuai dengan pengaturan database Anda.

Jalankan migrasi database:
- **php artisan migrate**
- **php artisan db:seed**

Jalankan server lokal:
- **php artisan serve**
- **Akses aplikasi di browser Anda melalui http://localhost:8000.**

