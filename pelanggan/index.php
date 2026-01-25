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
$data = mysqli_query($conn, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>
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
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        
        .header a:hover {
            background: #764ba2;
        }
        
        .back-btn {
            background: #666 !important;
            padding: 8px 15px !important;
            font-size: 14px !important;
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
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>👥 Data Pelanggan</h2>
        <div>
            <a href="tambah.php">+ Tambah Pelanggan</a>
            <a href="../index.php" class="back-btn">← Kembali</a>
        </div>
    </div>
    
    <table>
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Alamat</th>
            <th>No HP</th>
        </tr>
        
        <?php $no=1; while($row=mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['alamat'] ?></td>
            <td><?= $row['no_hp'] ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
