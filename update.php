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
    
    $donator_id = $_POST["donator_id"];
    $donator_name = $_POST["donator_name"];
    $donator_quantity = $_POST["donator_quantity"];
    $donator_type = $_POST["donator_type"];
    $donator_time = $_POST["donator_time"];
    $donator_phone = $_POST["donator_phone"];

    // Update statement based on donator table structure
    $sql = "UPDATE donator SET  
            donator_name=?, 
            donator_quantity=?, 
            donator_type=?, 
            donator_time=?, 
            donator_phone=? 
            WHERE donator_id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssi", $donator_name, $donator_quantity, $donator_type, $donator_time, $donator_phone, $donator_id);

    if ($stmt->execute()) {
        header("Location: after_update.php?message=update_success");
        exit();
    } else {
        echo '<div class="error">Error updating record: ' . $stmt->error . '</div>';
    }

    $stmt->close();
} else {
    if (isset($_GET["donator_id"])) {
        $donator_id = $_GET["donator_id"];

        $sql = "SELECT * FROM donator WHERE donator_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $donator_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Donator</title>
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
        .update-container form input[type="datetime-local"] {
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
        <h2>Update Donator</h2>
        <form method="post" action="update.php">
            <input type="hidden" name="donator_id" value="<?php echo $row["donator_id"]; ?>">
            Donator Name: <input type="text" name="donator_name" value="<?php echo htmlspecialchars($row["donator_name"]); ?>" required><br>
            Donation Quantity: <input type="number" name="donator_quantity" value="<?php echo htmlspecialchars($row["donator_quantity"]); ?>" required><br>
            Donation Type: <input type="text" name="donator_type" value="<?php echo htmlspecialchars($row["donator_type"]); ?>" required><br>
            Donation Time: <input type="datetime-local" name="donator_time" value="<?php echo htmlspecialchars($row["donator_time"]); ?>" required><br>
            Donator Phone: <input type="text" name="donator_phone" value="<?php echo htmlspecialchars($row["donator_phone"]); ?>" required><br>
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
