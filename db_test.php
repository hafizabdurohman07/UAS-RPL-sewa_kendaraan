<?php
// File: db_test.php
// Tes koneksi database dan info PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>DB Connection Test</h2>";

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'sewa_kendaraan';

echo '<p><strong>PHP Version:</strong> ' . phpversion() . '</p>';
echo '<p><strong>MySQLi extension loaded:</strong> ' . (extension_loaded('mysqli') ? 'Yes' : 'No') . '</p>';

$conn = @mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    echo '<p style="color:red;"><strong>Connection failed:</strong> ' . mysqli_connect_errno() . ' - ' . mysqli_connect_error() . '</p>';
} else {
    echo '<p style="color:green;"><strong>Connection OK</strong></p>';
    $res = mysqli_query($conn, "SHOW TABLES");
    echo '<p><strong>Tables in database:</strong></p>';
    echo '<ul>';
    while ($row = mysqli_fetch_row($res)) {
        echo '<li>' . htmlspecialchars($row[0]) . '</li>';
    }
    echo '</ul>';
    mysqli_close($conn);
}

echo '<hr>';
echo '<p>Open <a href="login.php">login.php</a> or <a href="index.php">index.php</a></p>';
?>