<?php
$conn = mysqli_connect("localhost", "root", "", "sewa_kendaraan");

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
