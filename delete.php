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

if (isset($_GET["donator_id"])) {
    $donator_id = $_GET["donator_id"];

    $sql = "DELETE FROM donator WHERE Donator_Id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $donator_id);

    if ($stmt->execute()) {
        header("Location: after_delete.php?message=delete_success");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Donator ID not provided.";
}

$conn->close();
?>
