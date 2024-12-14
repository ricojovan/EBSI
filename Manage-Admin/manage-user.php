<?php
$page_name = "Admin";
include('../nav-and-footer/header-nav.php');

// Database connection
$host_name = 'localhost';
$user_name = 'root';
$password = '';
$db_name = 'ebsi_db';

var_dump($_SESSION);

try {
    $db = new PDO("mysql:host=$host_name;dbname=$db_name", $user_name, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function delete_user_by_id($emp_id, $db)
{
    try {
        $stmt = $db->prepare("DELETE FROM employees WHERE emp_id = :emp_id");
        $stmt->bindParam(':emp_id', $emp_id, PDO::PARAM_STR);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error deleting user: " . $e->getMessage());
        return false;
    }
}

$user_id = $_SESSION['admin_id'];
$security_key = $_SESSION['security_key'];

if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

$user_role = $_SESSION['user_role'];
if ($user_role != 1) {
    header('Location: ../index.php');
}

if (isset($_GET['delete_user']) && isset($_GET['emp_id'])) {
    $admin_id = $_GET['emp_id'];
    $delete_result = delete_user_by_id($admin_id, $db);
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
                                        <th>Employee ID</th>
                                        <th>Full name</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Temp Password</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM employees ORDER BY emp_id DESC";
                                    $info = $obj_admin->manage_all_info($sql);
                                    $serial  = 1;
                                    $num_row = $info->rowCount();
                                    if ($num_row == 0) {
                                        echo '<tr><td colspan="7" class="text-center">No Data found</td></tr>';
                                    }
                                    while ($row = $info->fetch(PDO::FETCH_ASSOC)) :
                                    ?>
                                        <tr>
                                            <td><?php echo $row['emp_id']; ?></td>
                                            <td><?php echo $row['emp_name']; ?></td>
                                            <td><?php echo $row['emp_email_addr']; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['temp_password']; ?></td>
                                            <td>
                                                <a title="Update Employee" href="../Manage-Employee/emp-update.php?emp_id=<?php echo $row['emp_id']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a title="Delete" href="?delete_user=delete_user&emp_id=<?php echo htmlspecialchars($row['emp_id']); ?>"
                                                    onclick="return check_delete();" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
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
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Add New Employee</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                    <h5 class="border-bottom pb-2 mb-3">Personal Information</h5>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Employee ID</label>
                                <input type="text" placeholder="Enter Employee ID" name="em_id" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="username" class="control-label">Username</label>
                                <input type="text" name="em_username" placeholder="Enter username" name="username" id="username" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Profile Picture</label>
                                <input type="file" name="em_prof_pic" style="padding: 0.50rem 0.75rem" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
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
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label d-block">Gender</label>
                                <div class="form-control">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="em_gender" value="Male" class="form-check-input" id="genderMale" required>
                                        <label class="form-check-label" for="genderMale">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="em_gender" value="Female" class="form-check-input" id="genderFemale" required>
                                        <label class="form-check-label" for="genderFemale">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="em_gender" value="Other" class="form-check-input" id="genderOther" required>
                                        <label class="form-check-label" for="genderOther">Other</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Date of Birth</label>
                                <input type="date" name="em_dob" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Civil Status</label>
                                <select name="em_civ_stat" style="height: calc(2.4em + 0.73rem + 2px); padding: 0.375rem 0.75rem" class="form-control" required>
                                    <option value="" disabled selected>Select your status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widow/er">Widow/er</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label">Email Address</label>
                                <input type="email" placeholder="Enter Email Address" name="em_email" class="form-control" id="email" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" class="control-laberl">Mobile Number</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+63</span>
                                    </div>
                                    <input
                                        type="tel"
                                        class="form-control"
                                        placeholder="Enter mobile number"
                                        name="em_mobile"
                                        id="mobile"
                                        pattern="[0-9]{10-11}"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="border-bottom pb-2 mb-3">Address</h5>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="home_addr">Home Address</label>
                                <textarea class="form-control" name="em_home_addr" style="resize: none" id="home_addr" rows="2" placeholder="Building/Lot No., House No., Street Name, Barangay, City"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="curr_addr">Current Address</label>
                                <textarea class="form-control" name="em_curr_addr" style="resize: none" id="curr_addr" rows="2" placeholder="Building/Lot No., House No., Street Name, Barangay, City"></textarea>
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="sameAsHome" disabled>
                                    <label class="form-check-label" for="sameAsHome">Same as Home Address</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <h5 class="border-bottom pb-2 mb-3">Employment Information</h5>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Hired Date</label>
                                <input type="date" name="em_hire_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Department</label>
                                <select name="em_dept" id="department" style="height: calc(2.4em + 0.73rem + 2px); padding: 0.375rem 0.75rem" class="form-control" required>
                                    <option value="" disabled selected>Select Department</option>
                                    <option value="Accounting and Finance">Accounting and Finance</option>
                                    <option value="Building Admin">Building Admin</option>
                                    <option value="Information Technology">Information Technology</option>
                                    <option value="Human Resources">Human Resources</option>
                                    <option value="Sales">Sales</option>
                                    <option value="Market">Mar keting</option>
                                    <option value="Chapel and Columbarium">Chapel and Columbarium</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Position</label>
                                <select id="position" name="em_pos" style="height: calc(2.4em + 0.73rem + 2px); padding: 0.375rem 0.75rem" class="form-control" required>
                                    <option value="" disabled selected>Select Department first</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Employee Type</label>
                                <select name="em_type" class="form-control" style="height: calc(2.4em + 0.73rem + 2px); padding: 0.375rem 0.75rem" required>
                                    <option value="" disabled selected>Select status</option>
                                    <option value="Probationary">Probationary</option>
                                    <option value="Regular">Regular</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Pay Type</label>
                                <select name="em_pType" class="form-control" style="height: calc(2.4em + 0.73rem + 2px); padding: 0.375rem 0.75rem" required>
                                    <option value="" disabled selected>Select pay type</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Daily">Daily</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="taxStat" class="control-label">Tax Status</label>
                                <select id="taxStat" name="em_taxStat" class="form-control" style="height: calc(2.4em + 0.73rem + 2px); padding: 0.375rem 0.75rem" required>
                                    <option value="" disabled selected>Select tax status</option>
                                    <option value="Tax Exempted">Tax Exempted</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="basic_salary" class="control-label">Basic Salary</label>
                                <input type="number" name="em_basic_sal" id="basic_salary" style="height: calc(2.4em + 0.73rem + 2px); padding: 0.375rem 0.75rem" class="form-control" step="0.01" placeholder="Enter Basic Salary">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="monthly_rate" class="control-label">Monthly Rate</label>
                                <input type="number" name="em_mRate" id="monthly_rate" style="height: calc(2.4em + 0.73rem + 2px); padding: 0.375rem 0.75rem" class="form-control" step="0.01" placeholder="Enter monthly rate">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="daily_rate" class="control-label">Daily Rate</label>
                                <input type="number" name="em_dRate" id="daily_rate" style="height: calc(2.4em + 0.73rem + 2px); padding: 0.375rem 0.75rem" class="form-control" step="0.01" placeholder="Enter daily rate">
                            </div>
                        </div>
                    </div>

                    <h5 class="border-bottom pb-2 mb-3">Government Identification</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sss_no" class="control-label">SSS Number</label>
                                <input type="text" name="em_sss_no" id="sss_no" style="height: calc(2.4em + 0.73rem + 2px); padding: 0.375rem 0.75rem" class="form-control" placeholder="Enter SSS Number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="philhealth_no" class="control-label">PhilHealth Number</label>
                                <input type="text" name="em_phealth_no" id="phealth_no" style="height: calc(2.4em + 0.73rem + 2px); padding: 0.375rem 0.75rem" class="form-control" placeholder="Enter PhilHealth Number">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pagibig_no" class="control-label">Pag-Ibig Number</label>
                                <input type="text" name="em_pagibig_no" id="pagibig_no" style="height: calc(2.4em + 0.73rem + 2px); padding: 0.375rem 0.75rem" class="form-control" placeholder="Enter Pag-Ibig Number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tin_no" class="control-label">TIN Number</label>
                                <input type="text" name="em_tin_no" id="tin_no" style="height: calc(2.4em + 0.73rem + 2px); padding: 0.375rem 0.75rem" class="form-control" placeholder="Enter TIN Number">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_new_employee" class="btn btn-primary">Add Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // const cities = ['Manila', 'Quezon City', 'Makati', 'Pasig', 'Taguig', 'Caloocan', 'Muntinlupa', 'Paranaque', 'Malabon', 'Mandaluyong'];

    // const brgysPerCity = {

    // };
    const homeAddressField = document.getElementById('home_addr');
    const currentAddressField = document.getElementById('curr_addr');
    const checkbox = document.getElementById('sameAsHome');

    homeAddressField.addEventListener('input', function() {
        if (this.value.trim() !== "") {
            checkbox.disabled = false;
        } else {
            checkbox.disabled = true;
            checkbox.checked = false;
            currentAddressField.removeAttribute('readonly');
            currentAddressField.value = "";
        }
    });

    checkbox.addEventListener('change', function() {
        if (this.checked) {
            currentAddressField.value = homeAddressField.value;
            currentAddressField.setAttribute('readonly', 'readonly');
        } else {
            currentAddressField.removeAttribute('readonly');
            currentAddressField.value = "";
        }
    });

    const positionsByDepartment = {
        "Accounting and Finance": [
            'A&F Manager', 'Treasury Manager', 'Credit & Collection Supervisor', 'Accounting Supervisor', 'APV Comm Staff',
            'Collector/Messenger', 'Credit & Collection Staff', 'Credit & Collection Officer', 'Cashier', 'Chief Financial Officer (CFO)'
        ],
        "Building Admin": [
            'General Services, Property & Construction Manager', 'Admin-Receptionist', 'Safety Officer', 'Building Administrator', 'STP Staff',
            'Building Maintenance Staff', 'Housekeeping Staff', 'Company Driver', 'Security Guard', 'Chief Operating Officer (COO)'
        ],
        "Information Technology": ['IT Manager', 'IT Staff'],
        "Human Resources": ['HRAD Manager', 'HR Officer'],
        "Sales": [
            'Sales Manager', 'Sales Officer', 'Agent Broker Admin', 'Vault Admin', 'Marketing',
            'Marketing Manager', 'Marketing Coordinator'
        ],
        "Chapel and Columbarium": [
            'Chapel & Funeral Services Director', 'Chapel & Funeral Services Manager', 'Embalmer', 'Family Care Officer', 'Chapel Liaison Staff',
            'Chapel & Funeral Services Business Development Officer', 'Client Relation Officer', 'Client Relation Staff', 'Multimedia Artist'
        ]
    };

    const departmentSelect = document.getElementById('department');
    const positionSelect = document.getElementById('position');

    departmentSelect.addEventListener("change", function() {
        const selectedDepartment = this.value;
        positionSelect.innerHTML = '<option value="" disabled selected>Select Position</option>';
        if (positionsByDepartment[selectedDepartment]) {
            positionsByDepartment[selectedDepartment].forEach(position => {
                const option = document.createElement("option");
                option.value = position;
                option.textContent = position;
                positionSelect.appendChild(option);
            });
        }
    });

    function validateFullname() {
        var fullnameInput = document.getElementById('fullname');
        var fullname = fullnameInput.value;
        var regex = /\d/;
        if (regex.test(fullname)) {
            fullnameInput.value = '';
            fullnameInput.setCustomValidity('Fullname cannot contain numbers.');
        } else {
            fullnameInput.setCustomValidity('');
        }
    }

    document.querySelectorAll('.disabled-link').forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
        });
    });

    function check_delete() {
        return confirm('Are you sure you want to delete this user?');
    }
</script>

<?php
if (isset($_SESSION['update_user_pass'])) {
    echo '<script>alert("Password updated successfully");</script>';
    unset($_SESSION['update_user_pass']);
}

include("../nav-and-footer/footer-area.php");
?>