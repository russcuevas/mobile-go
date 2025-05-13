<?php
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}
include '../connection/database.php';


// Fetch orders and their total price
$stmt = $conn->prepare("
    SELECT 
        o.order_number,
        c.first_name, 
        c.last_name,
        c.street, 
        c.city, 
        c.zip,
        GROUP_CONCAT(p.product_name) AS product_names,
        (
            SELECT total_price 
            FROM tbl_orders 
            WHERE order_number = o.order_number AND total_price > 0 
            LIMIT 1
        ) AS total_price,
        o.status
    FROM 
        tbl_orders o
    LEFT JOIN 
        tbl_products p ON o.products_id = p.id
    LEFT JOIN 
        tbl_customers c ON o.customers_id = c.id
    GROUP BY 
        o.order_number, c.id, o.status
    ORDER BY 
        o.order_date DESC
");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Customer Orders Management</title>
    <link rel="stylesheet" href="assets/css/orders.css">
    <style>
        /* Modal Style */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <h1>ShopAdmin</h1>
    </header>
    <button class="back-button" onclick="window.location.href='admin.php';">Back</button>
    <main>
        <div class="container">
            <h2>Customer Orders</h2>
            <table id="orders-table" aria-label="Customer orders management table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Products Ordered</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($orders) > 0): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['order_number']) ?></td>
                                <td>
                                    <?= htmlspecialchars($order['first_name']) . ' ' . htmlspecialchars($order['last_name']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($order['street']) . ', ' . htmlspecialchars($order['city']) . ', ' . htmlspecialchars($order['zip']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($order['product_names']) ?>
                                </td>
                                <td><?= number_format($order['total_price'], 2) ?></td>
                                <td><?= htmlspecialchars($order['status']) ?></td>
                                <td>
                                    <?php if (strtolower($order['status']) === 'completed'): ?>
                                        <span style="color: green; font-weight: 600;">Completed</span>
                                    <?php elseif (strtolower($order['status']) === 'cancelled'): ?>
                                        <span style="color: red; font-weight: 600;">Cancelled</span>
                                    <?php else: ?>
                                        <a href="javascript:void(0);" onclick="openUpdateModal('<?= $order['order_number'] ?>', '<?= htmlspecialchars($order['status']) ?>')">Update</a>
                                    <?php endif; ?>
                                </td>


                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Update Order Status</h2>
            <form id="updateOrderForm" method="POST">
                <input type="hidden" id="orderNumber" name="order_number">
                <label for="status">Select Status:</label>
                <select name="status" id="status" required>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <br><br>
                <button type="submit">Update Status</button>
            </form>
        </div>
    </div>

    <script>
        function openUpdateModal(orderNumber, currentStatus) {
            document.getElementById('orderNumber').value = orderNumber;
            document.getElementById('status').value = currentStatus;
            document.getElementById('updateModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('updateModal').style.display = "none";
        }

        document.getElementById('updateOrderForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var orderNumber = document.getElementById('orderNumber').value;
            var status = document.getElementById('status').value;

            var formData = new FormData();
            formData.append('order_number', orderNumber);
            formData.append('status', status);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_order_status.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    closeModal();
                    updateOrderStatusInTable(orderNumber, status);
                } else {
                    alert('Failed to update order status.');
                }
            };
            xhr.send(formData);
        });

        function updateOrderStatusInTable(orderNumber, status) {
            var rows = document.querySelectorAll('#orders-table tbody tr');
            rows.forEach(function(row) {
                var orderId = row.cells[0].textContent.trim();
                if (orderId === orderNumber) {
                    row.cells[5].textContent = status;
                    if (status.toLowerCase() === 'completed') {
                        row.cells[6].innerHTML = '<span style="color: green; font-weight: 600;">Completed</span>';
                    } else if (status.toLowerCase() === 'cancelled') {
                        row.cells[6].innerHTML = '<span style="color: red; font-weight: 600;">Cancelled</span>';
                    } else {
                        row.cells[6].innerHTML = `<a href="javascript:void(0);" onclick="openUpdateModal('${orderNumber}', '${status}')">Update</a>`;
                    }
                }
            });
        }
    </script>

</body>

</html>