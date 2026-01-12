<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Successful</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-5 text-center" style="max-width: 450px;">
        <h2 class="text-success fw-bold mb-3">✅ Order Successful!</h2>

        <p class="mb-4">
            Thank you for your purchase.<br>
            Your order has been placed successfully.
        </p>

        <a href="ui.php" class="btn btn-dark px-4">
            Continue Shopping
        </a>
    </div>
</div>

</body>
</html>
