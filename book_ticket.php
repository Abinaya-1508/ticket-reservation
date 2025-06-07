<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Sample match data (same as search_matches.php)
$matches = [
    ["India vs Australia", "Wankhede Stadium", "2025-04-10", 50, 500],
    ["India vs Pakistan", "Eden Gardens", "2025-04-15", 30, 600],
    ["RCB vs CSK", "M. Chinnaswamy Stadium", "2025-04-20", 40, 700],
    ["CSK vs Mumbai Indians", "Chepauk Stadium", "2025-04-25", 20, 800],
    ["England vs South Africa", "Lords Cricket Ground", "2025-05-02", 60, 750],
    ["New Zealand vs West Indies", "Eden Park", "2025-05-08", 35, 650],
    ["Pakistan vs Sri Lanka", "Gaddafi Stadium", "2025-05-12", 45, 550],
    ["Bangladesh vs Afghanistan", "Sher-e-Bangla Stadium", "2025-05-18", 25, 500],
    ["IPL Final: KKR vs MI", "Narendra Modi Stadium", "2025-05-25", 80, 1000],
    ["Asia Cup Final: India vs Pakistan", "Dubai International Stadium", "2025-06-01", 90, 1200],
    ["SA vs Australia", "Melbourne Cricket Ground", "2025-06-10", 70, 850],
    ["England vs India", "Oval Stadium", "2025-06-15", 55, 900],
    ["NZ vs Bangladesh", "Wellington Stadium", "2025-06-20", 40, 700],
    ["Pakistan vs Afghanistan", "Sharjah Cricket Stadium", "2025-06-25", 35, 650],
    ["Sri Lanka vs West Indies", "Kensington Oval", "2025-07-01", 60, 750]
];

// Check if match_id is set and valid
if (!isset($_GET['match_id']) || !is_numeric($_GET['match_id'])) {
    echo "<script>alert('Error: Match not found.'); window.location.href='search_matches.php';</script>";
    exit;
}

$match_id = (int) $_GET['match_id']; // Convert to integer

// Validate match exists
if (!isset($matches[$match_id])) {
    echo "<script>alert('Error: Match not found.'); window.location.href='search_matches.php';</script>";
    exit;
}

// Retrieve match details
$match = $matches[$match_id];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Ticket</title>
    <style>
        body {
            background: url('stadium-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            text-align: center;
            font-family: Arial, sans-serif;
            color: black;
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
    <h2>Booking for <?= htmlspecialchars($match[0]) ?> at <?= htmlspecialchars($match[1]) ?></h2>
    <p>Date: <?= htmlspecialchars($match[2]) ?></p>
    <p>Available Seats: <?= $match[3] ?></p>
    <p>Price: ₹<?= $match[4] ?></p>
    <a href="confirm_booking.php?match_id=<?= $match_id ?>">Confirm Booking</a>
</body>
</html>
