<?php
session_start();
include(__DIR__ . '/../includes/config.php');

$error = "";

// Check login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Fetch user from DB
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../user/dashboard.php");
            }
            exit();
        } else {
            $error = "❌ Invalid password!";
        }
    } else {
        $error = "❌ No account found with that email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | AutoFlex Rentals</title>
  <link rel="stylesheet" href="../assets/style.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #001f3f, #007bff, #00d4ff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .auth-container {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 40px;
      width: 370px;
      text-align: center;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
      color: white;
    }
    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 8px;
      border: none;
      background: rgba(255,255,255,0.2);
      color: white;
    }
    button {
      background: linear-gradient(135deg, #00d4ff, #007bff);
      border: none;
      padding: 12px;
      border-radius: 10px;
      color: white;
      font-size: 16px;
      cursor: pointer;
      width: 100%;
      margin-top: 10px;
    }
    button:hover {
      background: linear-gradient(135deg, #0095ff, #00c2ff);
    }
    .error {
      color: #ff6b6b;
      font-size: 14px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <div class="auth-container">
    <h2>Welcome Back 👋</h2>

    <?php if (!empty($error)) { ?>
      <p class="error"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST" action="">
      <input type="email" name="email" placeholder="Enter your email" required>
      <input type="password" name="password" placeholder="Enter your password" required>
      <button type="submit">Login</button>
    </form>

    <p style="margin-top:15px;">Don’t have an account? <a href="register.php" style="color:#00d4ff;">Register here</a></p>
  </div>

</body>
</html>
