# Fintory - Solusi Manajemen Bisnis Terintegrasi

**Fintory** adalah aplikasi manajemen bisnis berbasis web yang dirancang untuk mengotomatiskan dan menyederhanakan operasional bisnis. Dengan Fintory, Anda dapat mengelola berbagai aspek bisnis mulai dari keuangan, inventaris, penjualan, hingga manajemen karyawan dalam satu platform terpusat, efisien, dan mudah diakses.

## Daftar Isi

* [Filosofi Proyek](#filosofi-proyek)

* [Arsitektur & Konsep Inti](#arsitektur--konsep-inti)

* [Fitur Unggulan](#fitur-unggulan)

* [Teknologi yang Digunakan](#teknologi-yang-digunakan)

* [Panduan Instalasi Lokal](#panduan-instalasi-lokal)

  * [Prasyarat](#prasyarat)

  * [Langkah-langkah Instalasi](#langkah-langkah-instalasi)

* [Struktur dan Desain Database](#struktur-dan-desain-database)

* [Peran Pengguna (User Roles)](#peran-pengguna-user-roles)

* [Lisensi](#lisensi)

## Filosofi Proyek

Fintory dibangun dengan tujuan utama untuk memberdayakan Usaha Mikro, Kecil, dan Menengah (UMKM) serta bisnis yang sedang berkembang. Kami percaya bahwa dengan menyediakan alat yang tepat untuk digitalisasi dan otomatisasi, bisnis dapat lebih fokus pada pertumbuhan dan inovasi, bukan terjebak dalam kerumitan operasional sehari-hari. Aplikasi ini dirancang untuk menjadi intuitif, kuat, dan skalabel.

## Arsitektur & Konsep Inti

Fintory menggunakan arsitektur yang canggih untuk memastikan keamanan data, fleksibilitas, dan skalabilitas.

1. **Arsitektur Multi-Tenant (`Lembaga`)**
   Konsep inti Fintory adalah **Lembaga**, yang merepresentasikan satu entitas bisnis. Setiap lembaga memiliki data yang sepenuhnya terisolasi, termasuk pengguna, outlet, produk, penjualan, dan catatan keuangan. Ini memastikan bahwa data satu bisnis tidak akan pernah bocor atau tercampur dengan data bisnis lain. Seorang pengguna dapat menjadi bagian dari beberapa lembaga dengan peran yang berbeda-beda.

2. **Manajemen Multi-Outlet**
   Setiap lembaga dapat memiliki beberapa **Outlet** atau cabang. Masing-masing outlet memiliki data operasionalnya sendiri, seperti stok produk, saldo kas, dan riwayat penjualan. Ini memungkinkan pemilik bisnis untuk memantau kinerja setiap cabang secara terpisah namun tetap dalam satu dasbor terpusat.

3. **Role-Based Access Control (RBAC)**
   Keamanan dan otorisasi diatur secara ketat melalui sistem peran. Setiap pengguna dalam sebuah lembaga diberi peran tertentu (misalnya, Admin, Manajer, Keuangan) yang menentukan menu dan aksi apa saja yang dapat mereka akses. Ini memastikan bahwa karyawan hanya dapat melihat dan mengelola data yang relevan dengan tanggung jawab mereka.

## Fitur Unggulan

Berikut adalah rincian fungsionalitas utama yang ditawarkan Fintory:

#### 📊 **Dashboard Analitik Interaktif**

Memberikan pandangan cepat dan komprehensif tentang kondisi bisnis Anda.

* **Ringkasan Data**: KPI penting seperti penjualan hari ini, jumlah transaksi, produk aktif, dan peringatan stok menipis.

* **Grafik Tren Penjualan**: Visualisasi data penjualan selama 7 hari terakhir untuk memantau tren.

* **Papan Peringkat Produk**: Menampilkan daftar produk terlaris di bulan ini untuk membantu strategi penjualan.

#### 🏢 **Manajemen Produk & Stok**

Sistem inventaris yang terpusat dan otomatis.

* **Master Barang & Kategori**: Kelola data induk untuk semua item inventaris (`Barang`) dan kategorinya. Data ini menjadi acuan untuk semua outlet.

* **Daftar Produk per Outlet**: Atur harga jual dan jumlah stok untuk setiap barang di masing-masing outlet. Sebuah barang yang sama bisa memiliki harga yang berbeda di outlet yang berbeda.

* **Mutasi Stok Otomatis**: Setiap transaksi (penjualan, retur, penambahan stok) secara otomatis tercatat dalam laporan mutasi, memberikan jejak audit yang jelas untuk setiap pergerakan barang.

#### 🛒 **Manajemen Penjualan (Point of Sale)**

Memudahkan proses transaksi di setiap outlet.

* **Antarmuka POS**: Formulir penjualan yang reaktif dan mudah digunakan, memungkinkan kasir untuk dengan cepat menambahkan produk, menghitung total, dan mencatat pembayaran.

* **Riwayat & Detail Penjualan**: Semua transaksi tersimpan dan dapat dicari atau difilter berdasarkan tanggal. Pengguna dapat melihat detail setiap transaksi, termasuk item yang terjual dan total laba.

#### 💰 **Manajemen Keuangan**

Pencatatan keuangan yang rapi dan akurat.

* **Buku Kas (Cash Ledger)**: Catat semua aliran dana (pemasukan, pengeluaran, transfer antar kas) untuk setiap outlet, memberikan gambaran jelas tentang posisi kas.

* **Manajemen Hutang & Cicilan**: Lacak semua hutang yang dimiliki perusahaan, catat pembayaran cicilan, dan pantau sisa hutang yang belum terbayar.

#### 👥 **Manajemen Pengguna & Peran**

Kontrol penuh atas siapa yang bisa mengakses apa.

* Admin lembaga dapat mengelola pengguna di dalam organisasinya: menambah karyawan baru, menetapkan mereka ke outlet tertentu, dan memberikan peran yang sesuai.

#### 📜 **Laporan Komprehensif**

Dapatkan wawasan mendalam dari data operasional Anda.

* **Laporan Penjualan**: Analisis penjualan berdasarkan periode waktu, produk, atau outlet.

* **Laporan Stok**: Laporan mutasi stok terperinci dan laporan nilai inventaris.

* **Laporan Keuangan**: Laporan laba rugi sederhana, arus kas, dan neraca.

#### 監査 **Log Aktivitas**

Untuk keamanan dan transparansi, semua tindakan penting yang dilakukan pengguna (misalnya, membuat produk baru, menghapus transaksi) dicatat dalam log aktivitas.

## Teknologi yang Digunakan

Fintory dibangun di atas fondasi teknologi yang solid dan modern:

* **Backend**: [Laravel 12](https://laravel.com/) - Framework PHP yang elegan dan kuat.

* **Frontend**:

  * [Vite](https://vitejs.dev/) - Alat build frontend generasi baru yang sangat cepat.

  * [Tailwind CSS](https://tailwindcss.com/) - Framework CSS utility-first untuk desain yang cepat dan kustom.

  * [Alpine.js](https://alpinejs.dev/) - Framework JavaScript minimalis untuk menambahkan interaktivitas.

* **UI Komponen Reaktif**: [Livewire](https://livewire.laravel.com/) - Framework full-stack untuk membangun antarmuka dinamis dengan PHP.

* **Database**: MySQL / MariaDB.

## Panduan Instalasi Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan Fintory di lingkungan pengembangan lokal Anda.

### Prasyarat

Pastikan sistem Anda memenuhi persyaratan berikut:

* PHP >= 8.2

* Composer

* Node.js & NPM

* Server Database (MySQL 8+ atau MariaDB 10.6+ direkomendasikan)

### Langkah-langkah Instalasi

1. **Clone Repositori**
   Buka terminal Anda dan jalankan perintah berikut:

   ```
   git clone [https://github.com/ryan-gabriel/fintory.git](https://github.com/ryan-gabriel/fintory.git)
   cd fintory
   
   ```

2. **Instal Dependensi (Backend & Frontend)**

   ```
   composer install
   npm install
   
   ```

3. **Konfigurasi Environment**
   Buat salinan file `.env.example` menjadi `.env`.

   ```
   cp .env.example .env
   
   ```

   Buka file `.env` dan konfigurasikan koneksi database Anda. Pastikan Anda sudah membuat database kosong terlebih dahulu.

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=fintory_db  // Ganti dengan nama database Anda
   DB_USERNAME=root        // Ganti dengan username database Anda
   DB_PASSWORD=            // Ganti dengan password database Anda
   
   ```

4. **Generate Kunci Aplikasi Laravel**

   ```
   php artisan key:generate
   
   ```

5. **Migrasi dan Seeding Database**
   Perintah `migrate` akan membuat semua tabel yang dibutuhkan. Perintah `db:seed` akan mengisi database dengan data awal yang esensial (peran, menu) dan data dummy (pengguna, produk, transaksi) agar aplikasi siap digunakan.

   ```
   php artisan migrate --seed
   
   ```

   **Akun Admin Default:**

   * **Email**: `admin@gmail.com`

   * **Password**: `12345678`

6. **Build Aset Frontend**
   Perintah ini akan mengompilasi semua file CSS dan JavaScript. Biarkan proses ini berjalan di terminal terpisah selama pengembangan.

   ```
   npm run dev
   
   ```

7. **Jalankan Server Development**
   Buka terminal baru dan jalankan server lokal Laravel.

   ```
   php artisan serve
   
   ```

   Aplikasi Fintory sekarang siap diakses melalui `http://127.0.0.1:8000`.

## Struktur dan Desain Database

Database adalah jantung dari Fintory. Desainnya direncanakan dengan hati-hati untuk efisiensi dan integritas data.

* **Migrations**: Skema database didefinisikan secara deklaratif dalam file-file migrasi di `database/migrations`. Ini memungkinkan version control untuk struktur database.

* **Seeders & Factories**: `database/seeders` dan `database/factories` bekerja sama untuk mengisi database dengan data yang realistis dan konsisten, sangat penting untuk development dan testing.

* **Database Lanjutan**: Untuk mengoptimalkan performa dan mengotomatiskan logika bisnis, Fintory menggunakan:

  * **Triggers**: Contohnya, trigger `after_saleitem_insert` secara otomatis mengurangi stok dan mencatat mutasi setelah item penjualan ditambahkan. Ini memastikan data stok selalu sinkron.

  * **Stored Views/Functions**: View `best_seller_products_monthly` digunakan untuk merangking produk terlaris, menyederhanakan query yang kompleks di sisi aplikasi.

  * **Stored Procedures**: Prosedur `GetDashboardSummary` dieksekusi untuk mengambil semua data ringkasan dashboard dalam satu panggilan database, mengurangi latensi secara signifikan.
<!-- 
## Lisensi

Proyek ini dilisensikan di bawah [Creative Commons Attribution-NonCommercial 4.0 International License](http://creativecommons.org/licenses/by-nc/4.0/).

Anda bebas untuk:
* **Berbagi** — menyalin dan mendistribusikan kembali materi ini dalam bentuk atau format apapun
* **Adaptasi** — menggubah, mengubah, dan membuat turunan dari materi ini

Dengan syarat berikut:
* **Atribusi** — Anda harus memberikan atribusi yang sesuai, memberikan tautan ke lisensi, dan menunjukkan jika ada perubahan yang dilakukan. Anda dapat melakukannya dengan cara yang wajar, tetapi tidak dengan cara yang menyiratkan bahwa pemberi lisensi mendukung Anda atau penggunaan Anda.
* **NonKomersial** — Anda tidak dapat menggunakan materi ini untuk tujuan komersial.

Tidak ada batasan tambahan — Anda tidak dapat menerapkan ketentuan hukum atau tindakan teknis yang secara hukum membatasi orang lain untuk melakukan apa pun yang diizinkan oleh lisensi. -->
