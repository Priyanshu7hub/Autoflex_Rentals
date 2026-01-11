<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AutoFlex Rentals | Drive Your Freedom</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
  body { background: #fff; color: #222; scroll-behavior: smooth; }

  /* Navbar */
  nav {
    width: 100%;
    background: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    padding: 18px 70px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 1000;
  }
  .logo { font-size: 22px; font-weight: 600; color: #007bff; display: flex; align-items: center; gap: 8px; }
  .logo img { width: 28px; }
  ul { display: flex; gap: 30px; list-style: none; }
  ul li a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    transition: 0.3s;
  }
  ul li a:hover { color: #007bff; }

  .btn {
    background: #007bff;
    color: #fff;
    padding: 8px 18px;
    border-radius: 6px;
    text-decoration: none;
    transition: 0.3s;
  }
  .btn:hover { background: #0056b3; }

  /* Hero Section */
  .hero {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 80px 100px;
    background: linear-gradient(180deg, #f5f9ff 0%, #eaf4ff 100%);
    flex-wrap: wrap;
  }
  .hero-text {
    max-width: 50%;
  }
  .hero-text h1 {
    font-size: 42px;
    color: #111;
  }
  .hero-text span {
    color: #007bff;
  }
  .hero-text p {
    color: #555;
    font-size: 15px;
    margin: 20px 0;
    line-height: 1.6;
  }

  .search-bar {
    background: #fff;
    padding: 12px;
    border-radius: 50px;
    display: flex;
    gap: 15px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.05);
    margin-top: 30px;
  }

  .search-bar input {
    border: none;
    outline: none;
    padding: 10px 18px;
    border-radius: 50px;
    flex: 1;
    font-size: 15px;
    background: #f3f6fb;
  }

  .search-bar button {
    background: #007bff;
    border: none;
    color: #fff;
    padding: 10px 25px;
    border-radius: 50px;
    cursor: pointer;
    font-weight: 500;
    transition: 0.3s;
  }

  .search-bar button:hover {
    background: #0056b3;
  }

  .hero img {
    width: 480px;
    height: auto;
    animation: float 3s ease-in-out infinite;
  }

  @keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
  }

  /* Sections */
  section {
    padding: 80px 100px;
  }

  .section-title {
    text-align: center;
    font-size: 30px;
    color: #111;
    margin-bottom: 50px;
    font-weight: 600;
  }

  .features {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
  }

  .feature-box {
    width: 280px;
    background: #f8fbff;
    padding: 30px;
    border-radius: 16px;
    text-align: center;
    transition: 0.3s;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
  }

  .feature-box:hover {
    transform: translateY(-5px);
  }

  .feature-box h3 {
    color: #007bff;
    margin: 15px 0;
  }

  /* Cars Section */
  .cars {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
  }

  .car-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    text-align: center;
    padding: 20px;
    transition: 0.3s;
  }

  .car-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
  }

  .car-card:hover {
    transform: scale(1.03);
  }

  /* Contact Section */
  .contact {
    text-align: center;
  }

  .contact p { margin: 10px 0; color: #555; }

  footer {
    background: #f3f6fb;
    padding: 30px;
    text-align: center;
    color: #555;
    margin-top: 60px;
  }

  /* Responsive */
  @media(max-width: 768px) {
    nav { padding: 15px 25px; flex-direction: column; gap: 10px; }
    .hero { flex-direction: column; text-align: center; padding: 60px 20px; }
    .hero-text { max-width: 100%; }
    .hero img { width: 100%; margin-top: 30px; }
  }
</style>
</head>
<body>

<!-- 🌐 Navbar -->
<nav>
  <div class="logo">🚗 AutoFlex Rentals</div>
  <ul>
    <li><a href="#home">Home</a></li>
    <li><a href="#about">About</a></li>
    <li><a href="#cars">Cars</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
  <a href="auth/login.php" class="btn">Sign In</a>
</nav>

<!-- 🏠 Hero Section -->
<section id="home" class="hero">
  <div class="hero-text">
    <h1>Best Car Rentals in <span>India</span></h1>
    <p>Book safe, affordable, and reliable rides anytime. Drive the freedom you deserve with our modern fleet.</p>

    <!-- ✅ Functional Search Form -->
    <form class="search-bar" method="GET" action="user/dashboard.php">
      <input type="text" name="search" placeholder="Enter City or Car Name" required>
      <button type="submit">Search</button>
    </form>

  </div>
  <img src="assets/hero-car.jpeg" alt="Car">
</section>

<!-- 💡 About Section -->
<section id="about">
  <h2 class="section-title">Why Choose AutoFlex Rentals?</h2>
  <div class="features">
    <div class="feature-box">
      <img src="https://cdn-icons-png.flaticon.com/512/942/942790.png" width="60">
      <h3>Trusted Service</h3>
      <p>Authorized and reliable vehicle rental services across India.</p>
    </div>
    <div class="feature-box">
      <img src="https://cdn-icons-png.flaticon.com/512/3208/3208726.png" width="60">
      <h3>Wide Range</h3>
      <p>Choose from economy cars to premium SUVs – we have it all.</p>
    </div>
    <div class="feature-box">
      <img src="https://cdn-icons-png.flaticon.com/512/1161/1161388.png" width="60">
      <h3>Affordable Pricing</h3>
      <p>Transparent pricing, no hidden fees. Pay only for what you drive.</p>
    </div>
  </div>
</section>

<!-- 🚗 Cars Section -->
<section id="cars">
  <h2 class="section-title">Our Popular Cars</h2>
  <div class="cars">
    <div class="car-card">
      <img src="uploads/i20.jpeg" alt="Hyundai i20">
      <h3>Hyundai i20</h3>
      <p>₹2,500 / day</p>
    </div>
    <div class="car-card">
      <img src="uploads/nexon.jpeg" alt="Tata Nexon">
      <h3>Tata Nexon</h3>
      <p>₹3,200 / day</p>
    </div>
    <div class="car-card">
      <img src="uploads/xuv700.jpeg" alt="Mahindra XUV700">
      <h3>Mahindra XUV700</h3>
      <p>₹4,500 / day</p>
    </div>
  </div>
</section>

<!-- 📞 Contact Section -->
<section id="contact" class="contact">
  <h2 class="section-title">Contact Us</h2>
  <p>📍 GLA University, Mathura, India</p>
  <p>📞 +91 98765 43210</p>
  <p>📧 support@autoflexrentals.com</p>
</section>

<footer>
  © <?php echo date("Y"); ?> AutoFlex Rentals | Drive Your Freedom
</footer>

</body>
</html>
