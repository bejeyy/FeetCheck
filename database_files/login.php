<?php
session_start();
include "connection.php";

$email    = $_POST['email'];
$password = $_POST['password'];

/* Find user */
$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    
    if (password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
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
?>
