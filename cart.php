<?php
session_start();
include "database_files/connection.php";

/**
 * Initialize cart safely
 */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/**
 * UPDATE QUANTITY (+ / −)
 */
if (isset($_POST['update_qty'])) {
    $id  = (int) $_POST['product_id'];
    $qty = (int) $_POST['quantity'];

    if ($qty <= 0) {
        unset($_SESSION['cart'][$id]); // remove item if 0
    } else {
        $_SESSION['cart'][$id]['quantity'] = $qty;
    }

    header("Location: cart.php");
    exit;
}

/**
 * Remove item from cart
 */
if (isset($_GET['remove'])) {
    $remove_id = (int) $_GET['remove'];

    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }

    header("Location: cart.php");
    exit;
}

$cart  = $_SESSION['cart'];
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-black px-4">
    <a href="ui.php" class="text-white text-decoration-none fw-bold fs-4">
        ← FeetCheck
    </a>
</nav>

<div class="container my-4">
    <h2 class="fw-bold">Your Cart</h2>

<?php if (empty($cart)): ?>

    <!-- EMPTY CART -->
    <div class="alert alert-secondary mt-4">
        Your cart is empty.
    </div>

<?php else: ?>

    <!-- CART ITEMS -->
    <?php foreach ($cart as $product_id => $item): 
        if ($item['quantity'] <= 0) continue;

        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    ?>
        <div class="d-flex align-items-center border rounded p-3 mb-3">
            <img src="<?= htmlspecialchars($item['image']); ?>" width="90" class="me-3 rounded">

            <div class="flex-grow-1">
                <h5 class="mb-1"><?= htmlspecialchars($item['name']); ?></h5>
                <p class="mb-1">₱<?= number_format($item['price'], 2); ?></p>

                <!-- QUANTITY CONTROLS -->
                <form method="POST" class="d-flex align-items-center gap-2">
                    <input type="hidden" name="product_id" value="<?= $product_id; ?>">

                    <button type="submit" name="update_qty"
                        onclick="this.nextElementSibling.stepDown()"
                        class="btn btn-outline-dark btn-sm">−</button>

                    <input type="number"
                        name="quantity"
                        value="<?= (int)$item['quantity']; ?>"
                        min="1"
                        class="form-control text-center"
                        style="width:60px">

                    <button type="submit" name="update_qty"
                        onclick="this.previousElementSibling.stepUp()"
                        class="btn btn-outline-dark btn-sm">+</button>
                </form>
            </div>

            <div class="text-end">
                <p class="fw-bold">₱<?= number_format($subtotal, 2); ?></p>
              <button class="btn btn-sm btn-danger"
        data-bs-toggle="modal"
        data-bs-target="#removeModal"
        data-id="<?= $product_id; ?>">
    Remove
</button>


            </div>
        </div>
    <?php endforeach; ?>

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
        <a href="#" id="confirmRemoveBtn" class="btn btn-danger">
          Yes, Remove
        </a>
      </div>

    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
const removeModal = document.getElementById('removeModal');
const confirmBtn = document.getElementById('confirmRemoveBtn');

removeModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const productId = button.getAttribute('data-id');

    confirmBtn.href = 'cart.php?remove=' + productId;
});
</script>

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


</body>
</html>
