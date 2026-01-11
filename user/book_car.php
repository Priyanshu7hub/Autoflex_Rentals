<?php
session_start();
require_once("../config/db.php");

// Validate Car ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<h2 style='color:red;text-align:center;'>Invalid car selection.</h2>");
}

$car_id = intval($_GET['id']);

// Fetch car details
$carQuery = $conn->prepare("SELECT * FROM cars WHERE id = ?");
$carQuery->bind_param("i", $car_id);
$carQuery->execute();
$carResult = $carQuery->get_result();

if ($carResult->num_rows === 0) {
    die("<h2 style='color:red;text-align:center;'>Car not found in database.</h2>");
}

$car = $carResult->fetch_assoc();

// Fix image path
$image_path = "../" . $car["image"];

if (!file_exists($image_path)) {
    $image_path = "../assets/default_car.png"; // fallback
}

// Booking form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (empty($start_date) || empty($end_date)) {
        $error = "Please select both dates.";
    } else {
        // Calculate total days
        $days = (strtotime($end_date) - strtotime($start_date)) / 86400;
        if ($days <= 0) {
            $error = "End date must be after start date.";
        } else {
            $total_price = $days * $car['price_per_day'];

            $insert = $conn->prepare("INSERT INTO bookings (user_id, car_id, start_date, end_date, total_amount) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("iissd", $_SESSION['user_id'], $car_id, $start_date, $end_date, $total_price);

            if ($insert->execute()) {
                header("Location: booking_success.php?car=" . urlencode($car['car_name']) . "&total=" . $total_price);
                exit;
            } else {
                $error = "Booking failed.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book <?= $car['car_name']; ?> | AutoFlex Rentals</title>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card {
        background: white;
        width: 70%;
        max-width: 900px;
        border-radius: 20px;
        padding: 30px;
        display: flex;
        gap: 30px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.2);
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(20px);}
        to {opacity: 1; transform: translateY(0);}
    }

    .left-img img {
        width: 330px;
        height: auto;
        border-radius: 15px;
        object-fit: cover;
    }

    .right-info {
        flex: 1;
    }

    .right-info h2 {
        margin: 0;
        font-size: 26px;
        font-weight: 700;
    }

    .spec-box {
        background: #f5f7ff;
        padding: 15px;
        border-radius: 12px;
        margin: 15px 0;
    }

    .spec-box p {
        margin: 8px 0;
        font-size: 16px;
    }

    input[type="date"] {
        width: 100%;
        padding: 12px;
        margin-top: 10px;
        margin-bottom: 15px;
        border-radius: 10px;
        border: 1px solid #ccc;
        font-size: 15px;
    }

    .btn {
        background: #007bff;
        padding: 15px;
        width: 100%;
        text-align: center;
        border-radius: 12px;
        color: white;
        font-size: 17px;
        cursor: pointer;
        border: none;
        margin-top: 10px;
    }

    .btn:hover {
        background: #005ecb;
    }

    .error {
        color: red;
        font-size: 15px;
        margin-bottom: 10px;
    }
</style>

</head>

<body>

<div class="card">
    
    <div class="left-img">
        <img src="<?= $image_path ?>" alt="<?= $car['car_name'] ?>">
    </div>

    <div class="right-info">
        <h2>Book: <?= $car['car_name'] ?></h2>

        <div class="spec-box">
            <p><strong>Brand:</strong> <?= $car['brand'] ?></p>
            <p><strong>Model Year:</strong> <?= $car['model'] ?></p>
            <p><strong>Engine CC:</strong> <?= $car['engine_cc'] ?></p>
            <p><strong>Mileage:</strong> <?= $car['mileage'] ?></p>
            <p><strong>Max Speed:</strong> <?= $car['max_speed'] ?></p>
            <p><strong>Price Per Day:</strong> ₹<?= $car['price_per_day'] ?></p>
        </div>

        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST">
            <label>Start Date:</label>
            <input type="date" name="start_date" required>

            <label>End Date:</label>
            <input type="date" name="end_date" required>

            <button class="btn" type="submit">Confirm Booking</button>
        </form>

    </div>

</div>

</body>
</html>
