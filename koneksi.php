<?php
$host = "localhost"; // Host server database
$username = "root";  // Username database
$password = "";      // Password database
$database = "webdiary"; // Nama database

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
?>
