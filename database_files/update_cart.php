<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id    = $_SESSION['user_id'];
$product_id = (int) $_POST['product_id'];
$action     = $_POST['action'] ?? '';

if ($action === 'increase') {
    $stmt = $conn->prepare("
        UPDATE cart
        SET quantity = LEAST(quantity + 1, 5)
        WHERE user_id = ? AND product_id = ?
    ");
} elseif ($action === 'decrease') {
    $stmt = $conn->prepare("
        UPDATE cart
        SET quantity = GREATEST(quantity - 1, 1)
        WHERE user_id = ? AND product_id = ?
    ");
} else {
    header("Location: ../cart.php");
    exit();
}

$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();

header("Location: ../cart.php");
exit();