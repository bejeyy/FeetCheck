<?php
session_start();
include "database_files/connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ui.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT full_name, email FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-black px-4">
    <a href="ui.php" class="text-white text-decoration-none fw-bold fs-4">
        ← Back
    </a>
</nav>

<div class="container my-5" style="max-width:500px;">
    <h3 class="fw-bold mb-4">Your Profile</h3>

   <?php if (isset($_GET['updated'])): ?>
  <div id="updateAlert" class="alert alert-success text-center">
      ✅ Profile updated successfully
  </div>
<?php endif; ?>


<form id="profileForm" action="database_files/updateprofile.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control"
                   value="<?= htmlspecialchars($user['full_name']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control"
                   value="<?= htmlspecialchars($user['email']); ?>" disabled>
        </div>

       <button type="button"
        class="btn btn-dark w-100"
        data-bs-toggle="modal"
        data-bs-target="#confirmUpdateModal">
    Save Changes
</button>

    </form>
</div>

<!-- Confirm Update Modal -->
<div class="modal fade" id="confirmUpdateModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Confirm Update</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <p class="mb-0">Do you want to save changes to your name?</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Cancel
        </button>

        <!-- REAL submit button -->
        <button type="submit" form="profileForm" class="btn btn-dark">
          Yes, Save
        </button>
      </div>

    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

<script>
const updateAlert = document.getElementById('updateAlert');

if (updateAlert) {
  setTimeout(() => {
    updateAlert.style.opacity = '0';
    setTimeout(() => updateAlert.remove(), 500);
  }, 3000);
}
</script>

<script>
if (window.location.search.includes('updated=1')) {
  setTimeout(() => {
    const url = new URL(window.location);
    url.searchParams.delete('updated');
    window.history.replaceState({}, document.title, url.pathname);
  }, 3100);
}
</script>


</body>
</html>
