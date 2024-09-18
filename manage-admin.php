<?php
$page_name = "Admin";
include('nav-and-footer/header-nav.php');

// require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: login_and_sign-in_form.php');
}

// check admin
$user_role = $_SESSION['user_role'];
if ($user_role != 1) {
    header('Location: task-info.php');
}

?>

<!-- Bootstrap Grid start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well well-custom">
                                <ul class="nav nav-pills">
                                    <li class="active"><a href="manage-admin.php" class="btn btn-outline-primary btn-xs mb-3 mr-4 disabled-link" disabled>Manage Admin</a></li>
                                    <li><a href="admin-manage-user.php" class="btn btn-primary btn-xs mb-3">Manage Employee</a></li>
                                </ul>

                                <center>
                                    <h3>Manage Admin</h3>
                                </center>
                                <div class="gap"></div>
                                <div class="table-responsive">
                                    <table id="group-a" class="table table-codensed table-custom table-hover">
                                        <thead class="text-uppercase bg-primary text-white">
                                            <tr>
                                                <th>Serial No.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Username</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $sql = "SELECT * FROM tbl_admin WHERE user_role = 1";
                                            $info = $obj_admin->manage_all_info($sql);

                                            $serial  = 1;
                                            $total_expense = 0.00;
                                            while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $serial;
                                                        $serial++; ?></td>
                                                    <td><?php echo $row['fullname']; ?></td>
                                                    <td><?php echo $row['email']; ?></td>
                                                    <td><?php echo $row['username']; ?></td>

                                                    <td><a title="Update Admin" href="update-admin.php?admin_id=<?php echo $row['user_id']; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;</td>
                                                </tr>

                                            <?php  } ?>

                                        </tbody>
                                    </table>
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

<script>
    // JavaScript to prevent the default action of the link
    document.querySelectorAll('.disabled-link').forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
        });
    });
</script>

<?php
if (isset($_SESSION['update_user_pass'])) {
    echo '<script>alert("Password updated successfully");</script>';
    unset($_SESSION['update_user_pass']);
}
include("etms/include/footer.php");
include("nav-and-footer/footer-area.php");
?>
