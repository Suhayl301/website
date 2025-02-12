<?php
session_start(); // Start the session at the very beginning

// Database connection
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
    $book_id = isset($_POST['Book_Id']) ? $_POST['Book_Id'] : '';
    $book_name = isset($_POST['Book_Name']) ? $_POST['Book_Name'] : '';
    $book_type = isset($_POST['Book_Type']) ? $_POST['Book_Type'] : '';
    $book_quantity = isset($_POST['Book_Quantity']) ? $_POST['Book_Quantity'] : '';
    $book_date = isset($_POST['Book_Date']) ? $_POST['Book_Date'] : '';

    if (empty($book_id) || empty($book_name) || empty($book_quantity) || empty($book_type) || empty($book_date)) {
        $error_message = "All fields are required!";
    } else {
        // Check stock before proceeding
        $stockLimit = 100;
        $bookedQuantity = getBookedQuantity($book_type);

        if ($book_quantity > ($stockLimit - $bookedQuantity)) {
            $error_message = "Sorry, insufficient stock for " . $book_type . ". Only " . ($stockLimit - $bookedQuantity) . " pieces left.";
        } else {

            $sql = "INSERT INTO book (Book_Id, Book_Name, Book_Quantity, Book_Type, Book_Date)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Error in SQL query: " . $conn->error);
            }

            $stmt->bind_param("ssiss", $book_id, $book_name, $book_quantity, $book_type, $book_date);

            if ($stmt->execute()) {
                // Store data in session for use in bookreceipt.php
                $_SESSION['book_details'] = [
                    'Book_Id' => $book_id,
                    'Book_Name' => $book_name,
                    'Book_Type' => $book_type,
                    'Book_Quantity' => $book_quantity,
                    'Book_Date' => $book_date,
                ];

                $success_message = "Booking details saved successfully!";
                header("Location: bookreceipt.php");  
                exit();
            } else {
                $error_message = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

$conn->close();

function getBookedQuantity($foodType) {
    // Example of the function returning booked quantities for each food type
    $bookedQuantities = [
        'nasi' => 50,
        'bihun' => 50
    ];
    return $bookedQuantities[$foodType] ?? 0;
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Booking - Bakul Rezeki</title>
    <link rel="stylesheet" href="styles.css">
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

        header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .logo-section img {
            width: 90px;
            height: auto;
            border-radius: 50%;
            margin-right: 10px;
        }

        .logo-text {
            color: white;
            font-size: 24px;
            font-weight: bold;
            line-height: 1.2;
            text-align: left;
        }

        .form-container {
            background: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
            top: 80px;
        }

        .form-container h2 {
            color: #fcfcfc;
            margin-bottom: 20px;
        }

        .form-container input, .form-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: white;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #575d49;
        }

        .form-container a {
            color: #fcfcfc;
            text-decoration: none;
            display: block;
            margin-top: 20px;
        }
 /* Basic Reset */
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: sans-serif;
}

/* Flexbox Layout for Body */
body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background: url('image/bg.jpg') no-repeat center center fixed;
    background-size: cover;
}

/* Form Styling */
.form-container {
    background: rgba(0, 0, 0, 0.8);
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    width: 100%;
    max-width: 400px;
    text-align: center;
    margin-top: 80px;
    margin-bottom: 100px; /* Space for footer */
}

/* Footer Styling */
footer {
    background-color: #222;
    color: white;
    text-align: center;
    padding: 15px;
    width: 100%;
    position: relative;
}

/* Ensures the footer stays at the bottom */
footer {
    margin-top: auto;
}

/* Other styling for header and form */
header {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    z-index: 1000;
}

.checkbox-label {
    background-color: #fffafa;
    width: 60px;
    height: 30px;
    border-radius: 50px;
    position: relative;
    padding: 5px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background-color 0.3s;
}

.checkbox:checked + .checkbox-label {
    background-color: #4e4e4e;
}

.checkbox-label .fa-sun-o,
.checkbox-label .gg-moon {
    font-size: 20px;
    transition: opacity 0.3s ease;
}

.checkbox:checked + .checkbox-label .fa-sun-o {
    opacity: 1;
}

.checkbox:checked + .checkbox-label .gg-moon {
    opacity: 0;
}

.ball {
    position: absolute;
    top: 50%;
    left: 5px; /* Keep the ball from shifting too much */
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: #fff;
    transform: translateY(-50%);
    transition: transform 0.3s;
}

.checkbox:checked + .checkbox-label .ball {
    transform: translate(30px, -50%);
}

.social-icons a {
    margin: 0 10px;
    font-size: 20px;
    text-decoration: none;
    color: white;
}

.error-message, .success-message {
    color: #fcfcfc;
    background: rgba(255, 0, 0, 0.7);
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
}

.success-message {
    background: rgba(0, 255, 0, 0.7);
}

.datetime-container {
    position: relative;
}

.datetime-container label {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: gray;
    pointer-events: none;
    transition: 0.2s;
}

input:focus + label,
input:not(:placeholder-shown) + label {
    top: 5px;
    font-size: 12px;
    color: black;
}

input[type="datetime-local"] {
    width: 100%;
    padding: 10px;
    padding-left: 40px;
    box-sizing: border-box;
}

        .error-message, .success-message {
            color: #fcfcfc;
            background: rgba(255, 0, 0, 0.7);
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .success-message {
            background: rgba(0, 255, 0, 0.7);
        }

        .datetime-container {
            position: relative;
        }

        .datetime-container label {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: gray;
            pointer-events: none;
            transition: 0.2s;
        }

        input:focus + label,
        input:not(:placeholder-shown) + label {
            top: 5px;
            font-size: 12px;
            color: black;
        }

        input[type="datetime-local"] {
            width: 100%;
            padding: 10px;
            padding-left: 40px;
            box-sizing: border-box;
        }
    </style>
    <script>
        function checkStock() {
            var bookType = document.querySelector('select[name="Book_Type"]').value;
            var bookQuantity = document.querySelector('input[name="Book_Quantity"]').value;
            var stockLimit = 100; // Maximum stock

            var availableStock = 0;

            if (bookType === 'nasi') {
                availableStock = stockLimit - getBookedQuantity('nasi');
            } else if (bookType === 'bihun') {
                availableStock = stockLimit - getBookedQuantity('bihun');
            }

            if (bookQuantity > availableStock) {
                alert('Sorry, insufficient stock available for ' + bookType + '. Only ' + availableStock + ' left.');
                return false;
            }
            return true;
        }

        function getBookedQuantity(foodType) {
            var bookedQuantities = {
                'nasi': 50,
                'bihun': 50
            };

            return bookedQuantities[foodType] || 0; 
        }
    </script>
</head>


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakul Rezeki</title>
    <link rel="shortcut icon" href="logouitm.png" type="image/svg+xml">
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/moon.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
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


</script>
<script src="java/checkbox.js"></script>
    


<div class="form-container">
        <h2>User Booking</h2>
        
        <?php if (!empty($error_message)) { ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php } ?>

        <?php if (!empty($success_message)) { ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php } ?>

        <form action="book.php" method="POST">
            <input type="text" name="Book_Id" placeholder="User ID" required><br>
            <input type="text" name="Book_Name" placeholder="User Name" required><br>

            <select name="Book_Type" required>
                <option value="" disabled selected>Select Booking Type</option>
                <option value="nasi">Nasi Lemak</option>
                <option value="bihun">Bihun Goreng</option>
            </select><br>

            <input type="number" name="Book_Quantity" placeholder="Quantity" required min="1" max="100"><br>
            <input type="date" name="Book_Date" required><br>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>

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

</html>
