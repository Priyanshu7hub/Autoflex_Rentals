<?php
require_once(__DIR__ . '/includes/config.php');

// Admin credentials
$name = "Admin";
$email = "admin@freedo.com";
$password = password_hash("admin123", PASSWORD_DEFAULT); // hashed automatically
$role = "admin";

// Delete old admin if exists
$conn->query("DELETE FROM users WHERE email = '$email'");

// Insert new admin
$stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $password, $role);

if ($stmt->execute()) {
    echo "✅ Admin created successfully.<br>";
    echo "Email: admin@freedo.com<br>";
    echo "Password: admin123<br>";
} else {
    echo "❌ Error: " . $conn->error;
}
?>
