<?php
session_start();
include "database_files/connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ui.php");
    exit;
}

// Get cart from database
$stmt = $conn->prepare("
    SELECT c.product_id, c.quantity, p.price
    FROM cart c
    JOIN products p ON c.product_id = p.product_id
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$cart = [];
while ($row = $result->fetch_assoc()) {
    $cart[$row['product_id']] = [
        'quantity' => $row['quantity'],
        'price' => $row['price']
    ];
}

if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];

// Calculate total
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Create order
$stmt_order = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
$stmt_order->bind_param("id", $user_id, $total);
$stmt_order->execute();
$order_id = $stmt_order->insert_id;

// Save order items
$stmt_item = $conn->prepare("
    INSERT INTO order_items (order_id, product_id, quantity, price)
    VALUES (?, ?, ?, ?)
");

foreach ($cart as $product_id => $item) {
    $pid = (int)$product_id;
    $qty = (int)$item['quantity'];
    $price = (float)$item['price'];

    $stmt_item->bind_param("iiid", $order_id, $pid, $qty, $price);
    $stmt_item->execute();
}

// Clear cart from database
$stmt_clear = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$stmt_clear->bind_param("i", $user_id);
$stmt_clear->execute();

// Redirect to success
header("Location: ordersuccess.php");
exit;
