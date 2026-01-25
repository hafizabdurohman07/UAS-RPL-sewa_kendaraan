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
$data = mysqli_query($conn, "SELECT t.*, k.nama_kendaraan, p.nama FROM transaksi t 
                             LEFT JOIN kendaraan k ON t.id_kendaraan = k.id_kendaraan 
                             LEFT JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
                             ORDER BY t.tanggal_sewa DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .header a {
            background: #667eea;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
        }
        
        .header a:hover {
            background: #764ba2;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        table td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }
        
        table tr:hover {
            background: #f5f5f5;
        }
        
        .status-selesai {
            background: #d4edda;
            color: #155724;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
        }
        
        .status-disewa {
            background: #fff3cd;
            color: #856404;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>📊 Laporan Transaksi</h2>
        <a href="../index.php">← Kembali</a>
    </div>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Kendaraan</th>
            <th>Pelanggan</th>
            <th>Tgl Sewa</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
        </tr>
        
        <?php while($row=mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $row['id_transaksi'] ?></td>
            <td><?= $row['nama_kendaraan'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= date('d/m/Y', strtotime($row['tanggal_sewa'])) ?></td>
            <td><?= $row['tanggal_kembali'] ? date('d/m/Y', strtotime($row['tanggal_kembali'])) : '-' ?></td>
            <td>
                <span class="status-<?= strtolower($row['status']) ?>">
                    <?= $row['status'] ?>
                </span>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
