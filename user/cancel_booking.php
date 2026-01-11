<?php
session_start();
require_once("../config/db.php");

if (!isset($_GET['id'])) {
    die("Invalid booking request.");
}

$booking_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Delete only if the booking belongs to the logged-in user
$stmt = $conn->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $booking_id, $user_id);

if ($stmt->execute()) {
    header("Location: my_bookings.php?msg=Booking cancelled successfully");
    exit;
} else {
    echo "Failed to cancel booking.";
}
?>
