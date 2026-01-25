<?php
// Script untuk membuat database dan mengimpor data contoh

$conn = mysqli_connect("localhost", "root", "");

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Hapus database lama jika ada (opsional)
// mysqli_query($conn, "DROP DATABASE IF EXISTS sewa_kendaraan");

// Buat database
$sql_db = "CREATE DATABASE IF NOT EXISTS sewa_kendaraan";
if (mysqli_query($conn, $sql_db)) {
    echo "✓ Database 'sewa_kendaraan' berhasil dibuat/sudah ada<br>";
} else {
    echo "✗ Gagal membuat database: " . mysqli_error($conn) . "<br>";
    exit;
}

// Pilih database
mysqli_select_db($conn, "sewa_kendaraan");

// Buat tabel kendaraan
$sql_kendaraan = "CREATE TABLE IF NOT EXISTS kendaraan (
    id_kendaraan INT PRIMARY KEY AUTO_INCREMENT,
    nama_kendaraan VARCHAR(100),
    jenis VARCHAR(50),
    plat_nomor VARCHAR(20),
    harga_sewa INT,
    status VARCHAR(20)
)";

if (mysqli_query($conn, $sql_kendaraan)) {
    echo "✓ Tabel 'kendaraan' berhasil dibuat<br>";
} else {
    echo "✗ Gagal membuat tabel kendaraan: " . mysqli_error($conn) . "<br>";
}

// Buat tabel pelanggan
$sql_pelanggan = "CREATE TABLE IF NOT EXISTS pelanggan (
    id_pelanggan INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100),
    alamat VARCHAR(255),
    no_hp VARCHAR(15)
)";

if (mysqli_query($conn, $sql_pelanggan)) {
    echo "✓ Tabel 'pelanggan' berhasil dibuat<br>";
} else {
    echo "✗ Gagal membuat tabel pelanggan: " . mysqli_error($conn) . "<br>";
}

// Buat tabel transaksi
$sql_transaksi = "CREATE TABLE IF NOT EXISTS transaksi (
    id_transaksi INT PRIMARY KEY AUTO_INCREMENT,
    id_kendaraan INT,
    id_pelanggan INT,
    tanggal_sewa DATE,
    tanggal_kembali DATE,
    status VARCHAR(20),
    FOREIGN KEY (id_kendaraan) REFERENCES kendaraan(id_kendaraan),
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan)
)";

if (mysqli_query($conn, $sql_transaksi)) {
    echo "✓ Tabel 'transaksi' berhasil dibuat<br>";
} else {
    echo "✗ Gagal membuat tabel transaksi: " . mysqli_error($conn) . "<br>";
}

// Kosongkan tabel untuk mengimpor data baru (opsional)
mysqli_query($conn, "DELETE FROM transaksi");
mysqli_query($conn, "DELETE FROM kendaraan");
mysqli_query($conn, "DELETE FROM pelanggan");
mysqli_query($conn, "ALTER TABLE kendaraan AUTO_INCREMENT = 1");
mysqli_query($conn, "ALTER TABLE pelanggan AUTO_INCREMENT = 1");
mysqli_query($conn, "ALTER TABLE transaksi AUTO_INCREMENT = 1");

// Impor data kendaraan
$data_kendaraan = array(
    array('Toyota Avanza', 'MPV', 'B 1234 CD', 300000, 'Tersedia'),
    array('Honda Jazz', 'Sedan', 'B 5678 EF', 250000, 'Tersedia'),
    array('Daihatsu Xenia', 'MPV', 'B 9012 GH', 280000, 'Disewa'),
    array('Suzuki Ertiga', 'MPV', 'B 3456 IJ', 320000, 'Tersedia'),
    array('Toyota Innova', 'Bus', 'B 7890 KL', 500000, 'Tersedia')
);

foreach ($data_kendaraan as $kendaraan) {
    $sql = "INSERT INTO kendaraan (nama_kendaraan, jenis, plat_nomor, harga_sewa, status) 
            VALUES ('$kendaraan[0]', '$kendaraan[1]', '$kendaraan[2]', $kendaraan[3], '$kendaraan[4]')";
    mysqli_query($conn, $sql);
}
echo "✓ Data kendaraan berhasil diimpor (" . count($data_kendaraan) . " data)<br>";

// Impor data pelanggan
$data_pelanggan = array(
    array('Budi Santoso', 'Jl. Merdeka No. 10, Jakarta', '081234567890'),
    array('Siti Nurhaliza', 'Jl. Diponegoro No. 25, Bandung', '082345678901'),
    array('Rudi Hermawan', 'Jl. Ahmad Yani No. 50, Surabaya', '083456789012'),
    array('Rina Wijaya', 'Jl. Sudirman No. 15, Medan', '084567890123'),
    array('Ahmad Gunawan', 'Jl. Gatot Subroto No. 30, Yogyakarta', '085678901234')
);

foreach ($data_pelanggan as $pelanggan) {
    $sql = "INSERT INTO pelanggan (nama, alamat, no_hp) 
            VALUES ('$pelanggan[0]', '$pelanggan[1]', '$pelanggan[2]')";
    mysqli_query($conn, $sql);
}
echo "✓ Data pelanggan berhasil diimpor (" . count($data_pelanggan) . " data)<br>";

// Impor data transaksi
$data_transaksi = array(
    array(1, 1, '2026-01-05', '2026-01-08', 'Selesai'),
    array(2, 2, '2026-01-06', NULL, 'Disewa'),
    array(3, 3, '2026-01-07', NULL, 'Disewa'),
    array(4, 4, '2026-01-03', '2026-01-07', 'Selesai'),
    array(5, 5, '2026-01-08', NULL, 'Disewa')
);

foreach ($data_transaksi as $transaksi) {
    $tgl_kembali = $transaksi[3] ? "'{$transaksi[3]}'" : "NULL";
    $sql = "INSERT INTO transaksi (id_kendaraan, id_pelanggan, tanggal_sewa, tanggal_kembali, status) 
            VALUES ({$transaksi[0]}, {$transaksi[1]}, '{$transaksi[2]}', {$tgl_kembali}, '{$transaksi[4]}')";
    mysqli_query($conn, $sql);
}
echo "✓ Data transaksi berhasil diimpor (" . count($data_transaksi) . " data)<br>";

echo "<hr>";
echo "<h3 style='color: green;'>✓ Semua data berhasil diimpor!</h3>";
echo "<p><a href='index.php'>← Kembali ke Halaman Utama</a></p>";

mysqli_close($conn);
?>
