-- Tabel Kendaraan
CREATE TABLE IF NOT EXISTS kendaraan (
    id_kendaraan INT PRIMARY KEY AUTO_INCREMENT,
    nama_kendaraan VARCHAR(100),
    jenis VARCHAR(50),
    plat_nomor VARCHAR(20),
    harga_sewa INT,
    status VARCHAR(20)
);

-- Data Contoh Kendaraan
INSERT INTO kendaraan (nama_kendaraan, jenis, plat_nomor, harga_sewa, status) VALUES
('Toyota Avanza', 'MPV', 'B 1234 CD', 300000, 'Tersedia'),
('Honda Jazz', 'Sedan', 'B 5678 EF', 250000, 'Tersedia'),
('Daihatsu Xenia', 'MPV', 'B 9012 GH', 280000, 'Disewa'),
('Suzuki Ertiga', 'MPV', 'B 3456 IJ', 320000, 'Tersedia'),
('Toyota Innova', 'Bus', 'B 7890 KL', 500000, 'Tersedia');

-- Tabel Pelanggan
CREATE TABLE IF NOT EXISTS pelanggan (
    id_pelanggan INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100),
    alamat VARCHAR(255),
    no_hp VARCHAR(15)
);

-- Data Contoh Pelanggan
INSERT INTO pelanggan (nama, alamat, no_hp) VALUES
('Budi Santoso', 'Jl. Merdeka No. 10, Jakarta', '081234567890'),
('Siti Nurhaliza', 'Jl. Diponegoro No. 25, Bandung', '082345678901'),
('Rudi Hermawan', 'Jl. Ahmad Yani No. 50, Surabaya', '083456789012'),
('Rina Wijaya', 'Jl. Sudirman No. 15, Medan', '084567890123'),
('Ahmad Gunawan', 'Jl. Gatot Subroto No. 30, Yogyakarta', '085678901234');

-- Tabel Transaksi
CREATE TABLE IF NOT EXISTS transaksi (
    id_transaksi INT PRIMARY KEY AUTO_INCREMENT,
    id_kendaraan INT,
    id_pelanggan INT,
    tanggal_sewa DATE,
    tanggal_kembali DATE,
    status VARCHAR(20),
    FOREIGN KEY (id_kendaraan) REFERENCES kendaraan(id_kendaraan),
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan)
);

-- Data Contoh Transaksi
INSERT INTO transaksi (id_kendaraan, id_pelanggan, tanggal_sewa, tanggal_kembali, status) VALUES
(1, 1, '2026-01-05', '2026-01-08', 'Selesai'),
(2, 2, '2026-01-06', NULL, 'Disewa'),
(3, 3, '2026-01-07', NULL, 'Disewa'),
(4, 4, '2026-01-03', '2026-01-07', 'Selesai'),
(5, 5, '2026-01-08', NULL, 'Disewa');
