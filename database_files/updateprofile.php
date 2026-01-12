<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../ui.php");
    exit;
}

if (!isset($_POST['name'])) {
    header("Location: ../profile.php");
    exit;
}

$name = trim($_POST['name']);
$user_id = $_SESSION['user_id'];

$sql = "UPDATE users SET full_name = ? WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "si", $name, $user_id);
mysqli_stmt_execute($stmt);

header("Location: ../profile.php?updated=1");
exit;
