<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item = $_POST['item'];
    $stmt = $conn->prepare("INSERT INTO wishlist (item) VALUES (?)");
    $stmt->bind_param("s", $item);
    if ($stmt->execute()) {
        $_SESSION['messages'][] = 'Wishlist berhasil ditambahkan';
    } else {
        $_SESSION['messages'][] = 'Gagal menambahkan wishlist';
    }
    $stmt->close();
}

header('Location: index.php');
exit();
?>
