<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Sample 15 match data
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Matches</title>
    <style>
        body {
            background: url('stadium-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            text-align: center;
            color: white;
        }
        .container {
            margin: 50px auto;
            width: 85%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            font-size: 18px;
        }
        th, td {
            padding: 12px;
            border: 1px solid white;
            text-align: center;
        }
        th {
            background-color: #444;
        }
        .btn {
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
        }
        .btn-book {
            background-color: #ff9800;
            color: white;
        }
        .btn-book:hover {
            background-color: #e68900;
        }
        .btn-back {
            background-color: green;
            color: white;
        }
        .btn-back:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>🏏 Available Cricket Matches</h2>
        <table>
            <tr>
                <th>Match</th>
                <th>Location</th>
                <th>Date</th>
                <th>Available Seats</th>
                <th>Amount (₹)</th>
                <th>Book</th>
            </tr>
            <?php foreach ($matches as $index => $match): ?>
                <tr>
                    <td><?= htmlspecialchars($match[0]) ?></td>
                    <td><?= htmlspecialchars($match[1]) ?></td>
                    <td><?= htmlspecialchars($match[2]) ?></td>
                    <td><?= $match[3] ?></td>
                    <td>₹<?= $match[4] ?></td>
                    <td>
                        <a href="book_ticket.php?match_id=<?= $index ?>" class="btn btn-book">Book Now</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <br>
        <a href="user_dashboard.php" class="btn btn-back">⬅ Back</a>
        <a href="logout.php" class="btn btn-back">🚪 Logout</a>
    </div>

</body>
</html>
