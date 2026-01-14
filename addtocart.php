<?php
session_start();
include "database_files/connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id    = $_SESSION['user_id'];
$product_id = (int)$_POST['product_id'];
$quantity   = max(1, min(5, (int)$_POST['quantity']));

// 🔹 Check if product already exists in cart
$stmt = $conn->prepare("
    SELECT quantity 
    FROM cart 
    WHERE user_id = ? AND product_id = ?
");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update quantity
    $stmt = $conn->prepare("
        UPDATE cart 
        SET quantity = quantity + ?
        WHERE user_id = ? AND product_id = ?
    ");
    $stmt->bind_param("iii", $quantity, $user_id, $product_id);
} else {
    // Insert new item
    $stmt = $conn->prepare("
        INSERT INTO cart (user_id, product_id, quantity)
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
}

$stmt->execute();

header("Location: ui.php?added=1");
exit();


