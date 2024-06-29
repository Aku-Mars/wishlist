<?php
$servername = "localhost";
$username = "admin";
$password = "SOK1PSTIC";
$dbname = "wishlist_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
