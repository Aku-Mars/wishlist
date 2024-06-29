<?php
session_start();
include 'db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT completed FROM wishlist WHERE id = $id");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $completed = $row['completed'] ? 0 : 1;
    $conn->query("UPDATE wishlist SET completed = $completed WHERE id = $id");
    $_SESSION['messages'][] = 'Status wishlist berhasil diubah';
} else {
    $_SESSION['messages'][] = 'Wishlist tidak ditemukan';
}

header('Location: index.php');
exit();
?>
