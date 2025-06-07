<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Sample match data
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
    ["Asia Cup Final: India vs Pakistan", "Dubai International Stadium", "2025-06-01", 90, 1200]
];

// Get match ID
if (!isset($_GET['match_id']) || !is_numeric($_GET['match_id'])) {
    echo "<script>alert('Error: Match not found.'); window.location.href='search_matches.php';</script>";
    exit;
}

$match_id = (int) $_GET['match_id'];

if (!isset($matches[$match_id])) {
    echo "<script>alert('Error: Match not found.'); window.location.href='search_matches.php';</script>";
    exit;
}

$match = $matches[$match_id];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <style>
        body {
            background: url('stadium.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .qr-code {
            margin-top: 20px;
            width: 250px;
            height: 250px;
        }
        .btn {
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: green;
            color: white;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: darkgreen;
        }
    </style>
    <script>
        function calculateTotal() {
            let seats = document.getElementById("seats").value;
            let pricePerSeat = <?= $match[4] ?>;
            let total = seats * pricePerSeat;
            document.getElementById("total_price").value = total;
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Payment for <?= htmlspecialchars($match[0]) ?> at <?= htmlspecialchars($match[1]) ?></h2>
    <p>Date: <?= htmlspecialchars($match[2]) ?></p>
    <p>Price per Seat: ₹<?= $match[4] ?></p>

    <h3>Select Seats</h3>
    <form action="confirm_payment.php" method="POST">
        <input type="hidden" name="match_id" value="<?= $match_id ?>">
        <input type="hidden" name="match_name" value="<?= htmlspecialchars($match[0]) ?>">
        <input type="hidden" name="venue" value="<?= htmlspecialchars($match[1]) ?>">
        <input type="hidden" name="match_date" value="<?= htmlspecialchars($match[2]) ?>">
        <input type="hidden" name="price_per_seat" value="<?= $match[4] ?>">

        <label for="seats">Number of Seats:</label>
        <input type="number" id="seats" name="seats" min="1" max="10" required onchange="calculateTotal()">
        
        <br><br>
        <label for="total_price">Total Price:</label>
        <input type="text" id="total_price" name="total_price" readonly>

        <h3>Scan the QR Code to Pay</h3>
        <img class="qr-code" src="code.jpg" alt="QR Code">

        <br>
        <button type="submit" class="btn">Confirm Payment</button>
    </form>
</div>

</body>
</html>
