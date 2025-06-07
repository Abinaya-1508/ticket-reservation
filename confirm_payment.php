<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $match_id = $_POST['match_id'];
    $seats = $_POST['seats'];
    $total_price = $_POST['total_price'];

    // Check if the match_id exists in the matches table
    $stmt = $conn->prepare("SELECT id FROM matches WHERE id = ?");
    $stmt->bind_param("i", $match_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<script>
                alert('Payment Successful! Your reservation has been confirmed.');
                window.location.href = 'user_dashboard.php'; // Redirect to my reservations page
              </script>";
    }

    // Insert the reservation into the database
    $sql = "INSERT INTO reservations (user_id, match_id, seats, total_price, status) 
            VALUES (?, ?, ?, ?, 'confirmed')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiid", $user_id, $match_id, $seats, $total_price);

    if ($stmt->execute()) {
        echo "<script>
                alert('Payment Successful! Your reservation has been confirmed.');
                window.location.href = 'user_dashboard.php'; // Redirect to my reservations page
              </script>";
    } else {
        echo "<script>alert('Error confirming payment. Please try again.'); window.history.back();</script>";
    }
}
?>
