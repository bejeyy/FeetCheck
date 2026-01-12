<?php
session_start();
include __DIR__ . "/database_files/connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ui.php");
    exit;
}

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$cart = $_SESSION['cart'];

$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

/* CREATE ORDER */
mysqli_query($conn, "INSERT INTO orders (user_id, total) VALUES ($user_id, $total)");
$order_id = mysqli_insert_id($conn);

/* SAVE ORDER ITEMS */
foreach ($cart as $product_id => $item) {
    $product_id = (int) $product_id;
    $qty = (int) $item['quantity'];
    $price = (float) $item['price'];

    mysqli_query($conn, "
        INSERT INTO order_items (order_id, product_id, quantity, price)
        VALUES ($order_id, $product_id, $qty, $price)
    ");
}

/* CLEAR CART */
unset($_SESSION['cart']);

header("Location: ordersuccess.php");
exit;

