<?php
include 'db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Add Match Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $team1 = $_POST['team1'];
    $team2 = $_POST['team2'];
    $venue = $_POST['venue'];
    $match_date = $_POST['match_date'];
    $total_tickets = $_POST['total_tickets'];
    $price = $_POST['price'];

    $sql = "INSERT INTO matches (team1, team2, venue, match_date, total_tickets, price) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssid", $team1, $team2, $venue, $match_date, $total_tickets, $price);
    $stmt->execute();
    header("Location: manage_matches.php");
    exit();
}

// Delete Match Logic
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM matches WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: manage_matches.php");
    exit();
}

// Fetch Matches
$sql = "SELECT * FROM matches";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Matches</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background: url('freak.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        form input {
            width: 90%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .delete {
            background-color: red;
        }
        .delete:hover {
            background-color: darkred;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: white;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        td {
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Matches</h2>
        <form method="POST">
            <input type="text" name="team1" placeholder="Team 1" required>
            <input type="text" name="team2" placeholder="Team 2" required>
            <input type="text" name="venue" placeholder="Venue" required>
            <input type="date" name="match_date" required>
            <input type="number" name="total_tickets" placeholder="Total Tickets" required>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <button type="submit" class="btn">Add Match</button>
        </form>

        <table>
            <tr>
                <th>Match</th>
                <th>Location</th>
                <th>Date</th>
                <th>Seats</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['team1']) ?> vs <?= htmlspecialchars($row['team2']) ?></td>
                    <td><?= htmlspecialchars($row['venue']) ?></td>
                    <td><?= htmlspecialchars($row['match_date']) ?></td>
                    <td><?= htmlspecialchars($row['total_tickets']) ?></td>
                    <td>₹<?= htmlspecialchars($row['price']) ?></td>
                    <td><a href="manage_matches.php?delete_id=<?= $row['id'] ?>" class="btn delete">Delete</a></td>
                </tr>
            <?php } ?>
        </table>
        <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
