<?php
session_start();
include "database_files/connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ui.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT full_name, email, contact_num FROM users WHERE user_id = ?";
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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- ✅ Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="styles/cartstyle.css">

    <!-- ✅ Font styling -->
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.65;
            color: #212529;
        }

        h3 {
            font-weight: 600;
            letter-spacing: -0.3px;
        }

        label {
            font-weight: 500;
        }
    </style>
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

<div class="container my-5" style="max-width:500px;">
    <h3 class="mb-4">Your Profile</h3>

    <?php if (isset($_GET['updated'])): ?>
        <div id="updateAlert" class="alert alert-success text-center">
            ✅ Profile updated successfully
        </div>
    <?php endif; ?>

    <form id="profileForm" action="database_files/updateprofile.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="<?= htmlspecialchars($user['full_name']); ?>"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text"
                   class="form-control"
                   value="<?= htmlspecialchars($user['contact_num']); ?>"
                   disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email"
                   class="form-control"
                   value="<?= htmlspecialchars($user['email']); ?>"
                   disabled>
        </div>

        <button type="button"
                class="btn btn-dark w-100"
                data-bs-toggle="modal"
                data-bs-target="#confirmUpdateModal">
            Save Changes
        </button>

        <hr class="my-4">
        <button type="button"
                class="btn btn-danger w-100"
                data-bs-toggle="modal"
                data-bs-target="#confirmDeleteModal">
            Delete Account
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

                <button type="submit" form="profileForm" class="btn btn-dark">
                    Yes, Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Delete Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Confirm Account Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="mb-0">
                    Are you sure you want to delete your account?<br>
                    <strong>This action cannot be undone.</strong>
                </p>
            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Cancel
                </button>

                <form action="database_files/delete_account.php" method="POST">
                    <button type="submit" class="btn btn-danger">
                        Yes, Delete
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
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
