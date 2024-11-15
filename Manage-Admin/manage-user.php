<?php
$page_name = "Admin";
include('../nav-and-footer/header-nav.php');

$user_id = $_SESSION['admin_id'];
$security_key = $_SESSION['security_key'];

if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

$user_role = $_SESSION['user_role'];
if ($user_role != 1) {
    header('Location: ../Interface/login.php');
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

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="btn-group" role="group">
                                <a href="../Manage-Admin/manage-admin.php" class="btn btn-outline-primary">Manage Admin</a>
                                <a href="../Manage-Admin/manage-user.php" class="btn btn-default disabled-link" disabled>Manage Employee</a>
                            </div>
                            <button class="btn btn-success" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus"></i> Add New Employee
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table id="group-b" class="table table-striped table-custom table-hover">
                                <thead class="table-bg-default text-white">
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
                                    $sql = "SELECT * FROM tbl_admin WHERE user_role IN (2,3) ORDER BY user_id DESC";
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
                                                <a title="Update Employee" href="../Manage-Employee/emp-update.php?admin_id=<?php echo $row['user_id']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a title="Delete" href="?delete_user=delete_user&admin_id=<?php echo $row['user_id']; ?>" onclick=" return check_delete();" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
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
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Add New Employee</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                    
                    <!-- Basic Information -->
                    <h5 class="border-bottom pb-2">Basic Information</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Employee ID</label>
                                <input type="text" placeholder="Enter Employee ID" name="em_id" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Profile Picture</label>
                                <input type="file" name="em_profile_pic" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <!-- Name Information -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Last Name</label>
                                <input type="text" placeholder="Enter Last Name" name="em_lastname" pattern="[a-zA-Z]+(?:\s+[a-zA-Z]+)*(?:[\s.,]*[a-zA-Z]+)*$" title="Please enter a valid Last Name (letters only)" class="form-control" id="lastname" required oninput="validateFullname()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">First Name</label>
                                <input type="text" placeholder="Enter First Name" name="em_firstname" pattern="[a-zA-Z]+(?:\s+[a-zA-Z]+)*(?:[\s.,]*[a-zA-Z]+)*$" title="Please enter a valid first name (letters only)" class="form-control" id="firstname" required oninput="validateFullname()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Middle Name (Optional)</label>
                                <input type="text" placeholder="Enter Middle Name" name="em_middlename" pattern="[a-zA-Z]+(?:\s+[a-zA-Z]+)*(?:[\s.,]*[a-zA-Z]+)*$" class="form-control" id="middlename" oninput="validateFullname()">
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <h5 class="border-bottom pb-2">Account Information</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Username</label>
                                <input type="text" placeholder="Enter Employee Username" name="em_username" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input type="email" placeholder="Enter Employee Email" name="em_email" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information -->
                    <h5 class="border-bottom pb-2">Employment Information</h5>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Department</label>
                                <input type="text" placeholder="Enter Department" name="em_department" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Position</label>
                                <input type="text" placeholder="Enter Position" name="em_position" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Employee Status</label>
                                <select name="em_status" class="form-control" required>
                                    <option value="">Select Status</option>
                                    <option value="regular">Regular</option>
                                    <option value="probationary">Probationary</option>
                                    <option value="contractual">Contractual</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Role</label>
                                <select name="em_role" class="form-control" required>
                                    <option value="">Select Role</option>
                                    <option value="manager">Manager</option>
                                    <option value="employee">Employee</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right mt-4">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_new_employee" class="btn btn-primary ml-2">Add Employee</button>
                    </div>
                </form>
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

include("../nav-and-footer/footer-area.php");
?>
