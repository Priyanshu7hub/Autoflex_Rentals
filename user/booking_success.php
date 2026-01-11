<?php
if (!isset($_GET['car']) || !isset($_GET['total'])) {
    die("Invalid access.");
}

$car = htmlspecialchars($_GET['car']);
$total = htmlspecialchars($_GET['total']);
$start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : "N/A";
$end   = isset($_GET['end']) ? htmlspecialchars($_GET['end']) : "N/A";
$image = isset($_GET['img']) ? "../" . htmlspecialchars($_GET['img']) : "../uploads/default_car.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking Successful | AutoFlex Rentals</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #74ebd5, #9face6);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .success-card {
        width: 80%;
        max-width: 700px;
        background: #fff;
        padding: 35px;
        border-radius: 18px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.25);
        text-align: center;
        animation: popin 0.6s ease;
    }

    @keyframes popin {
        0% { transform: scale(0.85); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }

    .checkmark {
        font-size: 60px;
        color: #00c853;
        margin-bottom: 15px;
    }

    .success-card h2 {
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #222;
    }

    .car-img {
        width: 70%;
        max-height: 250px;
        object-fit: contain;
        border-radius: 10px;
        margin: 20px auto;
        display: block;
    }

    .info-box {
        background: #f4f7ff;
        padding: 15px;
        border-radius: 12px;
        text-align: left;
        margin-top: 15px;
    }

    .info-box p {
        font-size: 16px;
        margin: 6px 0;
    }

    .btn {
        display: block;
        width: 100%;
        padding: 14px;
        background: #007bff;
        color: #fff;
        border-radius: 10px;
        font-size: 17px;
        margin-top: 20px;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn:hover {
        background: #005ecb;
    }

    .secondary {
        background: #00c853;
    }

    .secondary:hover {
        background: #009b3a;
    }
</style>

</head>
<body>

<div class="success-card">

    <div class="checkmark">✅</div>

    <h2>Booking Successful!</h2>
    <p style="color:#444;">Your ride has been reserved successfully.</p>

    <img src="<?= $image ?>" class="car-img" alt="Car">

    <div class="info-box">
        <p><strong>Car:</strong> <?= $car ?></p>
        <p><strong>Start Date:</strong> <?= $start ?></p>
        <p><strong>End Date:</strong> <?= $end ?></p>
        <p><strong>Total Amount:</strong> ₹<?= number_format($total) ?></p>
    </div>

    <a href="dashboard.php" class="btn">Go to Dashboard</a>
    <a href="my_bookings.php" class="btn secondary">View My Bookings</a>

</div>

</body>
</html>
