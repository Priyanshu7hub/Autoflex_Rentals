<?php
session_start();
require_once(__DIR__ . '/../includes/config.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Handle booking status update
if (isset($_POST['update_status'])) {
    $booking_id = intval($_POST['booking_id']);
    $new_status = $_POST['status'];
    $conn->query("UPDATE bookings SET status='$new_status' WHERE id=$booking_id");
    $success = "✅ Booking status updated successfully!";
}

// Fetch all bookings
$query = "
    SELECT b.*, 
           u.name AS user_name, 
           u.email AS user_email,
           c.car_name, 
           c.model
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN cars c ON b.car_id = c.id
    ORDER BY b.id DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings | Admin Panel</title>
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

        /* Main content */
        .main-content {
            margin-left: 240px;
            flex-grow: 1;
            padding: 30px;
        }

        header {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .message {
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 15px;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        th {
            background: #007bff;
            color: white;
        }

        tr:hover {
            background: #f1f5ff;
        }

        select {
            padding: 6px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #0056b3;
        }

        .status {
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 13px;
            color: white;
            font-weight: 500;
        }

        .booked { background: #007bff; }
        .completed { background: #28a745; }
        .cancelled { background: #dc3545; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="dashboard.php">📊 Dashboard</a>
    <a href="manage_cars.php">🚗 Manage Cars</a>
    <a href="view_bookings.php" class="active">📘 View Bookings</a>
    <a href="../auth/logout.php">🚪 Logout</a>
</div>

<div class="main-content">
    <header>
        <h1>All Bookings 📘</h1>
        <a href="../auth/logout.php" class="logout">Logout</a>
    </header>

    <?php if (!empty($success)) echo "<div class='message success'>$success</div>"; ?>

    <table>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Email</th>
            <th>Car</th>
            <th>Model</th>
            <th>Start</th>
            <th>End</th>
            <th>Total (₹)</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
            <td><?php echo htmlspecialchars($row['user_email']); ?></td>
            <td><?php echo htmlspecialchars($row['car_name']); ?></td>
            <td><?php echo $row['model']; ?></td>
            <td><?php echo $row['start_date']; ?></td>
            <td><?php echo $row['end_date']; ?></td>
            <td><?php echo number_format($row['total_amount'], 2); ?></td>
            <td>
                <span class="status <?php echo strtolower($row['status']); ?>">
                    <?php echo ucfirst($row['status']); ?>
                </span>
            </td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                    <select name="status">
                        <option value="booked" <?php if($row['status']=='booked') echo 'selected'; ?>>Booked</option>
                        <option value="completed" <?php if($row['status']=='completed') echo 'selected'; ?>>Completed</option>
                        <option value="cancelled" <?php if($row['status']=='cancelled') echo 'selected'; ?>>Cancelled</option>
                    </select>
                    <button type="submit" name="update_status">Update</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
