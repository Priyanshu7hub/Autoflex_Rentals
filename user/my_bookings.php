<?php
session_start();
require_once("../config/db.php");

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch bookings
$query = $conn->prepare("
    SELECT bookings.*, cars.car_name, cars.model, cars.image 
    FROM bookings 
    JOIN cars ON bookings.car_id = cars.id 
    WHERE bookings.user_id = ?
    ORDER BY bookings.id DESC
");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Bookings | AutoFlex Rentals</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f7f9fc;
        margin: 0;
        padding: 0;
    }

    header {
        display: flex;
        justify-content: space-between;
        padding: 18px 40px;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        font-size: 18px;
        font-weight: 600;
    }

    header a {
        text-decoration: none;
        color: #007bff;
        font-weight: 500;
    }

    .container {
        width: 90%;
        max-width: 1100px;
        margin: auto;
        margin-top: 40px;
    }

    .card {
        background: white;
        padding: 30px;
        border-radius: 18px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        margin-bottom: 40px;
        text-align: center;
    }

    .card img {
        width: 300px;
        height: 180px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    h2 {
        margin: 10px 0;
        font-size: 22px;
        font-weight: 600;
    }

    .detail {
        font-size: 16px;
        color: #555;
        margin: 4px 0;
    }

    .status-btn {
        padding: 10px 28px;
        background: #28a745;
        color: white;
        border-radius: 25px;
        display: inline-block;
        margin-top: 10px;
        font-weight: 500;
    }

    .cancel-btn {
        padding: 10px 28px;
        background: #ff4d4d;
        color: white;
        border-radius: 25px;
        display: inline-block;
        margin-top: 15px;
        text-decoration: none;
        font-weight: 500;
    }

    footer {
        text-align: center;
        padding: 20px;
        color: #777;
        margin-top: 40px;
    }
</style>

</head>
<body>

<header>
    <div>🚗 My Bookings</div>
    <a href="dashboard.php">← Back to Dashboard</a>
</header>

<div class="container">













<?php if (isset($_GET['msg'])): ?>
    <p style="color: green; text-align: center; font-weight: 600;"><?= htmlspecialchars($_GET['msg']); ?></p>
<?php endif; ?>

<?php if ($result->num_rows > 0): ?>
    
    <?php while ($row = $result->fetch_assoc()): ?>
    
        <div class="card">

            <?php 
                $imagePath = "../" . $row['image'];
                if (!file_exists($imagePath)) {
                    $imagePath = "../uploads/placeholder.jpg";
                }
            ?>

            <img src="<?= $imagePath ?>" alt="<?= $row['car_name'] ?>">

            <h2><?= $row['car_name'] ?></h2>

            <p class="detail">Model: <?= $row['model'] ?></p>
            <p class="detail">Start: <?= $row['start_date'] ?></p>
            <p class="detail">End: <?= $row['end_date'] ?></p>
            <p class="detail">Total: ₹<?= number_format($row['total_amount']) ?></p>

            <div class="status-btn">Booked</div>

            <a href="cancel_booking.php?id=<?= $row['id'] ?>" 
               class="cancel-btn"
               onclick="return confirm('Are you sure you want to cancel this booking?');">
               Cancel Booking
            </a>

        </div>

    <?php endwhile; ?>

<?php else: ?>
    <p style="text-align:center; font-size:18px; color:#777;">You have no bookings yet.</p>
<?php endif; ?>

</div>

<footer>
    © <?= date("Y") ?> AutoFlex Rentals | Drive Your Freedom
</footer>

</body>
</html>
