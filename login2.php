<?php
session_start();
$isLoggedIn = isset($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakul Rezeki</title>
    <link rel="shortcut icon" href="logouitm.png" type="image/svg+xml">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Ensure body stacks elements properly */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('image/bg.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        /* Pushes footer down */
        .content-wrapper {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Container Styling */
        .container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.6);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
            max-width: 500px; 
            width: 100%;
        }

        .container img {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
        }

        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .container button {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: black;
            color: white;
            cursor: pointer;
        }

        .container button:hover {
            background-color: #444;
        }

        /* Footer Styling */
        footer {
            background-color: #222;
            color: white;
            text-align: center;
            padding: 15px;
            width: 100%;
        }

        .footer-content {
            max-width: 1200px;
            margin: auto;
        }

        .social-icons a {
            color: white;
            margin: 0 10px;
            font-size: 20px;
            text-decoration: none;
        }

    </style>
</head>
<body>

<header>
    <div class="logo-container">
        <img src="image/logo.jpeg" alt="Logo">
        <h2 class="logo">Bakul Rezeki</h2>
    </div>
    <nav style="text-align: left;">
        <a href="website.php" style="color: white; text-decoration: none; font-size: 18px; font-weight: bold; margin-left: 900px;">
            Home
        </a>
    </nav>
    <div>
        <input type="checkbox" class="checkbox" id="checkbox">
        <label for="checkbox" class="checkbox-label">
            <i class="gg-moon"></i>
            <i class="fa fa-sun-o" style="font-size:20px"></i>
            <span class="ball"></span>
        </label>
    </div>
</header>


<!-- Wrap main content in a div to push the footer down -->
<div class="content-wrapper">
    <div class="container">
        <img src="image/uitmpundana.jpg" alt="Illustration Image">
        <h1>Welcome to Bakul Rezeki System</h1>
        <button onclick="redirectToLogin('donator')">Donator</button>
        <button onclick="redirectToLogin('book')">Book</button>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="footer-content">
        <p>&copy; COPYRIGHT UNIVERSITI TEKNOLOGI MARA 2025. All rights reserved.</p>
        <div class="social-icons">
            <a href="https://www.instagram.com/uitm.official/"><i class="fab fa-instagram"></i></a>
            <a href="https://www.facebook.com/uitmrasmi/"><i class="fab fa-facebook-square"></i></a>
        </div>
    </div>
</footer>

<script>
    function redirectToLogin(loginType) {
        if (loginType === 'donator') {
            window.location.href = 'donator.php';
        } else if (loginType === 'book') {
            window.location.href = 'book.php';
        }
    }
</script>

</body>
</html>
