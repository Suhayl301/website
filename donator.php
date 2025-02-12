<?php
session_start();
$isLoggedIn = isset($_SESSION['id']);

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "gerobok";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = $success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donator_id = $_POST['Donator_Id'] ?? '';
    $donator_name = $_POST['Donator_Name'] ?? '';
    $donator_quantity = $_POST['Donator_Quantity'] ?? '';
    $donator_type = $_POST['Donator_Type'] ?? '';
    $donator_time = $_POST['Donator_Time'] ?? '';
    $donator_phone = $_POST['Donator_Phone'] ?? '';

    if (empty($donator_id) || empty($donator_name) || empty($donator_quantity) || empty($donator_type) || empty($donator_time) || empty($donator_phone)) {
        $error_message = "All fields are required!";
    } else {
        $sql = "INSERT INTO donator (Donator_Id, Donator_Name, Donator_Quantity, Donator_Type, Donator_Time, Donator_Phone)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Error in SQL query: " . $conn->error);
        }

        $stmt->bind_param("ssisss", $donator_id, $donator_name, $donator_quantity, $donator_type, $donator_time, $donator_phone);

        if ($stmt->execute()) {
            $_SESSION['donator_details'] = $_POST;
            $success_message = "Donator details saved successfully!";
            header("Location: receipt.php");
            exit();
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerobok Rezeki</title>
    <link rel="shortcut icon" href="logouitm.png" type="image/svg+xml">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;
        background: url('image/bg.jpg') no-repeat center center fixed;
        background-size: cover;
    }

    .content-wrapper {
    flex-grow: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 80px; /* Space from navigation */
    margin-bottom: 80px; /* Space between container and footer */
}


    .container {
        background-color: black; /* Changed container background to black */
        color: white; /* Changed text color to white for better contrast */
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        max-width: 500px;
        width: 100%;
        text-align: center;
    }

    .container h2 {
        font-size: 22px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .container input,
    .container select {
        width: calc(100% - 20px);
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .container button {
        width: 98%;
        padding: 12px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        background-color: white;
        color: black;
        cursor: pointer;
        margin-top: 10px;
    }

    .container button:hover {
        background-color: gray;
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
        <a href="login2.php" style="color: white; text-decoration: none; font-size: 18px; font-weight: bold; margin-left: 900px;">
            Return
        </a>
    </nav>

        <div>
            <input type="checkbox" class="checkbox" id="checkbox">
            <label for="checkbox" class="checkbox-label">
                <i class="gg-moon"></i>
                <i class="fa fa-sun-o"></i>
                <span class="ball"></span>
            </label>
        </div>
    </div>
</header>

<!-- Wrap main content in a div to push the footer down -->
<div class="content-wrapper">
    <div class="container">
        <h2>Donator Details</h2>

        <?php if (!empty($error_message)) { ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php } ?>

        <?php if (!empty($success_message)) { ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php } ?>

        <form action="donator.php" method="POST">
            <input type="text" name="Donator_Id" placeholder="Donator ID" required>
            <input type="text" name="Donator_Name" placeholder="Donator Name" required>

            <select name="Donator_Type" required>
                <option value="" disabled selected>Select Donator Type</option>
                <option value="nasi">Nasi Lemak</option>
                <option value="bihun">Bihun Goreng</option>
            </select>

            <input type="number" name="Donator_Quantity" placeholder="Quantity" required min="1" max="100">
            <input type="datetime-local" name="Donator_Time" required>
            <input type="tel" name="Donator_Phone" placeholder="Phone Number" required pattern="[0-9()+ -]{8,20}">

            <button type="submit">Submit</button>
        </form>
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

<script src="java/checkbox.js"></script>
</body>
</html>