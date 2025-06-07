<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            background: url('stadium-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            text-align: center;
            font-family: Arial, sans-serif;
            color: white;
            padding-top: 150px;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 80vh;
        }
        .btn {
            display: block;
            width: 250px;
            margin: 15px;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            background-color: #ff9800;
            color: white;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.3);
            transition: 0.3s ease-in-out;
        }
        .btn:hover {
            background-color: #e68900;
            transform: scale(1.1);
        }
    </style>
</head>
<body>

    <div class="container">
        <a href="search_matches.php" class="btn">🔍 Search Matches</a>
        <a href="my_reservations.php" class="btn">🎟 My Reservations</a>
        <a href="logout.php" class="btn">🚪 Logout</a>
    </div>

</body>
</html>
