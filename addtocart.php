<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$product_id = (int) $_POST['product_id'];
$name       = $_POST['name'];
$price      = (float) $_POST['price'];
$image      = $_POST['image'];
$quantity   = max(1, (int) $_POST['quantity']);

if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = [
        'product_id' => $product_id,
        'name'       => $name,
        'price'      => $price,
        'image'      => $image,
        'quantity'   => $quantity
    ];
}

// 🔹 STAY ON UI PAGE
header("Location: ui.php?added=1");
exit;

