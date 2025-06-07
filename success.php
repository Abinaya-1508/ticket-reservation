<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['match_id']) || !is_numeric($_GET['match_id'])) {
    echo "<script>alert('Error: Match not found.'); window.location.href='search_matches.php';</script>";
    exit;
}

$match_id = (int) $_GET['match_id'];

// Save the booking to the database (Modify for your database)
echo "<script>alert('Payment Successful! Your ticket is confirmed.'); window.location.href='user_dashboard.php';</script>";
exit;
?>
