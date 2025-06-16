<?php
$servername = "localhost";
$username = "root";  // Sửa theo username MySQL của bạn
$password = "";      // Sửa theo password MySQL của bạn
$dbname = "Test1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>
