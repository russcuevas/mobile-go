<?php
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../connection/database.php';

// Delete a specific product
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM tbl_products WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Output success message using JavaScript alert
    echo "<script>alert('Product deleted successfully.'); window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
    exit;
}

// Delete all products
if (isset($_GET['clear_all'])) {
    $conn->query("DELETE FROM tbl_products");

    // Output success message using JavaScript alert
    echo "<script>alert('All products deleted successfully.'); window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
    exit;
}


// Add a new product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['productName'] ?? '';
    $price = $_POST['productPrice'] ?? 0;
    $description = $_POST['productDescription'] ?? '';
    $link = $_POST['productImageUrl'] ?? '';

    if (!empty($name) && $price > 0) {
        $stmt = $conn->prepare("INSERT INTO tbl_products (product_name, product_price, product_description, product_link) VALUES (:name, :price, :description, :link)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':link', $link);
        $stmt->execute();

        // Build message for display
        $successMessage = "Product added successfully.";
    }
}

// Fetch products
$stmt = $conn->query("SELECT * FROM tbl_products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>Online Shopping</title>
    <link rel="stylesheet" href="assets/css/product.css">
</head>

<body>
    <button class="back-button" onclick="window.location.href='admin.php';">Back</button>
    <section class="admin-panel" aria-label="Admin Product Entry Panel">
        <h2>Add a New Product</h2>
        <form id="productForm" method="POST" action="" aria-label="Add product form">
            <?php if (!empty($successMessage)): ?>
                <div class="success-message">
                    <?= $successMessage ?>
                </div>
            <?php endif; ?>


            <div class="form-group">
                <label for="productName">Product Name *</label>
                <input type="text" id="productName" name="productName" placeholder="Enter product name" required />
            </div>
            <div class="form-group">
                <label for="productPrice">Price *</label>
                <input
                    type="number"
                    id="productPrice"
                    name="productPrice"
                    min="0"
                    step="0.01"
                    placeholder="0.00"
                    required />
            </div>
            <div class="form-group">
                <label for="productDescription">Description</label>
                <textarea
                    id="productDescription"
                    name="productDescription"
                    placeholder="Any details about the product"></textarea>
            </div>
            <div class="form-group">
                <label for="productImageUrl">Image URL</label>
                <input
                    type="url"
                    id="productImageUrl"
                    name="productImageUrl"
                    placeholder="https://example.com/image.jpg" />
            </div>
            <button type="submit" class="btn-add">Add Product</button>
        </form>
        <form method="GET" onsubmit="return confirm('Are you sure you want to delete ALL products?');">
            <button type="submit" name="clear_all" class="btn-clear" aria-label="Clear all products">Clear All Products</button>
        </form>
    </section>

    <section class="products-container" aria-label="Products List" id="productsList">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <?php if (!empty($product['product_link'])): ?>
                        <img src="<?= htmlspecialchars($product['product_link']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" class="product-image">
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($product['product_name']) ?></h3>
                    <p>₱<?= number_format($product['product_price'], 2) ?></p>
                    <?php if (!empty($product['product_description'])): ?>
                        <p><?= htmlspecialchars($product['product_description']) ?></p>
                    <?php endif; ?>
                    <form method="GET" onsubmit="return confirm('Are you sure you want to delete this product?');" style="margin-top: 10px;">
                        <input type="hidden" name="delete" value="<?= $product['id'] ?>">
                        <button type="submit" class="btn-remove">Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products yet.</p>
        <?php endif; ?>
    </section>

</body>

</html>