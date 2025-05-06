<?php
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../connection/database.php';

// INSERT or UPDATE
if (isset($_POST['product_name'])) {
    $id = $_POST['id'] ?? '';
    $name = $_POST['product_name'];
    $desc = $_POST['product_description'];
    $price = $_POST['product_price'];
    $stock = $_POST['product_stocks'];

    if ($id) {
        // Update
        $stmt = $conn->prepare("UPDATE tbl_records SET product_name = ?, product_description = ?, product_price = ?, product_stocks = ? WHERE id = ?");
        $stmt->execute([$name, $desc, $price, $stock, $id]);
        echo "Product updated successfully.";
    } else {
        // Insert
        $stmt = $conn->prepare("INSERT INTO tbl_records (product_name, product_description, product_price, product_stocks) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $desc, $price, $stock]);
        echo "Product added successfully.";
    }
    exit;
}

// DELETE
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM tbl_records WHERE id = ?");
    $stmt->execute([$id]);
    echo "Product deleted successfully.";
    exit;
}
