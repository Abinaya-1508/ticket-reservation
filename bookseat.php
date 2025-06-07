<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['seats'])) {
    $user_id = $_SESSION['user_id'];
    $match_id = $_POST['match_id'];
    $seats = implode(",", $_POST['seats']);
    $total_price = 0;

    foreach ($_POST['seats'] as $seat_id) {
        $query = "SELECT price FROM seats WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $seat_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $total_price += $result['price'];
    }

    // Generate QR code (Use any online QR code generator API)
    $payment_link = "upi://pay?pa=yourupi@upi&pn=CricketMatch&am=$total_price&cu=INR";
    $qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($payment_link);
} else {
    echo "No seats selected!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Scan to Pay</h2>
    <p>Total Amount: ₹<?= $total_price ?></p>
    <img src="<?= $qr_code_url ?>" alt="QR Code">
    <form action="confirm_reservation.php" method="post">
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        <input type="hidden" name="match_id" value="<?= $match_id ?>">
        <input type="hidden" name="seats" value="<?= $seats ?>">
        <input type="hidden" name="total_price" value="<?= $total_price ?>">
        <button type="submit">I've Paid</button>
    </form>
</body>
</html>
