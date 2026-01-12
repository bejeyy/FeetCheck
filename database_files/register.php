<?php
include "connection.php";

$name     = $_POST['name'];
$email    = $_POST['email'];
$password = $_POST['password'];

/* Check if email already exists */
$email_check = "SELECT user_id FROM users WHERE email='$email'";
$result = mysqli_query($conn, $email_check);

if (mysqli_num_rows($result) > 0) {
    header("Location: ../ui.php?signup=exist");
    exit;
}

/* Hash password */
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

/* Insert user */
$sql = "INSERT INTO users (full_name, email, password) VALUES ('$name', '$email', '$hashed_password')";

if (mysqli_query($conn, $sql)) {
    // Redirect with success message
    header("Location: ../ui.php?signup=success");
    exit;
} else {
    // Redirect with error message
    header("Location: ../ui.php?signup=error");
    exit;
}
?>