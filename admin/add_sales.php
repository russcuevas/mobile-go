<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../connection/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = intval($_POST['item']);
    $quantity_sold = intval($_POST['quantity']);

    $stmt = $conn->prepare("SELECT quantity FROM tbl_receiving_items WHERE id = ?");
    $stmt->execute([$item_id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        echo "<script>alert('Item not found.'); window.location.href = 'inventory.php';</script>";
        exit;
    }

    if ($item['quantity'] < $quantity_sold) {
        echo "<script>alert('Not enough stock to complete sale.'); window.location.href = 'inventory.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("UPDATE tbl_receiving_items SET quantity = quantity - ? WHERE id = ?");
    $stmt->execute([$quantity_sold, $item_id]);

    $stmt = $conn->prepare("INSERT INTO tbl_sales_receiving (products_receiving_id, quantity_sold) VALUES (?, ?)");
    $stmt->execute([$item_id, $quantity_sold]);

    echo "<script>alert('Sale logged successfully.'); window.location.href = 'inventory.php';</script>";
    exit;
} else {
    header("Location: inventory.php");
    exit;
}
