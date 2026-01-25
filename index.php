<?php
session_start();

// Jika belum login, redirect ke login.php
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi Sewa Kendaraan</title>
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
            border-bottom: 2px solid #667eea;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #333;
            margin: 0;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-info p {
            margin: 5px 0;
            color: #666;
        }
        
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        
        .logout-btn:hover {
            background: #c82333;
        }
        
        .menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }
        
        .menu-item {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: transform 0.3s;
            text-align: center;
            font-weight: bold;
        }
        
        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Aplikasi Sewa Kendaraan</h1>
        <div class="user-info">
            <p>Halo, <strong><?php echo $_SESSION['username']; ?></strong></p>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
    
    <div class="menu">
        <a href="kendaraan/index.php" class="menu-item">📋 Data Kendaraan</a>
        <a href="pelanggan/index.php" class="menu-item">👥 Data Pelanggan</a>
        <a href="transaksi/sewa.php" class="menu-item">🚗 Transaksi Sewa</a>
        <a href="laporan/index.php" class="menu-item">📊 Laporan Transaksi</a>
    </div>
</div>

</body>
</html>
