
<?php

$page_name="Admin";
include('nav-and-footer/header-nav.php');

// require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: login_and_sign-in_form.php');
}


$admin_id = $_GET['admin_id'];

if(isset($_POST['update_current_employee'])){
    $obj_admin->update_admin_data($_POST,$admin_id);
}

if(isset($_POST['btn_user_password'])){
    $obj_admin->update_user_password($_POST,$admin_id);
}

$sql = "SELECT * FROM tbl_admin WHERE user_id='$admin_id' ";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);
             
// $page_name="Admin";
// include("include/sidebar.php");

?>
<!-- Bootstrap Grid start -->
<div class="col-12 mt-4">
    <div class="card">
        <div class="card-body">
            <!-- Start 12 column grid system -->
            <div class="row justify-content-center"> <!-- Center the content -->
                <div class="col-md-10"> <!-- Adjust column size to fit the content -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well well-custom">
                                <ul class="nav nav-tabs nav-justified nav-tabs-custom">
                                    <li><a href="manage-admin.php" class="btn btn-primary btn-xs mb-3 mr-4">Manage Admin</a></li>
                                    <li><a href="admin-manage-user.php" class="btn btn-primary btn-xs mb-3">Manage Employee</a></li>
                                </ul>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="well" style="background:#fff !important">
                                            <h3 class="text-center bg-primary" style="padding: 7px;">Edit Admin</h3><br>
                                            <form class="form-horizontal" role="form" action="" method="post" autocomplete="off">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label text-right">Fullname</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" value="<?php echo $row['fullname']; ?>" placeholder="Enter Employee Name" name="em_fullname" list="expense" class="form-control rounded-0" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label text-right">Username</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" value="<?php echo $row['username']; ?>" placeholder="Enter Employee username" name="em_username" class="form-control rounded-0" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label text-right">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" value="<?php echo $row['email']; ?>" placeholder="Enter Employee Email" name="em_email" class="form-control rounded-0" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-10 offset-sm-2">
                                                        <button type="submit" name="update_current_employee" class="btn btn-primary-custom">Update Now</button>
                                                    </div>
                                                </div>
                                            </form> 
                                            <div class="col-md-5 offset-md-2">
                                                <a href="admin-password-change.php?admin_id=<?php echo $row['user_id'];?>">Change Password</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap Grid end -->



<?php

include("etms/include/footer.php");
include("nav-and-footer/footer-area.php");


?>
