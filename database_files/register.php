<?php
include "connection.php";

$full_name  = $_POST['name'];
$email      = $_POST['email'];
$contact    = $_POST['contact_num'];
$password   = $_POST['password'];

/* Check if email exists */
$check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    header("Location: ../ui.php?signup=exist");
    exit;
}

/* Hash password */
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

/* Insert user */
$stmt = $conn->prepare("
    INSERT INTO users (full_name, email, password, contact_num)
    VALUES (?, ?, ?, ?)
");
$stmt->bind_param("ssss", $full_name, $email, $hashed_password, $contact);

if ($stmt->execute()) {
    header("Location: ../ui.php?signup=success");
    exit;
} else {
    header("Location: ../ui.php?signup=error");
    exit;
}
?>
