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

$search_name = isset($_POST['txt_name']) ? $_POST['txt_name'] : '';
$search_phone = isset($_POST['txt_phone']) ? $_POST['txt_phone'] : '';

$sql = "SELECT * FROM donator WHERE 1=1";

if (!empty($search_name)) {
    $sql .= " AND donator_name LIKE '%" . $conn->real_escape_string($search_name) . "%'";
}
if (!empty($search_phone)) {
    $sql .= " AND donator_phone LIKE '%" . $conn->real_escape_string($search_phone) . "%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Donators</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="logouitm.png" type="image/svg+xml">
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/moon.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background: url('image/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            text-align: center;
        }

        .result-container {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            max-width: 60%;
            margin: 50px auto;
            color: white;
        }

        .result-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .result-table th, .result-table td {
    padding: 15px;
    border: 1px solid #ddd;
    text-align: center;
    color: white;
    font-size: 10px; /* Changed font size */
}

        .result-table th {
            background-color: #79733f;
        }

        .result-table tr:nth-child(even) {
            background-color: #575d49;
        }

        .result-table a {
            color: white;
            text-decoration: none;
        }

        .back-home {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #ffcc00;
            color: black;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .back-home:hover {
            background-color: #e6b800;
        }

        html, body {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.result-container {
    flex: 1;
}

footer {
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
    text-align: center;
    padding: 20px;
    width: 100%;
    margin-top: auto;
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
                <i class="fa fa-sun-o" style="font-size:20px"></i>
                <span class="ball"></span>
            </label>
        </div>
    </div>
</header>

<div class="result-container">
    <h2>Donators List</h2>
    <?php if ($result->num_rows > 0) { ?>
        <table class="result-table">
            <thead>
                <tr>
                    <th>Donator ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Type</th>
                    <th>Time</th>
                    <th>Phone</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['donator_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['donator_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['donator_quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['donator_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['donator_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['donator_phone']); ?></td>
                        <td><a href='update.php?donator_id=<?php echo $row['donator_id']; ?>'>Update</a></td>
                        <td><a href='delete.php?donator_id=<?php echo $row['donator_id']; ?>'>Delete</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="login.php" class="back-home">Back to Home</a>
    <?php } else { ?>
        <p>No results found.</p>
    <?php } ?>
</div>

<footer>
    <div class="container">
        <div class="footer-content">
            <p>&copy; COPYRIGHT UNIVERSITI TEKNOLOGI MARA 2025. All rights reserved.</p>
            <div class="social-icons">
                <a href="https://www.instagram.com/uitm.official/"><i class="fab fa-instagram"></i></a>
                <a href="https://www.facebook.com/uitmrasmi/"><i class="fab fa-facebook-square"></i></a>
            </div>
        </div>
    </div>
</footer>

<script src="java/checkbox.js"></script>
</body>
</html>

<?php
$conn->close();
?>
