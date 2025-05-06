<?php
session_start();
include 'connection/database.php';

// Fetch products from the database
$stmt = $conn->query("SELECT * FROM tbl_products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Add to cart logic
if (isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['user'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        $customer_id = $_SESSION['user']['id'];

        $stmt = $conn->prepare("SELECT * FROM tbl_carts WHERE product_id = :product_id AND customer_id = :customer_id");
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $stmt = $conn->prepare("UPDATE tbl_carts SET quantity = quantity + :quantity WHERE product_id = :product_id AND customer_id = :customer_id");
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':customer_id', $customer_id);
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("INSERT INTO tbl_carts (product_id, customer_id, quantity) VALUES (:product_id, :customer_id, :quantity)");
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':customer_id', $customer_id);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->execute();
        }

        echo "<script>alert('Added to cart successfully'); window.history.back();</script>";
        exit;
    } else {
        header("Location: login.php");
        exit;
    }
}

$cart_items = [];
if (isset($_SESSION['user'])) {
    $customer_id = $_SESSION['user']['id'];
    $stmt = $conn->prepare("SELECT c.id, c.quantity, p.product_name, p.product_price 
                            FROM tbl_carts c
                            JOIN tbl_products p ON c.product_id = p.id
                            WHERE c.customer_id = :customer_id");
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->execute();
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/shop.css">
    <title>Shop</title>
    <style>
        .products {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="nav-bar">
            <ul class="menu">
                <li><a href="index.php">HOME</a></li>
                <li><a href="shop.php" class="active">PRODUCT</a></li>
                <li><a href="notification.php">NOTIFICATION</a></li>
                <li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="logout.php">LOGOUT</a>
                    <?php else: ?>
                        <a href="login.php">ACCOUNT</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>

    <section class="sec">
        <div class="products">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="card">
                        <div class="img">
                            <?php if (!empty($product['product_link'])): ?>
                                <img src="<?= htmlspecialchars($product['product_link']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                            <?php else: ?>
                                <img src="default-image.jpg" alt="No Image Available">
                            <?php endif; ?>
                        </div>
                        <div class="title"><?= htmlspecialchars($product['product_name']) ?></div>
                        <div class="box">
                            <div class="price">php <?= number_format($product['product_price'], 2) ?></div>
                            <form method="POST" action="shop.php">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="quantity" value="1" min="1" required>
                                <button type="submit" name="add_to_cart" class="btn">Add to cart</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; font-size: 50px; color: red; background-color: white; padding: 20px;">No products available.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Cart Icon (Click to show the cart) -->
    <div class="icon-cart" id="iconCart">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M6 15a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0h8m-8 0-1-4m9 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-9-4h10l2-7H3m2 7L3 4m0 0-.792-3H1" />
        </svg>
    </div>

    <!-- Cart Tab (Hidden initially) -->
    <div class="cartTab hidden">
        <div class="cart-header">
            <h1>Order Details</h1>
        </div>
        <div class="cart-content">
            <table id="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($cart_items as $cart_item):
                        $total_price = $cart_item['product_price'] * $cart_item['quantity'];
                        $total += $total_price;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($cart_item['product_name']) ?></td>
                            <td>₱<?= number_format($cart_item['product_price'], 2) ?></td>
                            <td><?= $cart_item['quantity'] ?></td>
                            <td>₱<?= number_format($total_price, 2) ?></td>
                            <td><button class="btn remove-btn" data-id="<?= $cart_item['id'] ?>">Remove</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="cart-footer">
            <div id="total-amount">Total: ₱ <?= number_format($total, 2) ?></div>
            <div class="cart-actions">
                <button class="close"><a href="shop.php">CLOSE</a></button>
                <button class="checkOut"><a href="notification.php">Check Out</a></button>
            </div>
        </div>
    </div>

    <script src="assets/js/cart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.remove-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const cartId = this.getAttribute('data-id');
                    const row = this.closest('tr');

                    fetch('remove_from_cart.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `cart_id=${cartId}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                row.remove();
                                updateTotal();
                            } else {
                                alert('Failed to remove item: ' + data.message);
                            }
                        });
                });
            });

            function updateTotal() {
                let total = 0;
                document.querySelectorAll('#cart-table tbody tr').forEach(row => {
                    const totalCell = row.querySelector('td:nth-child(4)');
                    if (totalCell) {
                        const amount = parseFloat(totalCell.textContent.replace('₱', '').trim());
                        total += amount;
                    }
                });
                document.getElementById('total-amount').textContent = 'Total: ₱ ' + total.toFixed(2);
            }
        });
    </script>

</body>

</html>