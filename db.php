<?php
$servername = "localhost";
$username = "mars";
$password = "Mars123";
$dbname = "wishlist_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
