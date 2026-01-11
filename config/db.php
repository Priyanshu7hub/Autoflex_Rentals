<?php
// config/db.php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "car_rental";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}
?>
