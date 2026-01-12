<?php
$DBHost = "localhost";
$DBUser = "root";
$DBPass = "";
$DBName = "shoe_db";

// Create connection
$conn = mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>