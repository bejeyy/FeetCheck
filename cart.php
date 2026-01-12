<?php
session_start();
include "database_files/connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FeetCheck Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles/cartstyle.css">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-black px-4 sticky-top">
        <!-- Group: Back button + Brand -->
        <div class="d-flex align-items-center">
            <!-- Back / Return Button -->
            <a href="ui.php" class="text-white fs-4 me-2 d-flex align-items-center">
                <i class="bi bi-caret-left-fill"></i>
            </a>
            <span class="navbar-brand fw-bold fs-4 mb-0">
                FeetCheck
            </span>
        </div>
    </nav>

    <!-- CART TITLE -->
    <div class="container my-4">
        <h2 class="fw-bold">Your Cart</h2>
    </div>

    <!-- CART ITEMS -->
    <div class="cart-container container my-4">
        <div class="cart-card">
            <img src="images/Vomero5" alt="Shoe">
            <div class="cart-body">
                <h3>Nike Zoom Vomero 5</h3>
                <p class="price">₱4,999</p>
                <p>Quantity: 1</p>
                <button class="remove-btn">Remove</button>
            </div>
        </div>

        <!-- CHECKOUT SECTION -->
        <div class="checkout-section mt-4 text-end">
            <h5 class="mb-3">Total: ₱4,999</h5>
            <button class="btn btn-dark px-4 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                Checkout
            </button>
        </div>
    </div>

    <!-- CHECKOUT MODAL -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Checkout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">

                    <!-- Cart Item -->
                    <div class="d-flex align-items-center mb-3 border-bottom pb-3">
                        <img src="images/Vomero5.jpg" width="90" class="rounded me-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Nike Zoom Vomero 5</h6>
                            <p class="mb-1">₱4,999</p>
                            <small>Quantity: 1</small>
                        </div>
                        <strong>₱4,999</strong>
                    </div>

                    <!-- TOTAL -->
                    <div class="d-flex justify-content-between mt-3">
                        <h6>Total</h6>
                        <h6 class="fw-bold">₱4,999</h6>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-dark fw-bold">
                        Confirm Checkout
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>