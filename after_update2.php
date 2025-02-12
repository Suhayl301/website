<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "gerobok";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET["message"]) && $_GET["message"] === "update_success") {
    $message = '<div class="message">Data has been updated. <a href="result2.php" class="btn">Back to User Booking</a></div>';
}

$conn->close();
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status</title>
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

        .status-container {
            background: rgba(0, 0, 0, 0.8);
            color: #FFFFFF;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            width: 400px;
            text-align: center;
        }

        .status-container .message {
            color: #3c763d;
            background: #dff0d8;
            padding: 10px;
            border: 1px solid #d6e9c6;
            border-radius: 4px;
        }

        .status-container .error {
            color: white;
            background: #fcfcfc;
            padding: 10px;
            border: 1px solid #ebccd1;
            border-radius: 4px;
        }

        .status-container a {
            display: block;
            margin-top: 20px;
            color: white;
            text-decoration: none;
            padding: 10px;
            background: #79733f;
            border-radius: 4px;
        }

        .status-container a:hover {
            background: #575d49;
        }
    </style>
</head>
<body>
    <div class="status-container">
        <h2>Update Status</h2>
        <p>The Data has Been Successfully Updated</p>
                        <a href="result2.php" class="btn">Back to Previous Page</a>
    </div>
</body>
</html>
