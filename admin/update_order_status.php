<?php
include '../connection/database.php';

if (isset($_POST['order_number']) && isset($_POST['status'])) {
    $order_number = $_POST['order_number'];
    $status = $_POST['status'];

    // Update the order status
    $stmt = $conn->prepare("
        UPDATE tbl_orders
        SET status = :status
        WHERE order_number = :order_number
    ");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':order_number', $order_number);

    if ($stmt->execute()) {
        // If marked as Completed, insert into tbl_sales
        if ($status === "completed") {
            // Get product names and total price for the order
            $salesStmt = $conn->prepare("
                SELECT GROUP_CONCAT(p.product_name) AS products, 
                       SUM(p.product_price) AS amount
                FROM tbl_orders o
                LEFT JOIN tbl_products p ON o.products_id = p.id
                WHERE o.order_number = :order_number
            ");
            $salesStmt->bindParam(':order_number', $order_number);
            $salesStmt->execute();
            $salesData = $salesStmt->fetch(PDO::FETCH_ASSOC);

            if ($salesData) {
                // Insert into tbl_sales
                $insertStmt = $conn->prepare("
                    INSERT INTO tbl_sales (sales_number, products, payment, amount, status, created_at)
                    VALUES (:sales_number, :products, 'Cash', :amount, 'Completed', NOW())
                ");
                $insertStmt->bindParam(':sales_number', $order_number);
                $insertStmt->bindParam(':products', $salesData['products']);
                $insertStmt->bindParam(':amount', $salesData['amount']);
                $insertStmt->execute();
            }
        }

        echo "Success";
    } else {
        echo "Error";
    }
} else {
    echo "Invalid request: Missing order number or status.";
}
