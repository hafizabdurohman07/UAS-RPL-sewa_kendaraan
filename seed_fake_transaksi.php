<?php
// seed_fake_transaksi.php
// Menambahkan beberapa transaksi palsu ke database
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config/database.php';

if (!isset($conn) || $conn === false) {
    die('Koneksi database gagal. Periksa file config/database.php');
}

// Ambil semua id kendaraan dan pelanggan
$kendaraan_ids = [];
$pelanggan_ids = [];

$res = mysqli_query($conn, "SELECT id_kendaraan FROM kendaraan");
while ($r = mysqli_fetch_assoc($res)) $kendaraan_ids[] = $r['id_kendaraan'];

$res = mysqli_query($conn, "SELECT id_pelanggan FROM pelanggan");
while ($r = mysqli_fetch_assoc($res)) $pelanggan_ids[] = $r['id_pelanggan'];

if (empty($kendaraan_ids) || empty($pelanggan_ids)) {
    die('Data kendaraan atau pelanggan kosong. Jalankan setup.php terlebih dahulu.');
}

// Fungsi bantu: random tanggal antara dua tanggal
function randDate($startDate, $endDate) {
    $min = strtotime($startDate);
    $max = strtotime($endDate);
    $val = rand($min, $max);
    return date('Y-m-d', $val);
}

$jumlah = 10; // jumlah transaksi palsu
$inserted = 0;

for ($i=0; $i<$jumlah; $i++) {
    $id_k = $kendaraan_ids[array_rand($kendaraan_ids)];
    $id_p = $pelanggan_ids[array_rand($pelanggan_ids)];
    $tgl_sewa = randDate('2026-01-01', date('Y-m-d'));

    // 50% sudah kembali
    if (rand(0,1) == 1) {
        // tanggal kembali 1-7 hari setelah sewa
        $tgl_kembali = date('Y-m-d', strtotime($tgl_sewa . ' +' . rand(1,7) . ' days'));
        $status = 'Selesai';
    } else {
        $tgl_kembali = 'NULL';
        $status = 'Disewa';
    }

    $tgl_kembali_sql = $tgl_kembali === 'NULL' ? 'NULL' : "'" . $tgl_kembali . "'";

    $sql = "INSERT INTO transaksi (id_kendaraan, id_pelanggan, tanggal_sewa, tanggal_kembali, status) 
            VALUES ($id_k, $id_p, '$tgl_sewa', $tgl_kembali_sql, '$status')";
    $ok = mysqli_query($conn, $sql);
    if ($ok) {
        $inserted++;
        // Jika status Disewa, update status kendaraan
        if ($status == 'Disewa') {
            mysqli_query($conn, "UPDATE kendaraan SET status='Disewa' WHERE id_kendaraan=$id_k");
        }
    }
}

echo "Menambahkan $inserted transaksi palsu.\n";

// Tampilkan 10 transaksi terakhir sebagai verifikasi
$res = mysqli_query($conn, "SELECT t.id_transaksi, k.nama_kendaraan, p.nama, t.tanggal_sewa, t.tanggal_kembali, t.status 
                           FROM transaksi t 
                           LEFT JOIN kendaraan k ON t.id_kendaraan=k.id_kendaraan 
                           LEFT JOIN pelanggan p ON t.id_pelanggan=p.id_pelanggan
                           ORDER BY t.id_transaksi DESC LIMIT 10");

echo "<h3>10 Transaksi Terakhir</h3>";
echo "<table border=1 cellpadding=6><tr><th>ID</th><th>Kendaraan</th><th>Pelanggan</th><th>Tgl Sewa</th><th>Tgl Kembali</th><th>Status</th></tr>";
while ($r = mysqli_fetch_assoc($res)) {
    echo '<tr>';
    echo '<td>'.htmlspecialchars($r['id_transaksi']).'</td>';
    echo '<td>'.htmlspecialchars($r['nama_kendaraan']).'</td>';
    echo '<td>'.htmlspecialchars($r['nama']).'</td>';
    echo '<td>'.htmlspecialchars($r['tanggal_sewa']).'</td>';
    echo '<td>'.($r['tanggal_kembali'] ? htmlspecialchars($r['tanggal_kembali']) : '-') .'</td>';
    echo '<td>'.htmlspecialchars($r['status']).'</td>';
    echo '</tr>';
}
echo '</table>';

mysqli_close($conn);
?>