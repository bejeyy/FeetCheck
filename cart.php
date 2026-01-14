<?php
session_start();
include "database_files/connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare("
    SELECT 
        c.product_id,
        c.quantity,
        p.name,
        p.price,
        p.image
    FROM cart c
    JOIN products p ON c.product_id = p.product_id
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$cart = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="styles/cartstyle.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-black px-4 sticky-top">
        <div class="d-flex align-items-center">
            <a href="ui.php" class="text-white fs-4 me-2 d-flex align-items-center">
                <i class="bi bi-caret-left-fill"></i>
            </a>
            <span class="navbar-brand fw-bold fs-4 mb-0">
                FeetCheck
            </span>
        </div>
    </nav>

<div class="container my-4">
    <h2 class="fw-bold">Your Cart</h2>

<?php if ($cart->num_rows === 0): ?>

    <!-- EMPTY CART -->
    <div class="alert alert-secondary mt-4">
        Your cart is empty.
    </div>

<?php else: ?>

    <!-- CART ITEMS -->
    <?php 
    $total = 0;

    while ($item = $cart->fetch_assoc()): 
        if ($item['quantity'] <= 0) continue;

        $product_id = $item['product_id'];
        $subtotal   = $item['price'] * $item['quantity'];
        $total     += $subtotal;
    ?>
        <div class="d-flex align-items-center border rounded p-3 mb-3">
            <img src="<?= htmlspecialchars($item['image']); ?>" width="90" class="me-3 rounded">

            <div class="flex-grow-1">
                <h5 class="mb-1"><?= htmlspecialchars($item['name']); ?></h5>
                <p class="mb-1">₱<?= number_format($item['price'], 2); ?></p>

                <!-- QUANTITY CONTROLS -->
                <form method="POST" action="database_files/update_cart.php"
                      class="d-flex align-items-center gap-2">

                    <input type="hidden" name="product_id" value="<?= $product_id; ?>">

                    <button type="submit"
                            name="action"
                            value="decrease"
                            class="btn btn-outline-dark btn-sm">−</button>

                    <input type="number"
                        name="quantity"
                        value="<?= (int)$item['quantity']; ?>"
                        min="1"
                        max="5"
                        class="form-control text-center"
                        style="width:60px">

                    <button type="submit"
                            name="action"
                            value="increase"
                            class="btn btn-outline-dark btn-sm">+</button>
                </form>
            </div>

            <div class="text-end">
                <p class="fw-bold">₱<?= number_format($subtotal, 2); ?></p>

                <form action="database_files/remove_from_cart.php" method="POST">
                  <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                    <button type="button"
                            class="btn btn-sm btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#removeModal"
                            data-id="<?= $product_id; ?>">
                        Remove
                   </button>
                </form>
            </div>
        </div>

    <?php endwhile; ?>

    <!-- TOTAL -->
    <div class="text-end mt-4">
        <h4>Total: ₱<?= number_format($total, 2); ?></h4>
       <button class="btn btn-dark px-4 py-2 fw-bold"
        data-bs-toggle="modal"
        data-bs-target="#checkoutModal">
    Checkout
</button>

    </div>

<?php endif; ?>
</div>

<!-- Remove Confirmation Modal -->
<div class="modal fade" id="removeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Confirm Removal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <p class="mb-0">Do you want to remove this item from your cart?</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Cancel
        </button>

        <!-- POST form for removal -->
        <form id="confirmRemoveForm" method="POST" action="database_files/remove_from_cart.php">
          <input type="hidden" name="product_id" id="removeProductId">
          <button type="submit" class="btn btn-danger">Yes, Remove</button>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- Checkout Confirmation Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Confirm Checkout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <p class="mb-0">
          Are you sure you want to proceed to checkout?
        </p>
      </div>

      <div class="modal-footer">
        <button type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal">
          Cancel
        </button>

        <a href="checkout.php" class="btn btn-dark">
          Yes, Checkout
        </a>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
const removeModalEl = document.getElementById('removeModal');
const removeInput = document.getElementById('removeProductId');

removeModalEl.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const productId = button.getAttribute('data-id');
    removeInput.value = productId;
});
</script>

</body>
</html>
