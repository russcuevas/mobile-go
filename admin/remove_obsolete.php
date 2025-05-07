<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../connection/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $obsolete_id = intval($_POST['obsolete_id']);

    $stmt = $conn->prepare("DELETE FROM tbl_obsolete WHERE id = ?");
    $stmt->execute([$obsolete_id]);

    echo "<script>alert('Obsolete item removed.'); window.location.href = 'inventory.php';</script>";
    exit;
}
