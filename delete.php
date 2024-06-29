<?php
session_start();
include 'db.php';

$id = $_GET['id'];
if ($conn->query("DELETE FROM wishlist WHERE id = $id")) {
    $_SESSION['messages'][] = 'Wishlist berhasil dihapus';
} else {
    $_SESSION['messages'][] = 'Wishlist tidak ditemukan';
}

header('Location: index.php');
exit();
?>
