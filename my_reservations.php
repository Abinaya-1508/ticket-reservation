<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user reservations
$sql = "SELECT r.id, m.team1, m.team2, m.venue, m.match_date, r.seats, r.total_price, r.status 
        FROM reservations r
        JOIN matches m ON r.match_id = m.id
        WHERE r.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations</title>
    <style>
        body {
            background-image: url('stadium.jpg'); /* Set background */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            color: white;
        }
        h2 {
            text-align: center;
            padding: 20px;
            font-size: 28px;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background: rgba(0, 0, 0, 0.7); /* Transparent black background */
            color: white;
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            background: rgba(0, 0, 0, 0.9);
            padding: 12px;
            font-size: 18px;
        }
        td {
            padding: 12px;
            text-align: center;
            border: 1px solid white;
        }
        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.1);
        }
        .back-btn {
            display: block;
            width: 200px;
            text-align: center;
            margin: 20px auto;
            padding: 12px;
            background: red;
            color: white;
            text-decoration: none;
            font-size: 18px;
            border-radius: 8px;
        }
        .back-btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>
    <h2>My Reservations</h2>
    
    <!-- Back to Dashboard Button -->
    <a href="user_dashboard.php" class="back-btn">⬅ Back to Dashboard</a>
    
    <table>
        <tr>
            <th>Match</th>
            <th>Location</th>
            <th>Date</th>
            <th>Seats</th>
            <th>Total Price</th>
            <th>Status</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['team1']} vs {$row['team2']}</td>
                        <td>{$row['venue']}</td>
                        <td>{$row['match_date']}</td>
                        <td>{$row['seats']}</td>
                        <td>₹{$row['total_price']}</td>
                        <td>{$row['status']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No reservations found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
