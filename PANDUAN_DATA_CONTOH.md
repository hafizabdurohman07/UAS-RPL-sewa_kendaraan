# Panduan Mengisi Data Contoh Aplikasi Sewa Kendaraan

## Langkah-langkah Mengimpor Data:

### 1. Buka phpMyAdmin
- Akses http://localhost/phpmyadmin
- Login dengan username dan password (default: root, tanpa password)

### 2. Buat Database
- Klik "New" atau "Database" bagian kiri
- Nama Database: `sewa_kendaraan`
- Klik tombol "Create"

### 3. Impor File SQL
- Pilih database `sewa_kendaraan`
- Klik tab "Import"
- Klik "Browse" atau "Choose File"
- Pilih file `database_contoh.sql` di folder: `d:\xampp\htdocs\sewa-kendaraan\`
- Klik "Import"

### 4. Verifikasi Data
Setelah berhasil, Anda akan melihat 3 tabel:
- **kendaraan** - 5 data kendaraan
- **pelanggan** - 5 data pelanggan  
- **transaksi** - 5 data transaksi

## Data Contoh yang Sudah Ditambahkan:

### Kendaraan:
1. Toyota Avanza (MPV) - Rp. 300.000/hari - Tersedia
2. Honda Jazz (Sedan) - Rp. 250.000/hari - Tersedia
3. Daihatsu Xenia (MPV) - Rp. 280.000/hari - Disewa
4. Suzuki Ertiga (MPV) - Rp. 320.000/hari - Tersedia
5. Toyota Innova (Bus) - Rp. 500.000/hari - Tersedia

### Pelanggan:
1. Budi Santoso
2. Siti Nurhaliza
3. Rudi Hermawan
4. Rina Wijaya
5. Ahmad Gunawan

### Transaksi:
- Beberapa transaksi sudah selesai
- Beberapa transaksi masih dalam proses sewa

## Login Aplikasi:
- Username: `admin`
- Password: `admin123`

Setelah login, Anda dapat melihat semua data contoh di setiap menu!
