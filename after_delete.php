<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Deleted</title>
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
            text-align: center;
        }

        .update-container h2 {
            color: #fcfcfc;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .update-container p {
            color: #fff; 
            font-size: 18px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #79733f;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn:hover {
            background-color: #575d49;
        }
    </style>
</head>
<body>
    <div class="update-container">
        <h2>Member Deleted Successfully</h2>
        <p>The record has been successfully deleted.</p>
        <a href="result.php" class="btn">Back to Donator</a>
    </div>
</body>
</html>
