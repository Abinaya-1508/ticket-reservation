<?php
session_start();
include("config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $match_id = $_POST['match_id'];
    $seats = $_POST['seats'];

    // Get match price
    $stmt = $conn->prepare("SELECT price FROM matches WHERE id = ?");
    $stmt->bind_param("i", $match_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $match = $result->fetch_assoc();

    if (!$match) {
        echo "Match not found.";
        exit();
    }

    $total_price = $match['price'] * $seats;

    // Insert reservation as "confirmed"
    $stmt = $conn->prepare("INSERT INTO reservations (user_id, match_id, seats, total_price, status) VALUES (?, ?, ?, ?, 'confirmed')");
    $stmt->bind_param("iiid", $user_id, $match_id, $seats, $total_price);

    if ($stmt->execute()) {
        header("Location: my_reservations.php?success=1");
        exit();
    } else {
        echo "Error confirming reservation.";
    }
}
?>
