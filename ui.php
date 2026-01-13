<?php
session_start();
include "database_files/connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>FeetCheck</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="styles/design.css">
  <link rel="stylesheet" href="styles/nav.css">
  <link rel="stylesheet" href="styles/sidebar.css">
</head>



<body>

<?php if (isset($_GET['added'])): ?>
  <div id="cartAlert" class="alert alert-success text-center mx-4 mt-3">
      ✅ Item added to cart
  </div>
<?php endif; ?>



  <!-- Navbar -->
<nav class="navbar navbar-dark bg-black px-4 d-flex justify-content-between align-items-center sticky-top">
    <span class="navbar-brand fw-bold fs-4" onclick="window.scrollTo({top:0, behavior:'smooth'});">FeetCheck</span>

    <!-- Notification Alert -->
<div id="notificationAlert" class="alert alert-info alert-dismissible fade" role="alert"
     style="position: fixed; top: 70px; left: 50%; transform: translateX(-50%); z-index: 1055; min-width: 300px; max-width: 500px;">
  <span id="alertMessage"></span>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

    <?php if(isset($_SESSION['user_id'])): ?>
        <!-- Logged in -->
        <div class="d-flex align-items-center gap-3">
            <a href="cart.php" class="text-white fs-2">
                <i class="bi bi-cart"></i>
            </a>
            <i class="bi bi-list fs-2 text-white" data-bs-toggle="offcanvas" data-bs-target="#mobile-menu"></i>
        </div>
    <?php else: ?>
        <!-- Not logged in -->
        <div class="d-flex align-items-center gap-3">
            <a href="#" class="nav-link login-link" data-bs-toggle="modal" data-bs-target="#loginModal">Log In</a>
            <a href="#" class="nav-link signup-link" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</a>
        </div>
    <?php endif; ?>
</nav>

  <!-- Sidebar Menu -->
  <div class="offcanvas offcanvas-end" id="mobile-menu">
    <div class="offcanvas-header pb-0">
      <h4 class="offcanvas-title fw-bold">Menu</h4>
      <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column">
      <div class="list-group sidebar-menu">
        <a href="ui.php" class="list-group-item list-group-item-action">
          <i class="bi bi-house me-2"></i> Home
        </a>
       <a href="profile.php" class="list-group-item list-group-item-action">
         <i class="bi bi-person-circle"></i> Profile
        </a>
       <a href="orders.php" class="list-group-item list-group-item-action">
       <i class="bi bi-cart-check"></i> Your Orders
        </a>
      <a href="about.php" class="list-group-item list-group-item-action">
          <i class="bi bi-telephone me-2"></i> About us
        </a>
        <a href="database_files/logout.php" class="list-group-item list-group-item-action text-danger">
          <i class="bi bi-box-arrow-right me-2"></i> Log out
        </a>
      </div>
    </div>
  </div>

  <!-- Carousel -->
<div class="carousel-container">
  <div id="heroCarousel" class="carousel slide carousel-fade my-4" data-bs-ride="carousel">

    <!-- ✅ KOBE QUOTE -->
    <div class="hero-quote">
      <p class="quote-text">
        “Everything negative — pressure, challenges — is an opportunity for me to rise.”
      </p>
      <span class="quote-author">— Kobe Bryant</span>
    </div>

    <div class="carousel-inner">
      ...
    </div>

  </div>
</div>

    <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="images/carouselpic.png" class="d-block w-100" alt="Shoe 1">
        </div>
        <div class="carousel-item">
          <img src="images/shoepic.jpg" class="d-block w-100" alt="Shoe 2">
        </div>
        <div class="carousel-item">
          <img src="images/dbook.jpg" class="d-block w-100" alt="Shoe 3">
        </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Next</span>
      </button>

      <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"
          aria-current="true"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
      </div>
    </div>
  </div>

  <!-- PRODUCT CARDS -->
  <div class="card-container my-4">
<?php
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $id    = $row['product_id'];
    $name  = $row['name'];
    $price = $row['price'];
    $image = $row['image'];
?>
    <div class="product-card">
        <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>">
        <div class="card-body">
            <h3><?php echo $name; ?></h3>
            <p class="price">₱<?php echo number_format($price, 2); ?></p>
           <button class="btn btn-dark add-to-cart-btn"
    data-bs-toggle="modal"
    data-bs-target="#addToCartModal"
    data-id="<?php echo $id; ?>"
    data-name="<?php echo $name; ?>"
    data-price="<?php echo $price; ?>"
    data-image="<?php echo $image; ?>">
    Add to Cart
</button>

        </div>
    </div>
<?php
}
?>
</div>

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Log In</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="database_files/login.php" method="POST">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Log In</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Sign Up Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sign Up</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="database_files/register.php" method="POST">
                    <div class="mb-3">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                     <div class="mb-3">
            <label>Contact Number</label>
            <input
                type="text"
                class="form-control"
                name="contact_num"
                placeholder="09XXXXXXXXX"
                required
            >
        </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Add to Cart Modal -->
<div class="modal fade" id="addToCartModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form action="addtocart.php" method="POST" class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add to Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <img id="modalProductImage" src="" class="img-fluid rounded-top"
           style="width:100%; max-height:280px; object-fit:cover;">

      <div class="modal-body text-center">
        <h5 id="modalProductName"></h5>
        <p class="fw-bold">₱<span id="modalProductPrice"></span></p>

        <!-- HIDDEN INPUTS -->
        <input type="hidden" name="product_id" id="modalProductId">
<input type="hidden" name="name" id="modalProductNameInput">
        <input type="hidden" name="price" id="modalProductPriceInput">
        <input type="hidden" name="image" id="modalProductImageInput">

        <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
          <label class="fw-bold">Quantity:</label>
          <input type="number" name="quantity" id="quantity"
                 class="form-control w-25" value="1" min="1" required>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-dark">Confirm</button>
      </div>

    </form>
  </div>
</div>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <script src="script/addbuttonscript.js"></script>
  <script src="script/alerts.js"></script>
  <script>
const alertBox = document.getElementById('cartAlert');
if (alertBox) {
  setTimeout(() => {
    alertBox.style.opacity = '0';
    setTimeout(() => alertBox.remove(), 500);
  }, 3000);
}
</script>

<script>
  if (window.location.search.includes('added=1')) {
    setTimeout(() => {
      const url = new URL(window.location);
      url.searchParams.delete('added');
      window.history.replaceState({}, document.title, url.pathname);
    }, 3100); // slightly after alert fades
  }
</script>


</body>

</html>