<?php
$page_name = "Login";
require '../etms/authentication.php'; // admin authentication check 
include("../etms/include/login_header.php");

// auth check
if (isset($_SESSION['admin_id'])) {
    $user_id = $_SESSION['admin_id'];
    $user_name = $_SESSION['name'];
    $security_key = $_SESSION['security_key'];
}

if (isset($_POST['change_password_btn'])) {
    $info = $obj_admin->change_password_for_employee($_POST);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh; background: linear-gradient(to right, #2193b0, #6dd5ed);">
    <div class="col-md-5">
        <div class="card shadow border-0 rounded-3">
            <div class="card-header bg-primary text-white text-center py-3">
                <h3 class="mb-0 fw-bold">Change Password</h3>
            </div>
            <div class="card-body p-4">
                <?php if (isset($info)) { ?>
                    <div class="alert alert-danger text-center fw-bold" role="alert">
                        <?php echo $info; ?>
                    </div>
                <?php } ?>
                <form action="" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />

                    <!-- New Password -->
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="newPassword" name="password" placeholder="New Password" required />
                        <label for="newPassword">New Password</label>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="confirmPassword" name="re_password" placeholder="Confirm New Password" required />
                        <label for="confirmPassword">Confirm New Password</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" name="change_password_btn" class="btn btn-primary btn-lg w-100">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
include("../etms/include/footer.php");
?>
