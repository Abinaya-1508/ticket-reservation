<?php
include 'db.php';

if (isset($_GET['reservation_id']) && isset($_GET['discount'])) {
    $reservation_id = $_GET['reservation_id'];
    $discount = $_GET['discount'];

    $sql = "UPDATE reservations SET total_price = total_price - (total_price * $discount / 100) WHERE id=$reservation_id";
    $conn->query($sql);
    echo "Discount Applied!";
}
?>
