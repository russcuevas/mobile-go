<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../connection/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = intval($_POST['item']);

    $stmt = $conn->prepare("SELECT id FROM tbl_obsolete WHERE products_receiving_id = ?");
    $stmt->execute([$item_id]);

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Item already marked as obsolete.'); window.location.href = 'inventory.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO tbl_obsolete (products_receiving_id) VALUES (?)");
    $stmt->execute([$item_id]);

    echo "<script>alert('Item marked as obsolete.'); window.location.href = 'inventory.php';</script>";
    exit;
}
