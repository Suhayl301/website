<?php
session_start(); // Start session to retrieve data

// Check if session data is available
if (!isset($_SESSION['donator_details'])) {
    die("No receipt details found. Please submit the donation form first.");
}

$donator = $_SESSION['donator_details']; // Retrieve session data

// You can unset the session data if you don't need it after displaying the receipt
unset($_SESSION['donator_details']);

// Connect to the database again to retrieve all donations by the same Donator_Id
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "gerobok";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all donations by the Donator_Id
$donator_id = $donator['Donator_Id'];
$sql = "SELECT * FROM donator WHERE donator_id = ? ORDER BY donator_time DESC"; // Ordering by time, newest first

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $donator_id);
$stmt->execute();
$result = $stmt->get_result();
$donations = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Bakul Rezeki</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: sans-serif;
            background: url('image/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .invoice-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .invoice-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .donation-item {
            margin-bottom: 20px;
        }

        .invoice-footer {
            margin-top: 30px;
            font-size: 16px;
            color: #777;
        }

        .next-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: black;
            border: 2px solid white;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .next-button:hover {
            background-color: white;
            color: black;
            border: 2px solid black;
        }
    </style>
</head>
<body>

<div class="invoice-container">
    <div class="invoice-header">
        Receipts for Donations - Bakul Rezeki
    </div>

    <?php foreach ($donations as $donation) { ?>
        <div class="donation-item">
            <p><strong>Donator ID:</strong> <?php echo htmlspecialchars($donation['donator_id']); ?></p>
            <p><strong>Donator Name:</strong> <?php echo htmlspecialchars($donation['donator_name']); ?></p>
            <p><strong>Type:</strong> <?php echo ucfirst(htmlspecialchars($donation['donator_type'])); ?></p>
            <p><strong>Quantity:</strong> <?php echo htmlspecialchars($donation['donator_quantity']); ?></p>
            <p><strong>Time of Donation:</strong> <?php echo date("d-m-Y H:i", strtotime($donation['donator_time'])); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($donation['donator_phone']); ?></p>
            <hr>
        </div>
    <?php } ?>

    <a href="result.php" class="next-button">Next</a>
</div>

</body>
</html>
