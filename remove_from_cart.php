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

    // Get the product_id and quantity first
    $stmt = $conn->prepare("SELECT product_id, quantity FROM tbl_carts WHERE id = :id AND customer_id = :customer_id");
    $stmt->bindParam(':id', $cart_id, PDO::PARAM_INT);
    $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
    $stmt->execute();
    $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cartItem) {
        echo json_encode(['status' => 'error', 'message' => 'Cart item not found']);
        exit;
    }

    $product_id = $cartItem['product_id'];
    $quantity = $cartItem['quantity'];

    // Begin transaction
    $conn->beginTransaction();

    try {
        // Restore product stock
        $stmt = $conn->prepare("UPDATE tbl_products SET product_stocks = product_stocks + :quantity WHERE id = :product_id");
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        // Delete the cart item
        $stmt = $conn->prepare("DELETE FROM tbl_carts WHERE id = :id AND customer_id = :customer_id");
        $stmt->bindParam(':id', $cart_id, PDO::PARAM_INT);
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        $stockStmt = $conn->prepare("SELECT product_stocks FROM tbl_products WHERE id = :product_id");
        $stockStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stockStmt->execute();
        $updatedStock = $stockStmt->fetchColumn();

        echo json_encode([
            'status' => 'success',
            'product_id' => $product_id,
            'updated_stock' => (int)$updatedStock
        ]);
    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete and restore stock']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
