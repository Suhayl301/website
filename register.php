<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakul Rezeki</title>
    <link rel="shortcut icon" href="logouitm.png" type="image/svg+xml">
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/moon.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
<header>
<div class="logo-container">
        <img src="image/logo.jpeg" alt="Logo">
        <h2 class="logo">Bakul Rezeki</h2>
    </div>

    
        <div>
            <input type="checkbox" class="checkbox" id="checkbox">
            <label for="checkbox" class="checkbox-label">
                <i class="gg-moon"></i>
                <i class="fa fa-sun-o" style="font-size:20px"></i>
                <span class="ball"></span>
            </label>
        </div>
    </div>
</header>

<style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background: url('image/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        </style>

<section class="form">
    <div class="form-box">
        <h1 class="heading">Registration Form</h1>
        <form action="register.php" method="POST">
            <div class="input-box">
                <h3>User ID:</h3>
                <input type="text" name="login_id" id="login_id" required>
            </div>

            <div class="input-box">
                <h3>Password:</h3>
                <input type="password" name="login_pass" id="login_pass" required>
            </div>

            <input type="submit" name="submit" value="Register" class="submit-btn">
        </form>
    </div>
</section>

<footer>
      <div class="container">
        <div class="footer-content">
          <p>&copy; COPYRIGHT UNIVERSITI TEKNOLOGI MARA 2025. All rights reserved.</p>
          <div class="social-icons">
            <a href="https://www.instagram.com/uitm.official/"><i class="fab fa-instagram" aria-hidden="true"></i></i></a>
            <a href="https://www.facebook.com/uitmrasmi/"><i class="fab fa-facebook-square" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </footer>
    
    <script src="java/vanilla-tilt.min.js"></script>
    <script>
      VanillaTilt.init(document.querySelectorAll(".card"),{
        glare: true,
        reverse: true,
        "max-glare": 0.5
      });

      document.querySelector('.dropbtn').addEventListener('click', function() {
    document.querySelector('.dropdown-content').classList.toggle('show');
});
    </script>
    <script src="java/checkbox.js"></script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_id = $_POST["login_id"];
    $login_pass = $_POST["login_pass"];

    // Database connection
    $con = mysqli_connect("localhost", "root", "", "gerobok");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prevent SQL Injection
    $login_id = mysqli_real_escape_string($con, $login_id);
    $login_pass = mysqli_real_escape_string($con, $login_pass);

    // Check if User ID already exists
    $checkQuery = "SELECT * FROM login WHERE login_id = '$login_id'";
    $result = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('User ID already exists!'); window.location.href='register.php';</script>";
    } else {
        // Insert user into database
        $query = "INSERT INTO login (login_id, login_pass) VALUES ('$login_id', '$login_pass')";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }

    mysqli_close($con);
}
?>
