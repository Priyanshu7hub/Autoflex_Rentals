<?php
$servername = "localhost";
$username = "root";     // default XAMPP user
$password = "";         // default is empty
$dbname = "car_rental"; // your database name

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
