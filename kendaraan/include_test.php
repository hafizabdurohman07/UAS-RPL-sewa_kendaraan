<?php
// include_test.php - tes include config/database.php dari folder kendaraan
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';

echo "<h2>Include Test</h2>";
if (isset($conn)) {
    echo '<p><strong>$conn is set</strong></p>';
    if ($conn === false) {
        echo '<p style="color:red"><strong>$conn === false (koneksi gagal)</strong></p>';
    } else {
        echo '<p style="color:green"><strong>Connection OK</strong></p>';
        echo '<pre>' . htmlspecialchars(print_r(mysqli_get_server_info($conn), true)) . '</pre>';
    }
} else {
    echo '<p style="color:red"><strong>$conn is NOT set</strong></p>';
}

echo '<p><a href="../index.php">Back</a></p>';
?>