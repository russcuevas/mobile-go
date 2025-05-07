<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../connection/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $damage_id = intval($_POST['damage_id']);

    $stmt = $conn->prepare("SELECT products_receiving_id, quantity_damage FROM tbl_damage WHERE id = ?");
    $stmt->execute([$damage_id]);
    $damage = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$damage) {
        echo "<script>alert('Damage record not found.'); window.location.href = 'inventory.php';</script>";
        exit;
    }

    $product_id = $damage['products_receiving_id'];
    $quantity_to_restore = $damage['quantity_damage'];

    $stmt = $conn->prepare("UPDATE tbl_receiving_items SET quantity = quantity + ? WHERE id = ?");
    $stmt->execute([$quantity_to_restore, $product_id]);

    $stmt = $conn->prepare("DELETE FROM tbl_damage WHERE id = ?");
    $stmt->execute([$damage_id]);

    echo "<script>alert('Damage entry removed'); window.location.href = 'inventory.php';</script>";
    exit;
} else {
    header("Location: inventory.php");
    exit;
}
