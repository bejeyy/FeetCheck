<?php
session_start();
include "connection.php";

$email    = trim($_POST['email']);
$password = $_POST['password'];

$stmt = $conn->prepare("
    SELECT user_id, full_name, password
    FROM users
    WHERE email = ?
");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id']   = $user['user_id'];
        $_SESSION['user_name'] = $user['full_name'];

        header("Location: ../ui.php?login=success");
        exit;
    } else {
        header("Location: ../ui.php?login=wrong");
        exit;
    }
} else {
    header("Location: ../ui.php?login=notfound");
    exit;
}
