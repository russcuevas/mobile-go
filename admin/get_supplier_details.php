<?php
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../connection/database.php';

if (isset($_GET['id'])) {
    $supplierId = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM tbl_suppliers WHERE supplier_id = ?");
    $stmt->execute([$supplierId]);
    $supplier = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($supplier) {
        echo json_encode($supplier);
    } else {
        echo json_encode(null);
    }
}
