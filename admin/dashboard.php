<?php
session_start();
require_once(__DIR__ . '/../includes/config.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Fetch quick stats
$totalCars = $conn->query("SELECT COUNT(*) AS total FROM cars")->fetch_assoc()['total'];
$totalBookings = $conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'];
$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Car Rental</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f4f6f8;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: #007bff;
            color: #fff;
            height: 100vh;
            padding: 20px;
            position: fixed;
        }

        .sidebar h2 {
            font-size: 22px;
            margin-bottom: 30px;
            text-align: center;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Main Content */
        .main-content {
            margin-left: 240px;
            flex-grow: 1;
            padding: 30px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }

        header h1 {
            color: #007bff;
            margin: 0;
        }

        .logout {
            background: #ff4757;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
        }

        .stats-container {
            display: flex;
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            flex: 1;
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            transition: transform 0.2s ease-in-out;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            margin: 10px 0 5px;
            color: #007bff;
        }

        .stat-card p {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .table-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #007bff;
            color: white;
        }

        tr:hover {
            background: #f1f5ff;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>AutoFlex Rentals Admin Dashboard</h2>
    <a href="dashboard.php" class="active">📊 Dashboard</a>
    <a href="manage_cars.php">🚗 Manage Cars</a>
    <a href="view_bookings.php">📘 View Bookings</a>
    <a href="../auth/logout.php">🚪 Logout</a>
</div>

<div class="main-content">
    <header>
        <h1>Welcome, Admin 👋</h1>
        <a href="../auth/logout.php" class="logout">Logout</a>
    </header>

    <div class="stats-container">
        <div class="stat-card">
            <h3>Total Cars</h3>
            <p><?php echo $totalCars; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Bookings</h3>
            <p><?php echo $totalBookings; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Users</h3>
            <p><?php echo $totalUsers; ?></p>
        </div>
    </div>

    <div class="table-container">
        <h2 style="color:#007bff;">Latest Cars</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Car Name</th>
                <th>Model</th>
                <th>Price (₹/day)</th>
                <th>Status</th>
            </tr>
            <?php
            $cars = $conn->query("SELECT * FROM cars ORDER BY id DESC LIMIT 5");
            while ($row = $cars->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['car_name']}</td>
                        <td>{$row['model']}</td>
                        <td>₹{$row['price_per_day']}</td>
                        <td>{$row['availability']}</td>
                    </tr>";
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>
