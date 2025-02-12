<?php
session_start(); // Start session to retrieve data

// Check if session data is available
if (!isset($_SESSION['book_details'])) {
    die("No receipt details found. Please submit the user booking form first.");
}

$book = $_SESSION['book_details']; // Retrieve session data

// You can unset the session data if you don't need it after displaying the receipt
unset($_SESSION['book_details']);

// Database connection
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "gerobok";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all bookings by the Book_Id
$book_id = $book['Book_Id']; // Use the Book_Id from session data
$sql = "SELECT * FROM book WHERE Book_Id = ? ORDER BY Book_Date DESC"; // Ordering by time, newest first

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $book_id); // Bind the actual Book_Id from session
$stmt->execute();
$result = $stmt->get_result();
$books = $result->fetch_all(MYSQLI_ASSOC); // Fetch all the rows into an associative array
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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
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

        .invoice-details {
            font-size: 18px;
            margin: 10px 0;
        }

        .invoice-footer {
            margin-top: 30px;
            font-size: 16px;
            color: #777;
        }

        .book-item {
            margin-bottom: 20px;
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
        Receipts for User Booking - Bakul Rezeki
    </div>

    <?php foreach ($books as $book) { ?>
        <div class="book-item">
            <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($book['book_id']); ?></p>
            <p><strong>Booking Name:</strong> <?php echo htmlspecialchars($book['book_name']); ?></p>
            <p><strong>Booking Type:</strong> <?php echo ucfirst(htmlspecialchars($book['book_type'])); ?></p>
            <p><strong>Quantity:</strong> <?php echo htmlspecialchars($book['book_quantity']); ?></p>
            <p><strong>Booking Date:</strong> <?php echo date("Y-m-d", strtotime($book['book_date'])); ?></p>
            <hr>
        </div>
    <?php } ?>

    <a href="result2.php" class="next-button">Next</a>
</div>

</body>
</html>