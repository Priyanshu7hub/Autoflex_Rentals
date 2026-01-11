<?php
session_start();
require_once("../config/db.php");

// Only admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Fetch cars
$cars = $conn->query("SELECT * FROM cars");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Cars | AutoFlex Rentals</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

    body {
        background: #f5f7fb;
        display: flex;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        height: 100vh;
        background: #007bff;
        padding: 25px;
        color: white;
        position: fixed;
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 22px;
    }

    .menu a {
        display: block;
        padding: 12px 15px;
        background: rgba(255,255,255,0.15);
        margin-bottom: 10px;
        border-radius: 8px;
        text-decoration: none;
        color: white;
        transition: 0.3s;
    }

    .menu a:hover {
        background: rgba(255,255,255,0.30);
    }

    /* Main content */
    .main {
        margin-left: 260px;
        padding: 30px;
        width: calc(100% - 260px);
    }

    table {
        width: 100%;
        background: white;
        border-collapse: collapse;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
    }

    th {
        background: #007bff;
        color: white;
        padding: 12px;
        font-size: 15px;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        text-align: center;
    }

    tr:hover {
        background: #f1f5ff;
    }

    .btn-edit {
        background: #28a745;
        color: white;
        padding: 6px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
        padding: 6px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
    }

    img {
        width: 80px;
        height: 55px;
        object-fit: cover;
        border-radius: 5px;
    }
</style>

</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Admin Panel</h2>

    <div class="menu">
        <a href="dashboard.php">📊 Dashboard</a>
        <a href="manage_cars.php">🚗 Manage Cars</a>
        <a href="view_bookings.php">📄 View Bookings</a>
        <a href="../auth/logout.php">🔒 Logout</a>
    </div>
</div>

<!-- Main Content -->
<div class="main">

    <h2 style="margin-bottom: 20px;">All Cars</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Car Name</th>
            <th>Model</th>
            <th>Price (₹/day)</th>
            <th>Image</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php while ($car = $cars->fetch_assoc()): ?>

        <?php
            // IMAGE PATH FIX
            $img = $car['image'];

            if (strpos($img, "uploads/") === 0) {
                $img = "../" . $img;
            } elseif (!str_contains($img, "/")) {
                $img = "../uploads/" . $img;
            } elseif (strpos($img, "../") !== 0) {
                $img = "../" . $img;
            }

            // fallback if missing
            if (!file_exists($img)) {
                $img = "../uploads/placeholder.jpg";
            }
        ?>

        <tr>
            <td><?= $car['id'] ?></td>
            <td><?= $car['car_name'] ?></td>
            <td><?= $car['model'] ?></td>
            <td><?= $car['price_per_day'] ?></td>
            <td><img src="<?= $img ?>" alt=""></td>
            <td><?= $car['availability'] ?></td>

            <td>
                <a class="btn-edit" href="edit_car.php?id=<?= $car['id'] ?>">Edit</a>
                <a class="btn-delete" href="delete_car.php?id=<?= $car['id'] ?>">Delete</a>
            </td>
        </tr>

        <?php endwhile; ?>
    </table>

</div>

</body>
</html>
