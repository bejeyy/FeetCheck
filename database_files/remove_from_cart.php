<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id    = $_SESSION['user_id'];
$product_id = (int) $_POST['product_id'];

// Delete item from database cart
$stmt = $conn->prepare("
    DELETE FROM cart 
    WHERE user_id = ? AND product_id = ?
");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();

header("Location: ../cart.php");
exit();
