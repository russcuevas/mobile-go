<?php
session_start();
include 'connection/database.php';

// Check if order_number is passed in the URL
if (isset($_GET['order_number'])) {
    $order_number = $_GET['order_number'];
} else {
    // If no order number, redirect to home
    header("Location: index.php");
    exit;
}

// Fetch the order details based on the order_number
$stmt = $conn->prepare("
    SELECT o.*, p.product_name, p.product_price, p.product_description, c.first_name, c.last_name, c.email, c.phone, c.street, c.city, c.zip
    FROM tbl_orders o
    JOIN tbl_products p ON o.products_id = p.id
    JOIN tbl_customers c ON o.customers_id = c.id
    WHERE o.order_number = :order_number
");
$stmt->bindParam(':order_number', $order_number);
$stmt->execute();
$order_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/notification.css">
    <title>Order Notification</title>
</head>

<body>
    <div class="container">
        <header>
            <h1>Track your order</h1>
        </header>

        <section id="order-notification">
            <?php if (!empty($order_details)): ?>
                <h2>Your Order Details ( <?= htmlspecialchars($order_details[0]['status']) ?> )</h2>
                <br>
                <br>
                <p><strong>Order Number:</strong> <?= htmlspecialchars($order_number) ?></p>

                <!-- Customer Information -->
                <h3>Customer Information:</h3>
                <p><strong>Name:</strong> <?= htmlspecialchars($order_details[0]['first_name']) ?> <?= htmlspecialchars($order_details[0]['last_name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($order_details[0]['email']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($order_details[0]['phone']) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($order_details[0]['street']) ?>, <?= htmlspecialchars($order_details[0]['city']) ?>, <?= htmlspecialchars($order_details[0]['zip']) ?></p>

                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price (₱)</th>
                            <th>Description</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_details as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['product_name']) ?></td>
                                <td><?= number_format($item['product_price'], 2) ?></td>
                                <td><?= htmlspecialchars($item['product_description']) ?></td>
                                <td><?= htmlspecialchars($item['order_date']) ?></td>
                            </tr>
                            <?php $total += $item['product_price']; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php
                $total_price = 0;
                foreach ($order_details as $item) {
                    if ($item['total_price'] > 0) {
                        $total_price = $item['total_price'];
                        break;
                    }
                }
                ?>
                <p><strong>Total Amount:</strong> ₱<?= number_format($total_price, 2) ?></p> <?php else: ?>
                <p>No recent orders found.</p>
            <?php endif; ?>

            <button onclick="goToHome()">Go back</button>
        </section>
    </div>

    <script>
        // Redirect to home page
        function goToHome() {
            window.location.href = "notification_table.php"; // or any other home page
        }
    </script>

</body>

</html>