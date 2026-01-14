<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../ui.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Delete user
$stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    session_destroy();
    header("Location: ../ui.php");
    exit();
} else {
    echo "Failed to delete account.";
}