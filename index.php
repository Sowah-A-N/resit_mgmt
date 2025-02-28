<?php
session_start();

// Check if the user is already logged in, and redirect to dashboard if so
if (isset($_SESSION['user_id'])) {
   header("Location:index.php"); // Modify with the path to the dashboard
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resit Portal</title>
      <link rel="icon" href="RMU LOGO.jpg" type="image/jpeg">
    <link rel="stylesheet" href="style1.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Left Section (Image) -->
        <div class="image-section">
            <img src="RMU LOGO.jpg" alt="RMU Logo">
        </div>

        <!-- Right Section (Login Form) -->
        <div class="form-section">
            <div class="login-box">
                <div class="form-header">
                    <!-- Add logo image to the title section -->
                    <img src="RMU LOGO.jpg" alt="RMU Logo" class="title-logo">
                    <h1>RMU Resit Registration</h1>
                    <!--h1> Admin Login </h1-->
                </div>
                <form action="./formhandler.inc.php" method="post" id="loginForm">
                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Unique ID" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn-primary">Log In</button>
                </form>
                <a href="resitForm.php" class="forgot-password">Register New User</a>
            </div>
            <footer>
                <p>&copy; 2025 RMU Resit Portal All rights reserved.</p>
            </footer>
        </div>
    </div>
    <!-- Font Awesome for Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>