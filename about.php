<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us | FeetCheck</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-black px-4">
    <a href="ui.php" class="text-white text-decoration-none fw-bold fs-4">
        ← Back
    </a>
</nav>

<div class="container my-5" style="max-width:800px;">

    <h2 class="fw-bold mb-4 text-center">
        👟 About FeetCheck
    </h2>

    <p class="text-muted text-center mb-5">
        Your trusted destination for quality sneakers and streetwear essentials.
    </p>

    <!-- WHO WE ARE -->
    <div class="mb-4">
        <h5 class="fw-bold">
            <i class="bi bi-people me-2"></i> Who We Are
        </h5>
        <p>
            FeetCheck is an online sneaker store created as a project to provide
            a simple, fast, and user-friendly shopping experience for sneaker lovers.
            We focus on quality, comfort, and style.
        </p>
    </div>

    <!-- WHAT WE DO -->
    <div class="mb-4">
        <h5 class="fw-bold">
            <i class="bi bi-bag-check me-2"></i> What We Do
        </h5>
        <p>
            We offer a curated collection of popular sneakers, allowing users to
            browse products, add items to cart, place orders, and track their purchases
            through an easy-to-use system.
        </p>
    </div>

    <!-- WHY FEETCHECK -->
    <div class="mb-4">
        <h5 class="fw-bold">
            <i class="bi bi-lightning-charge me-2"></i> Why FeetCheck
        </h5>
        <p>
            FeetCheck was built with simplicity and efficiency in mind.
            Our goal is to demonstrate a functional e-commerce platform
            with clean design, secure transactions, and smooth user interactions.
        </p>
    </div>

    <!-- CONTACT -->
    <div class="mb-4">
        <h5 class="fw-bold">
            <i class="bi bi-envelope me-2"></i> Contact Us
        </h5>
        <p class="mb-1">📧 Email: support@feetcheck.com</p>
        <p class="mb-1">📞 Phone: +63 915 342 5619</p>
    </div>

    <div class="text-center mt-5 text-muted">
        © <?= date("Y"); ?> FeetCheck. All rights reserved.
    </div>

</div>

</body>
</html>
