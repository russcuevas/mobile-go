<?php
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../connection/database.php';

if (isset($_POST['item_name'])) {
    $item_name = htmlspecialchars($_POST['item_name']);
    $stmt = $conn->prepare("UPDATE tbl_receiving_items SET back_order = 0, mark_received = 1 WHERE item_name = :item_name");
    $stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "<script>alert('Item marked as received.'); window.location.href = 'inventory.php';</script>";
        exit;
    } else {
        header('Location: inventory.php');
        exit;
    }
} else {
    header('Location: inventory.php');
    exit;
}
