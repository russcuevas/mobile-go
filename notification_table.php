<?php
session_start();
include 'connection/database.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT DISTINCT order_number, status, order_date
    FROM tbl_orders
    WHERE customers_id = :customer_id
    ORDER BY order_date DESC
");
$stmt->bindParam(':customer_id', $_SESSION['user']['id']);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/notification.css">
    <title>Your Orders</title>
</head>

<body>
    <div class="container">
        <header>
            <h1>Your Order Notifications</h1>
            <h2>Click on an order to view details</h2>
        </header>

        <section id="orders-list">
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($orders) > 0): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>
                                    <a href="notification.php?order_number=<?= htmlspecialchars($order['order_number']) ?>">
                                        <?= htmlspecialchars($order['order_number']) ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($order['status']) ?></td>
                                <td><?= htmlspecialchars($order['order_date']) ?></td>
                                <td>
                                    <!-- Add a "View" button -->
                                    <a href="track_order.php?order_number=<?= htmlspecialchars($order['order_number']) ?>" class="view-btn">Track order</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <button onclick="goToHome()">Go to home</button>
        </section>

    </div>

    <script>
        // Redirect to home page
        function goToHome() {
            window.location.href = "index.php"; // or any other home page
        }
    </script>
</body>

</html>