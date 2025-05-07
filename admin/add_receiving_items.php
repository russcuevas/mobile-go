<?php
session_start();


if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../connection/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $quantity = intval($_POST['quantity']);
    $critical_level = intval($_POST['critical_level']);
    $back_order = ($_POST['back_order'] === 'true') ? 1 : 0;
    $mark_received = null; // explicitly setting null

    $stmt = $conn->prepare("INSERT INTO tbl_receiving_items (item_name, quantity, critical_level, back_order, mark_received)
                            VALUES (?, ?, ?, ?, ?)");

    $stmt->execute([$item_name, $quantity, $critical_level, $back_order, $mark_received]);

    echo "<script>alert('Item added successfully.'); window.location.href = 'inventory.php';</script>";
    exit;
}
