<?php
session_start();
if (!isset($_SESSION['login'])) {
	header("Location: ../login.php");
	exit;
}

require_once __DIR__ . '/../config/database.php';
if (!isset($conn) || $conn === false) {
	die('Koneksi database gagal. Periksa file config/database.php');
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Proses form saat POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id_kendaraan = mysqli_real_escape_string($conn, $_POST['kendaraan'] ?? '');
	$id_pelanggan = mysqli_real_escape_string($conn, $_POST['pelanggan'] ?? '');
	$tanggal = date('Y-m-d');

	if (empty($id_kendaraan) || empty($id_pelanggan)) {
		$error = 'Pilih kendaraan dan pelanggan.';
	} else {
		$sql = "INSERT INTO transaksi (id_kendaraan, id_pelanggan, tanggal_sewa, status) \
				VALUES ($id_kendaraan, $id_pelanggan, '$tanggal', 'Disewa')";
		if (mysqli_query($conn, $sql)) {
			mysqli_query($conn, "UPDATE kendaraan SET status='Disewa' WHERE id_kendaraan=$id_kendaraan");
			$success = 'Transaksi sewa berhasil disimpan.';
		} else {
			$error = 'Gagal menyimpan transaksi: ' . mysqli_error($conn);
		}
	}
}

// Ambil daftar kendaraan yang tersedia dan pelanggan
$kendaraan_res = mysqli_query($conn, "SELECT id_kendaraan, nama_kendaraan, plat_nomor, harga_sewa, status FROM kendaraan ORDER BY nama_kendaraan");
$pelanggan_res = mysqli_query($conn, "SELECT id_pelanggan, nama FROM pelanggan ORDER BY nama");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Transaksi Sewa</title>
	<style>
		body { font-family: Arial, sans-serif; background:#f5f5f5; margin:20px }
		.container { max-width:800px; margin:0 auto; background:white; padding:20px; border-radius:8px }
		label { display:block; margin-top:12px }
		select, button { padding:10px; width:100%; max-width:400px }
		.btn { background:#667eea; color:#fff; border:none; border-radius:6px; cursor:pointer }
		.alert { padding:10px; border-radius:6px; margin-bottom:12px }
		.success { background:#d4edda; color:#155724 }
		.error { background:#f8d7da; color:#721c24 }
	</style>
</head>
<body>
<div class="container">
	<h2>🚗 Transaksi Sewa</h2>

	<?php if (!empty($error)): ?>
		<div class="alert error"><?php echo $error; ?></div>
	<?php endif; ?>
	<?php if (!empty($success)): ?>
		<div class="alert success"><?php echo $success; ?></div>
	<?php endif; ?>

	<form method="POST" action="">
		<label for="kendaraan">Pilih Kendaraan</label>
		<select id="kendaraan" name="kendaraan" required>
			<option value="">-- Pilih Kendaraan --</option>
			<?php while($k = mysqli_fetch_assoc($kendaraan_res)) { ?>
				<option value="<?php echo $k['id_kendaraan']; ?>" <?php echo ($k['status']!='Tersedia') ? 'disabled' : ''; ?> >
					<?php echo htmlspecialchars($k['nama_kendaraan'] . ' - ' . $k['plat_nomor'] . ' (Rp. ' . number_format($k['harga_sewa'],0,',','.') . ')'); ?>
					<?php echo ($k['status']!='Tersedia') ? ' - [' . $k['status'] . ']' : ''; ?>
				</option>
			<?php } ?>
		</select>

		<label for="pelanggan">Pilih Pelanggan</label>
		<select id="pelanggan" name="pelanggan" required>
			<option value="">-- Pilih Pelanggan --</option>
			<?php while($p = mysqli_fetch_assoc($pelanggan_res)) { ?>
				<option value="<?php echo $p['id_pelanggan']; ?>"><?php echo htmlspecialchars($p['nama']); ?></option>
			<?php } ?>
		</select>

		<div style="margin-top:16px">
			<button type="submit" class="btn">Simpan Transaksi</button>
			<a href="../index.php" style="margin-left:12px; display:inline-block; padding:10px 14px; background:#6c757d; color:white; border-radius:6px; text-decoration:none">Kembali</a>
		</div>
	</form>
</div>
</body>
</html>
