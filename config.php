<?php
$host = "localhost";
$user = "root"; // Change if your MySQL has a different user
$pass = ""; // Change if your MySQL has a password
$db = "cricket"; // Make sure this matches your database name

$conn = new mysqli($host, $user, $pass, $db);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
