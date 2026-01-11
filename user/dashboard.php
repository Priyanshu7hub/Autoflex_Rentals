<?php
session_start();
require_once("../config/db.php");

// Fetch filters from GET
$search = isset($_GET['search']) ? $_GET['search'] : '';
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

// Build SQL query dynamically
$sql = "SELECT * FROM cars WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND car_name LIKE '%$search%'";
}

if (!empty($brand) && $brand !== "All") {
    $sql .= " AND brand='$brand'";
}

if (!empty($type) && $type !== "All") {
    $sql .= " AND vehicle_type='$type'";
}

if ($sort === "low") {
    $sql .= " ORDER BY price_per_day ASC";
} elseif ($sort === "high") {
    $sql .= " ORDER BY price_per_day DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Available Vehicles | AutoFlex Rentals</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
/* ------------------------- THEME VARIABLES ---------------------- */
:root {
    --bg: #f6f8ff;
    --card: #ffffff;
    --text: #222;
    --subtext: #666;
    --header-bg: #ffffff;
    --border: #e5e5e5;
}

body.dark {
    --bg: #0f0f0f;
    --card: #1a1a1a;
    --text: #f2f2f2;
    --subtext: #bdbdbd;
    --header-bg: #111;
    --border: #333;
}

/* ------------------------- GLOBAL STYLING ---------------------- */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Poppins, sans-serif;
}

body {
    background: var(--bg);
    transition: 0.25s;
}

header {
    display: flex;
    justify-content: space-between;
    padding: 20px 40px;
    background: var(--header-bg);
    border-bottom: 1px solid var(--border);
}

header h2 {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--text);
    font-weight: 600;
}

header a {
    color: #007bff;
    text-decoration: none;
    margin-left: 20px;
    font-weight: 500;
}

.theme-btn {
    background: #007bff;
    padding: 10px 18px;
    border-radius: 8px;
    color: white;
    border: none;
    cursor: pointer;
    margin-right: 20px;
    font-weight: 500;
}

.theme-btn:hover {
    background: #005bd1;
}

/* ------------------------- FILTER SIDEBAR ---------------------- */
.sidebar {
    width: 250px;
    background: var(--card);
    border-radius: 12px;
    padding: 20px;
    height: fit-content;
    border: 1px solid var(--border);
}

.sidebar h3 {
    margin-bottom: 15px;
    color: var(--text);
}

.sidebar label {
    font-weight: 500;
    font-size: 14px;
    color: var(--text);
}

.sidebar select {
    width: 100%;
    padding: 10px;
    margin: 8px 0 15px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: var(--header-bg);
    color: var(--text);
}

/* ------------------------- SEARCH & SORT ---------------------- */
.top-controls {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
}

.top-controls input,
.top-controls select {
    padding: 12px;
    border-radius: 10px;
    border: 1px solid var(--border);
    width: 330px;
    background: var(--card);
    color: var(--text);
}

.top-controls button {
    background: #007bff;
    padding: 12px 25px;
    border-radius: 10px;
    border: none;
    color: #fff;
    cursor: pointer;
}

.top-controls button:hover {
    background: #005bc8;
}

/* ------------------------- CONTAINER GRID ---------------------- */
.container {
    display: flex;
    padding: 30px 40px;
    gap: 35px;
}

.grid {
    flex: 1;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
}

/* ------------------------- CAR CARD ---------------------- */
.card {
    background: var(--card);
    padding: 15px;
    border-radius: 14px;
    border: 1px solid var(--border);
    text-align: center;
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

.card img {
    width: 100%;
    height: 170px;
    object-fit: cover;
    border-radius: 12px;
}

.card .year {
    color: #007bff;
    margin-top: 10px;
    font-weight: 600;
}

.card h3 {
    color: var(--text);
    margin: 5px 0;
}

.card .price {
    color: var(--subtext);
}

.card button {
    margin-top: 12px;
    padding: 10px 20px;
    background: #007bff;
    border: none;
    color: white;
    border-radius: 30px;
    cursor: pointer;
}

.card button:hover {
    background: #0060d1;
}
</style>
</head>

<body>

<header>
    <h2>🚗 Available Vehicles</h2>

    <div style="display:flex;align-items:center;">
        <button id="themeToggle" class="theme-btn">🌙 Dark Mode</button>
        <a href="my_bookings.php">My Bookings</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</header>

<div class="container">

    <!-- FILTER SIDEBAR -->
    <form class="sidebar" method="GET">
        <h3>Filters</h3>

        <label>Brand</label>
        <select name="brand">
            <option>All</option>
            <option>Tata</option>
            <option>Hyundai</option>
            <option>Mahindra</option>
        </select>

        <label>Vehicle Type</label>
        <select name="type">
            <option>All</option>
            <option>SUV</option>
            <option>Hatchback</option>
            <option>Sedan</option>
        </select>

        <button type="submit" style="margin-top:10px; width:100%; padding:10px;">Apply Filters</button>
    </form>

    <!-- MAIN CONTENT -->
    <div style="flex:1;">

        <form method="GET" class="top-controls">
            <input type="text" name="search" placeholder="Search by name...">
            <select name="sort">
                <option value="">Sort by Price</option>
                <option value="low">Low → High</option>
                <option value="high">High → Low</option>
            </select>
            <button type="submit">Search</button>
        </form>

        <!-- GRID -->
        <div class="grid">
            <?php while ($row = $result->fetch_assoc()): 
                $image = "../" . $row['image'];
            ?>
            <div class="card">
                <img src="<?= $image ?>" alt="" onerror="this.src='../uploads/placeholder.jpg'">
                <p class="year"><?= $row['model'] ?></p>
                <h3><?= $row['car_name'] ?></h3>
                <p class="price">₹<?= $row['price_per_day'] ?> / day</p>

                <a href="book_car.php?id=<?= $row['id'] ?>">
                    <button>Book Vehicle</button>
                </a>
            </div>
            <?php endwhile; ?>
        </div>

    </div>
</div>

<!-- DARK MODE SCRIPT -->
<script>
const toggle = document.getElementById('themeToggle');
const body = document.body;

if (localStorage.getItem("theme") === "dark") {
    body.classList.add("dark");
    toggle.textContent = "☀ Light Mode";
}

toggle.onclick = () => {
    body.classList.toggle("dark");

    if (body.classList.contains("dark")) {
        toggle.textContent = "☀ Light Mode";
        localStorage.setItem("theme", "dark");
    } else {
        toggle.textContent = "🌙 Dark Mode";
        localStorage.setItem("theme", "light");
    }
};
</script>

</body>
</html>
