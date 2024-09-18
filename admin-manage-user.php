<?php
$page_name = "Admin";
include('nav-and-footer/header-nav.php');

$user_id = $_SESSION['admin_id'];
$security_key = $_SESSION['security_key'];

if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

$user_role = $_SESSION['user_role'];
if ($user_role != 1) {
    header('Location: task-info.php');
}

if (isset($_GET['delete_user'])) {
    // Handle user deletion
}

if (isset($_POST['add_new_employee'])) {
    $error = $obj_admin->add_new_user($_POST);
}
?>

<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="well well-custom">
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <div class="btn-group">
                            <button class="btn btn-primary-custom btn-menu" data-toggle="modal" data-target="#myModal">Add New Employee</button>
                        </div>
                        <center><h3>Manage Employee</h3></center>
                        <div class="gap"></div>
                        <div class="gap"></div>
                        <ul class="nav nav-tabs nav-justified nav-tabs-custom">
                            <li><a href="manage-admin.php" class="btn btn-primary btn-xs mb-3 mr-4 mt-3">Manage Admin</a></li>
                            <li class="active"><a href="admin-manage-user.php" class="btn btn-outline-primary btn-xs mb-3 mt-3 disabled-link">Manage Employee</a></li>
                        </ul>

                        <div class="table-responsive">
                            <table id="group-b" class="table table-condensed table-custom table-hover">
                                <thead class="text-uppercase bg-primary text-white">
                                    <tr>
                                        <th>Serial No.</th>
                                        <th>Fullname</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Temp Password</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 ORDER BY user_id DESC";
                                    $info = $obj_admin->manage_all_info($sql);
                                    $serial  = 1;
                                    $num_row = $info->rowCount();
                                    if ($num_row == 0) {
                                        echo '<tr><td colspan="7">No Data found</td></tr>';
                                    }
                                    while ($row = $info->fetch(PDO::FETCH_ASSOC)) :
                                    ?>
                                        <tr>
                                            <td><?php echo $serial; $serial++; ?></td>
                                            <td><?php echo $row['fullname']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['temp_password']; ?></td>

                                            <td>
                                                <a title="Update Employee" href="update-employee.php?admin_id=<?php echo $row['user_id']; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                                <a title="Delete" href="?delete_user=delete_user&admin_id=<?php echo $row['user_id']; ?>" onclick=" return check_delete();"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for employee add -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Add Employee Info</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                    <form role="form" action="" method="post" autocomplete="off">
    <div class="form-group">
        <label class="control-label">Fullname</label>
        <input type="text" placeholder="Enter Employee Name" name="em_fullname" pattern="[a-zA-Z]+(?:\s+[a-zA-Z]+)*(?:[\s.,]*[a-zA-Z]+)*$" title="Please enter a valid name (letters only)" class="form-control input-custom" id="fullname" required oninput="validateFullname()">

    </div>
    <div class="form-group">
        <label class="control-label">Username</label>
        <input type="text" placeholder="Enter Employee Username" name="em_username" class="form-control input-custom" required>
    </div>
    <div class="form-group">
        <label class="control-label">Email</label>
        <input type="email" placeholder="Enter Employee Email" name="em_email" class="form-control input-custom" required>
    </div>
    <div class="form-group text-center">
        <button type="submit" name="add_new_employee" class="btn btn-primary rounded-0 mr-4">Add Employee</button>
        <button type="button" class="btn btn-default rounded-0" data-dismiss="modal">Cancel</button>
    </div>
</form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

function validateFullname() {
        var fullnameInput = document.getElementById('fullname');
        var fullname = fullnameInput.value;

        // Regular expression to match any digit
        var regex = /\d/;

        if (regex.test(fullname)) {
            // If a digit is found, clear the input value and show an error message
            fullnameInput.value = '';
            fullnameInput.setCustomValidity('Fullname cannot contain numbers.');
        } else {
            // If no digit is found, clear any existing error message
            fullnameInput.setCustomValidity('');
        }
    }


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
