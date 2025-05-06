<?php
include '../connection/database.php';

if (isset($_POST['item_name'])) {
    $item_name = htmlspecialchars($_POST['item_name']);

    $stmt = $conn->prepare("DELETE FROM tbl_receiving_items WHERE item_name = :item_name");
    $stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "<script>alert('Item removed successfully.'); window.location.href = 'inventory.php';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to remove item.'); window.location.href = 'inventory.php';</script>";
        exit;
    }
} else {
    header('Location: inventory.php');
    exit;
}
