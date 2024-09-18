<?php
$page_name = "Login";
require 'etms/authentication.php'; // admin authentication check 
include("etms/include/login_header.php");

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

<div class="container-fluid" style="background-color: #B8E3FF;">
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">Change Password</h2>
                </div>
                <div class="card-body">
                    <?php if (isset($info)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $info; ?>
                        </div>
                    <?php } ?>
                    <form class="form-horizontal" action="" method="POST">
                        <input type="hidden" class="form-control" name="user_id" value="<?php echo $user_id; ?>" required />
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="New Password" name="password" required />
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Confirm New Password" name="re_password" required />
                        </div>
                        <button type="submit" name="change_password_btn" class="btn btn-primary btn-block">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("etms/include/footer.php");
?>
