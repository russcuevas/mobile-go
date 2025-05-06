<?php
session_start();
include 'connection/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];
    $customer_id = $_SESSION['user']['id'];

    $stmt = $conn->prepare("DELETE FROM tbl_carts WHERE id = :id AND customer_id = :customer_id");
    $stmt->bindParam(':id', $cart_id, PDO::PARAM_INT);
    $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
