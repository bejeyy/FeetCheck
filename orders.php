<?php
session_start();
include "database_files/connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ui.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get user orders
$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$orders = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="styles/cartstyle.css">
    
</head>
<body>

<nav class="navbar navbar-dark bg-black px-4 sticky-top">
        <div class="d-flex align-items-center">
            <a href="ui.php" class="text-white fs-4 me-2 d-flex align-items-center">
                <i class="bi bi-caret-left-fill"></i>
            </a>
            <span class="navbar-brand fw-bold fs-4 mb-0">
                Back
            </span>
        </div>
    </nav>

<div class="container my-4">
    <h3 class="fw-bold mb-4">🧾 Your Orders</h3>

<?php if (mysqli_num_rows($orders) === 0): ?>
    <div class="alert alert-secondary">
        You have no orders yet.
    </div>
<?php else: ?>

<?php while ($order = mysqli_fetch_assoc($orders)): ?>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <span>
                <strong>Order #<?= $order['order_id']; ?></strong>
            </span>
            <span>
                <?= date("M d, Y h:i A", strtotime($order['created_at'])); ?>
            </span>
        </div>

        <div class="card-body">
            <?php
            $sqlItems = "
              SELECT oi.quantity, oi.price, p.name, p.image
                FROM order_items oi
                    JOIN products p ON oi.product_id = p.product_id
                        WHERE oi.order_id = ?

            ";
            $stmtItems = mysqli_prepare($conn, $sqlItems);
            mysqli_stmt_bind_param($stmtItems, "i", $order['order_id']);
            mysqli_stmt_execute($stmtItems);
            $items = mysqli_stmt_get_result($stmtItems);
            ?>

            <ul class="list-group mb-3">
<?php while ($item = mysqli_fetch_assoc($items)): ?>
    <li class="list-group-item d-flex align-items-center gap-3">

        <!-- PRODUCT IMAGE -->
        <img src="<?= htmlspecialchars($item['image']); ?>"
             width="60"
             class="rounded">

        <!-- PRODUCT DETAILS -->
        <div class="flex-grow-1">
            <strong><?= htmlspecialchars($item['name']); ?></strong><br>
            Qty: <?= (int)$item['quantity']; ?>
        </div>

        <!-- PRICE -->
        <div class="fw-bold">
            ₱<?= number_format($item['price'], 2); ?>
        </div>

    </li>
<?php endwhile; ?>
</ul>


            <div class="text-end fw-bold">
                Total: ₱<?= number_format($order['total'], 2); ?>
            </div>
        </div>
    </div>
<?php endwhile; ?>

<?php endif; ?>
</div>

</body>
</html>
