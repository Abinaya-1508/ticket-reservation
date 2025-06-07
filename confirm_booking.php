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

header("Location: payment.php?match_id=$match_id");
exit;
?>
