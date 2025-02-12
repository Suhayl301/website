<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $book_id = $_POST["book_id"];
    $book_name = $_POST["book_name"];
    $book_type = $_POST["book_type"];
    $book_quantity = $_POST["book_quantity"];
    $book_date = $_POST["book_date"]; 

    $sql = "UPDATE book SET  
            book_name=?, 
            book_quantity=?, 
            book_type=?, 
            book_date=? 
            WHERE book_id=?"; 

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisii", $book_name, $book_quantity, $book_type, $book_date, $book_id); 

    if ($stmt->execute()) {
        header("Location: after_update2.php?message=update_success");
        exit();
    } else {
        echo '<div class="error">Error updating record: ' . $stmt->error . '</div>';
    }

    $stmt->close();
} else {
    if (isset($_GET["book_id"])) {
        $book_id = $_GET["book_id"];

        $sql = "SELECT * FROM book WHERE book_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $book_id); // Perbaiki dari $donator_id ke $book_id
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Booking</title>
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
        .update-container {
            background: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            width: 400px;
        }
        .update-container h2 {
            color: #fcfcfc;
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        .update-container form {
            display: flex;
            flex-direction: column;
            color: white;
        }
        .update-container form input[type="text"],
        .update-container form input[type="number"],
        .update-container form input[type="date"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .update-container form input[type="submit"] {
            padding: 10px;
            background: #79733f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .update-container form input[type="submit"]:hover {
            background: #575d49;
        }
        .update-container .error {
            margin-top: 10px;
            padding: 10px;
            background: #fcfcfc;
            border: 1px solid #ebccd1;
            color: white;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="update-container">
        <h2>Update User Booking</h2>
        <form method="post" action="update2.php">
            <input type="hidden" name="book_id" value="<?php echo $row["book_id"]; ?>">
            Booking Name: <input type="text" name="book_name" value="<?php echo htmlspecialchars($row["book_name"]); ?>" required><br>
            Booking Quantity: <input type="number" name="book_quantity" value="<?php echo htmlspecialchars($row["book_quantity"]); ?>" required><br>
            Booking Type: <input type="text" name="book_type" value="<?php echo htmlspecialchars($row["book_type"]); ?>" required><br>
            Booking Date: <input type="date" name="book_date" value="<?php echo htmlspecialchars($row["book_date"]); ?>" required><br>
            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
<?php
        } else {
            echo '<div class="error">Data is not available.</div>';
        }
        $stmt->close();
    } else {
        echo '<div class="error">Not found.</div>';
    }
}

$conn->close();
?>
