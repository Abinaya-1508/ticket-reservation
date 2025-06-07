<?php
include 'db.php';

if (isset($_GET['reservation_id'])) {
    $reservation_id = $_GET['reservation_id'];
    $sql = "UPDATE reservations SET status='canceled' WHERE id=$reservation_id";
    $conn->query($sql);
    echo "Reservation Canceled!";
}
?>
