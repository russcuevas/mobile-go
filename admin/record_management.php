<?php
// Fetch product data
include '../connection/database.php';
$stmt = $conn->prepare("SELECT * FROM tbl_records ORDER BY id DESC");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Product Management</title>
    <link rel="stylesheet" href="assets/css/record.css">
    <style>
        input,
        textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            font-size: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        button {
            padding: 6px 12px;
        }

        .action-btn {
            margin-right: 5px;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <header>Product Management</header>
    <button class="back-button" onclick="window.location.href='admin.php';">Back</button>
    <main>
        <h2>Manage Products</h2>
        <form id="addProductForm">
            <input type="hidden" id="productId" value="">
            <div>
                <label for="productName">Name</label>
                <input type="text" id="productName" required placeholder="Product name" />
            </div>
            <div>
                <label for="productDesc">Description</label>
                <textarea id="productDesc" rows="1" placeholder="Short description"></textarea>
            </div>
            <div>
                <label for="productPrice">Price (₱)</label>
                <input type="number" id="productPrice" min="0" step="0.01" required placeholder="0.00" />
            </div>
            <div>
                <label for="productStock">Stock</label>
                <input type="number" id="productStock" min="0" step="1" required placeholder="0" />
            </div>
            <div>
                <button type="submit">Save Product</button>
            </div>
        </form>

        <table id="productsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr data-id="<?= $product['id'] ?>">
                        <td><?= $product['id'] ?></td>
                        <td class="product-name" data-original-name="<?= htmlspecialchars($product['product_name']) ?>"><?= htmlspecialchars($product['product_name']) ?></td>
                        <td class="product-description" data-original-description="<?= htmlspecialchars($product['product_description']) ?>"><?= htmlspecialchars($product['product_description']) ?></td>
                        <td class="product-price" data-original-price="<?= $product['product_price'] ?>"><?= number_format($product['product_price'], 2) ?></td>
                        <td class="product-stock" data-original-stock="<?= $product['product_stocks'] ?>"><?= $product['product_stocks'] ?></td>
                        <td class="actions">
                            <button class="edit-btn" onclick="editProduct(<?= htmlspecialchars(json_encode($product)) ?>)">Edit</button>
                            <button class="hidden save-btn" onclick="saveProduct(<?= $product['id'] ?>)">Save</button>
                            <button class="hidden cancel-btn" onclick="cancelEdit(<?= $product['id'] ?>)">Cancel</button>
                            <button class="delete-btn" onclick="deleteProduct(<?= $product['id'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
        // Edit Product (toggle Save/Cancel)
        function editProduct(product) {
            const row = document.querySelector(`[data-id='${product.id}']`);
            row.querySelector('.product-name').innerHTML = `<input type="text" value="${product.product_name}" />`;
            row.querySelector('.product-description').innerHTML = `<textarea rows="1">${product.product_description}</textarea>`;
            row.querySelector('.product-price').innerHTML = `<input type="number" value="${product.product_price}" />`;
            row.querySelector('.product-stock').innerHTML = `<input type="number" value="${product.product_stocks}" />`;

            // Hide Edit, Show Save/Cancel
            row.querySelector('.edit-btn').classList.add('hidden');
            row.querySelector('.save-btn').classList.remove('hidden');
            row.querySelector('.cancel-btn').classList.remove('hidden');
        }

        // Save Product (after Edit)
        function saveProduct(id) {
            const row = document.querySelector(`[data-id='${id}']`);
            const name = row.querySelector('.product-name input').value;
            const desc = row.querySelector('.product-description textarea').value;
            const price = row.querySelector('.product-price input').value;
            const stock = row.querySelector('.product-stock input').value;

            const formData = new FormData();
            formData.append('id', id);
            formData.append('product_name', name);
            formData.append('product_description', desc);
            formData.append('product_price', price);
            formData.append('product_stocks', stock);

            fetch('product_actions.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(res => {
                    alert(res);
                    location.reload();
                });
        }

        // Cancel Edit (restore original values)
        function cancelEdit(id) {
            const row = document.querySelector(`[data-id='${id}']`);

            // Restore original values
            row.querySelector('.product-name').innerHTML = row.querySelector('.product-name').dataset.originalName;
            row.querySelector('.product-description').innerHTML = row.querySelector('.product-description').dataset.originalDescription;
            row.querySelector('.product-price').innerHTML = `${parseFloat(row.querySelector('.product-price').dataset.originalPrice).toFixed(2)}`;
            row.querySelector('.product-stock').innerHTML = row.querySelector('.product-stock').dataset.originalStock;

            // Hide Save/Cancel, Show Edit
            row.querySelector('.edit-btn').classList.remove('hidden');
            row.querySelector('.save-btn').classList.add('hidden');
            row.querySelector('.cancel-btn').classList.add('hidden');
        }

        // Delete Product
        function deleteProduct(id) {
            if (confirm("Are you sure you want to delete this product?")) {
                fetch('product_actions.php', {
                        method: 'POST',
                        body: new URLSearchParams({
                            delete_id: id
                        })
                    })
                    .then(res => res.text())
                    .then(res => {
                        alert(res);
                        location.reload();
                    });
            }
        }
    </script>
</body>

</html>