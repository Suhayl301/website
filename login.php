<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "gerobok"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $login_id = $_POST['username'];
        $login_pass = $_POST['password'];

        // Prepare and execute the SQL statement
        $sql_select = "SELECT * FROM login WHERE login_id = ?";
        $stmt_select = $conn->prepare($sql_select);
        $stmt_select->bind_param("s", $login_id);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();

        // Check if a matching record was found
        if ($result_select->num_rows == 1) {
            $row = $result_select->fetch_assoc();
            if ($row['login_pass'] == $login_pass) {
                // Successful login
                $_SESSION['login_id'] = $login_id;
                header("Location: login2.php?userID=" . urlencode($login_id));
                exit();
            } else {
                echo "<script>alert('Invalid password. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Invalid User ID. Please try again.');</script>";
        }

        // Close the statement
        $stmt_select->close();
    } else {
        echo "<script>alert('Login details not provided.');</script>";
    }
}

// Close the connection
$conn->close();
?>

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
    <style>
        /* Ensuring body and html cover the full height */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            font-family: sans-serif;
            background: url('image/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 0 20px;
        }

        /* Flex container for centering the content vertically */
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1; /* Makes sure content takes up the available space */
            padding-bottom: 20px; /* Adds space between container and footer */
        }

        .container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            margin-top: 80px; /* Adjust top margin if needed */
        }

        .container img {
            width: 300px;
            height: 300px;
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
            background-color: black;
        }

        .container p {
            font-size: 12px;
            color: #666;
            margin-top: 20px;
        }

        /* Footer styles */
        footer {
            background-color: #282828; /* Darker footer background for contrast */
            color: white;
            text-align: center;
            padding: 20px 0;
            width: 100%;
        }

        footer a {
            color: #ccc;
            text-decoration: none;
            margin: 0 10px;
        }

        footer a:hover {
            color: #fff;
        }
    </style>
</head>
<body>

<header>
    <div class="logo-container">
         <img src="image/logo.jpeg" alt="Logo"><a href="website.php">
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

<div class="main-content">
    <div class="container">
        <a href="website.php"><img src="image/uitmpundana.jpg" alt="Illustration Image"></a>
        <main class="login-container">
            <div class="login-box">
                <h1>Login</h1>
                <form method="POST" action="login.php">
                    <div class="input-box">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-box">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="login-btn">Login</button>
                    <div class="register-link">
                        <p>Don't have an account? <a href="register.php">Register</a></p>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>&copy;  COPYRIGHT UNIVERSITI TEKNOLOGI MARA 2025. All rights reserved.</p>
    <div class="social-icons">
        <a href="https://www.instagram.com/uitm.official/"><i class="fab fa-instagram" aria-hidden="true"></i></a>
        <a href="https://www.facebook.com/uitmrasmi/"><i class="fab fa-facebook-square" aria-hidden="true"></i></a>
    </div>
</footer>

<script src="java/checkbox.js"></script>
</body>
</html>