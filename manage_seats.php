<?php
include 'db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch Matches for Dropdown
$matchQuery = "SELECT id, team1, team2 FROM matches";
$matchResult = $conn->query($matchQuery);

// Add Seat Logic with Error Handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $match_id = $_POST['match_id'];
    $seat_number = $_POST['seat_number'];
    $price = $_POST['price'];

    // Validate match_id exists
    $checkMatch = $conn->prepare("SELECT id FROM matches WHERE id = ?");
    $checkMatch->bind_param("i", $match_id);
    $checkMatch->execute();
    $result = $checkMatch->get_result();

    if ($result->num_rows > 0) {
        // Insert seat only if match_id is valid
        $sql = "INSERT INTO seats (match_id, seat_number, price) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isd", $match_id, $seat_number, $price);

        if ($stmt->execute()) {
            header("Location: manage_seats.php");
            exit();
        } else {
            echo "<script>alert('Error adding seat. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Invalid Match ID. Please select a valid match.');</script>";
    }
}

// Fetch Seats
$sql = "SELECT seats.*, matches.team1, matches.team2 FROM seats 
        JOIN matches ON seats.match_id = matches.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Seats</title>
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
        form select, form input {
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
        <h2>Manage Seats</h2>
        <form method="POST">
            <select name="match_id" required>
                <option value="">Select Match</option>
                <?php while ($match = $matchResult->fetch_assoc()) { ?>
                    <option value="<?= $match['id'] ?>">
                        <?= htmlspecialchars($match['team1']) ?> vs <?= htmlspecialchars($match['team2']) ?>
                    </option>
                <?php } ?>
            </select>
            <input type="text" name="seat_number" placeholder="Seat Number" required>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <button type="submit" class="btn">Add Seat</button>
        </form>

        <table>
            <tr>
                <th>Match</th>
                <th>Seat Number</th>
                <th>Price</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['team1']) ?> vs <?= htmlspecialchars($row['team2']) ?></td>
                    <td><?= htmlspecialchars($row['seat_number']) ?></td>
                    <td>₹<?= htmlspecialchars($row['price']) ?></td>
                </tr>
            <?php } ?>
        </table>
        <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
