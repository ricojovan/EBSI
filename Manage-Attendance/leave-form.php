<?php
$page_name = "Leave Form";
include('../nav-and-footer/header-nav.php');

if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $userId = intval($_GET['user_id']);
} else {
    die("Invalid or missing User ID.");
}

$leaveData = $obj_admin->fetch_leave_data_by_ids($userId);

if (!$leaveData) {
    die("No data found for the given User ID.");
}

$date = new DateTime($leaveData['filed_date']);
$formattedFiledDate = $date->format('Y-m-d');

$date = new DateTime($leaveData['from_date']);
$formattedFromDate = $date->format('Y-m-d');

$date = new DateTime($leaveData['to_date']);
$formattedToDate = $date->format('Y-m-d');

if (isset($_POST['add_leave_data'])) {
    $error = $obj_admin->add_leave_data($_POST);
}
?>


<div class="col-12 mt-3 mb-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="form-container">
                            <h2 class="form-title">E-BRIGHT RETAIL CORP.<br>Leave Form Application</h2>
                            <p class="text-center text-muted">
                                Note: Please make sure to accurately supply all necessary information prior to submission, otherwise the form is invalid.
                            </p>

                            <form id="leaveForm">
                                <div class="row">
                                    <!-- Left column -->
                                    <div class="col-md-6">
                                        <div class="form-section">
                                            <label for="employee-id">Employee ID:</label>
                                            <input type="text" value="<?php echo $userId ?>" id="employee-id" class="form-control" placeholder="Enter employee ID" readonly>
                                        </div>
                                        <div class="form-section">
                                            <label for="employee-name">Employee Name:</label>
                                            <input type="text" value="<?php echo htmlspecialchars($leaveData['fullname']) ?>" id="employee-name" class="form-control" placeholder="Enter employee name" readonly>
                                        </div>
                                        <div class="form-section">
                                            <label for="department">Department:</label>
                                            <input type="text" value="<?php echo htmlspecialchars($leaveData['department']) ?>" id="employee-department" class="form-control" placeholder="Enter department" readonly>
                                        </div>
                                        <div class="form-section">
                                            <label for="employee-status">Employee Status:</label>
                                            <input type="text" value="<?php echo htmlspecialchars($leaveData['status']) ?>" id="employee-status" class="form-control" placeholder="Enter employee status" readonly>
                                        </div>
                                        <div class="form-section">
                                            <label for="position">Position:</label>
                                            <input type="text" value="<?php echo htmlspecialchars($leaveData['position']) ?>" id="employee-position" class="form-control" placeholder="Enter position" readonly>
                                        </div>
                                    </div>

                                    <!-- Right column -->
                                    <div class="col-md-6">
                                        <div class="form-section">
                                            <label for="leave-type">Leave Type:</label>
                                            <input type="text" value="<?php echo htmlspecialchars($leaveData['leave_type']) ?>" id="employee-leave-type" class="form-control" placeholder="Enter Leave Type" readonly>
                                        </div>

                                        <div class="form-section">
                                            <label for="pay">Pay:</label>
                                            <input type="text" value="<?php echo ($leaveData['w_pay'] == 1) ? 'With Pay' : 'Without Pay'; ?>" id="employee-w-pay" class="form-control" placeholder="Enter pay" readonly>
                                        </div>

                                        <div class="form-section row">
                                            <div class="col-md-4">
                                                <label for="date-filed">Date Filed:</label>
                                                <input type="date" id="employee-filed-date" class="form-control" value="<?php echo htmlspecialchars($formattedFiledDate); ?>" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="date-from">From:</label>
                                                <input type="date" id="employee-from-date" class="form-control" value="<?php echo htmlspecialchars($formattedFromDate); ?>" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="date-to">To:</label>
                                                <input type="date" id="employee-to-date" class="form-control" value="<?php echo htmlspecialchars($formattedToDate); ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="form-section row">
                                            <div class="col-md-12">
                                                <label for="absences-days">For Absences (Days):</label>
                                                <input type="number" value="<?php echo htmlspecialchars($leaveData['days']) ?>" id="absences-days" class="form-control" placeholder="0" min="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="separator"></div>


                                <!-- Reason Section -->
                                <div class="form-section">
                                    <label for="reason">Reason:</label>
                                    <textarea id="reason" class="form-control" rows="3" placeholder="Enter reason for leave" style="height: auto; resize: none;" readonly><?php echo htmlspecialchars($leaveData['reason']); ?>
                                    </textarea>
                                </div>

                                <div class="separator"></div>

                                <!-- Leave Balance Section -->
                                <div class="form-section row">
                                    <div class="col-md-4">
                                        <label for="leave-balance">Leave Balance:</label>
                                        <input type="number" id="leave-balance" class="form-control" placeholder="Enter leave balance" min="0" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="leave-request">Leave Request:</label>
                                        <input type="number" id="leave-request" class="form-control" placeholder="Enter leave request" min="0" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="new-balance">New Balance:</label>
                                        <input type="number" id="new-balance" class="form-control" placeholder="Enter new balance" min="0" required>
                                    </div>
                                </div>

                                <!-- Signature Section -->
                                <div class="form-section row">
                                    <div class="col-md-6">
                                        <label for="verified-by">Verified By:</label>
                                        <input type="text" id="verified-by" class="form-control" placeholder="Enter verifier's name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="requested-by">Requested By (Immediate Supervisor):</label>
                                        <input type="text" id="requested-by" class="form-control" placeholder="Enter supervisor's name" required>
                                        <div class="mt-2">
                                            <label class="radio-inline"><input type="radio" name="approval" value="Approved" required> Approve</label>
                                            <label class="radio-inline"><input type="radio" name="approval" value="Disapproved"> Disapprove</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <label for="received-by">Received By (HRD):</label>
                                    <input type="text" id="received-by" class="form-control" placeholder="Enter receiver's name" required>
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-secondary m-1" style="width: 5rem">Reset</button>
                                    <button type="button" class="btn btn-primary m-1" style="width: 5rem" id="showModalBtn">Submit</button>
                                </div>
                            </form>
                            <!-- Modal -->
                            <div class="modal fade" id="leaveModal" tabindex="-1" aria-labelledby="leaveModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="leaveModalLabel">Leave Application Summary</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label for="modal-employee-id" class="form-label">Employee Id</label>
                                                        <input type="text" name="emp_id" class="form-control" id="modal-employee-id" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="modal-employee-name" class="form-label">Employee Name</label>
                                                        <input type="text" name="emp_name" class="form-control" id="modal-employee-name" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="modal-department" class="form-label">Department</label>
                                                        <input type="text" name="emp_dept" class="form-control" id="modal-department" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="modal-position" class="form-label">Position</label>
                                                        <input type="text" name="emp_pos" class="form-control" id="modal-position" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="modal-status" class="form-label">Status</label>
                                                        <input type="text" name="emp_status" class="form-control" id="modal-status" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="modal-pay" class="form-label">Pay</label>
                                                        <input type="text" name="pay" class="form-control" id="modal-pay" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="modal-pay" class="form-label">Leave Type</label>
                                                        <input type="text" name="emp_leaveType" class="form-control" id="modal-leave" readonly>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="modal-date-filed" class="form-label">Date Filed</label>
                                                        <input type="text" name="emp_DateFiled" class="form-control" id="modal-date-filed" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="modal-date-from" class="form-label">Date From</label>
                                                        <input type="text" name="emp_DateFrom" class="form-control" id="modal-date-from" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="modal-date-to" class="form-label">Date To</label>
                                                        <input type="text" name="emp_DateTo" class="form-control" id="modal-date-to" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="modal-absences-days" class="form-label">Absences Days</label>
                                                        <input type="number" name="emp_Abs" class="form-control" id="modal-absences-days" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label for="modal-leave-bal" class="form-label">Leave Balance</label>
                                                        <input type="text" name="leave_bal" class="form-control" id="modal-leave-bal" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="modal-leave-req" class="form-label">Leave Request</label>
                                                        <input type="text" name="leave_req" class="form-control" id="modal-leave-req" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="modal-new-bal" class="form-label">New Balance</label>
                                                        <input type="text" name="new_bal" class="form-control" id="modal-new-bal" readonly>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="modal-reason" class="form-label">Reason</label>
                                                    <textarea class="form-control" name="emp_Reason" id="modal-reason" rows="3" style="resize: none;" readonly></textarea>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label for="modal-verified-by" class="form-label">Verified By</label>
                                                        <input type="text" name="ver_by" class="form-control" id="modal-verified-by" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="modal-requested-by" class="form-label">Requested By</label>
                                                        <input type="text" name="req_by" class="form-control" id="modal-requested-by" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="modal-received-by" class="form-label">Received By</label>
                                                        <input type="text" name="rec_by" class="form-control" id="modal-received-by" readonly>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="text" name="approval" class="form-control" id="modal-approval" readonly style="border: none; background: transparent; color: black;">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" name="add_leave_data" class="btn btn-primary">Confirm Submission</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <script>
                                function validateForm() {
                                    let isValid = true;
                                    const requiredFields = document.querySelectorAll('#leaveForm [required]');

                                    requiredFields.forEach(field => {
                                        field.style.borderColor = '';

                                        const existingError = field.parentElement.querySelector('.error-message');
                                        if (existingError) {
                                            existingError.remove();
                                        }
                                    });

                                    requiredFields.forEach(field => {
                                        if (!field.value.trim()) {
                                            isValid = false;
                                            field.style.borderColor = '#D91656';

                                            const errorDiv = document.createElement('div');
                                            errorDiv.className = 'error-message';
                                            errorDiv.style.color = '#D91656';
                                            errorDiv.style.fontSize = '12px';
                                            errorDiv.style.marginTop = '5px';
                                            errorDiv.textContent = 'This field is required';
                                            field.parentElement.appendChild(errorDiv);
                                        }
                                    });

                                    const approval = document.querySelector('input[name="approval"]:checked');

                                    if (!approval) {
                                        isValid = false;
                                        const approvalSection = document.querySelector('.form-section:has(input[name="approval"])');
                                        const errorDiv = document.createElement('div');
                                        errorDiv.className = 'error-message';
                                        errorDiv.style.color = '#D91656';
                                        errorDiv.style.fontSize = '12px';
                                        errorDiv.style.marginTop = '5px';
                                        errorDiv.textContent = 'Please select an approval status';
                                        approvalSection.appendChild(errorDiv);
                                    }

                                    return isValid;
                                }

                                function addErrorMessage(element, message) {
                                    const existingError = element.parentElement.querySelector('.error-message');
                                    if (existingError) {
                                        existingError.remove();
                                    }

                                    const errorDiv = document.createElement('div');
                                    errorDiv.className = 'error-message';
                                    errorDiv.style.color = '#D91656';
                                    errorDiv.style.fontSize = '12px';
                                    errorDiv.style.marginTop = '5px';
                                    errorDiv.textContent = message;
                                    element.parentElement.appendChild(errorDiv);
                                }

                                document.querySelectorAll('#leaveForm [required]').forEach(field => {
                                    field.addEventListener('input', function() {
                                        if (this.value.trim()) {
                                            this.style.borderColor = '';
                                            const errorMessage = this.parentElement.querySelector('.error-message');
                                            if (errorMessage) {
                                                errorMessage.remove();
                                            }
                                        }
                                    });
                                });

                                document.getElementById("showModalBtn").addEventListener("click", function() {
                                    if (!validateForm()) {
                                        return;
                                    }
                                    const empId = document.getElementById("employee-id").value.trim();
                                    const employeeName = document.getElementById("employee-name").value.trim();
                                    const department = document.getElementById("employee-department").value.trim();
                                    const position = document.getElementById("employee-position").value.trim();
                                    const wPay = document.getElementById("employee-w-pay").value.trim();
                                    const dateFiled = document.getElementById("employee-filed-date").value.trim();
                                    const dateFrom = document.getElementById("employee-from-date").value.trim();
                                    const dateTo = document.getElementById("employee-to-date").value.trim();
                                    const absencesDays = document.getElementById("absences-days").value.trim();
                                    const reason = document.getElementById("reason").value.trim();
                                    const verifiedBy = document.getElementById("verified-by").value.trim();
                                    const requestedBy = document.getElementById("requested-by").value.trim();
                                    const receivedBy = document.getElementById("received-by").value.trim();
                                    const status = document.getElementById("employee-status").value.trim();
                                    const leave_type = document.getElementById("employee-leave-type").value.trim();
                                    const leave_bal = document.getElementById("leave-balance").value.trim();
                                    const leave_req = document.getElementById("leave-request").value.trim();
                                    const new_bal = document.getElementById("new-balance").value.trim();
                                    const approval = document.querySelector('input[name="approval"]:checked').value;

                                    document.getElementById("modal-employee-id").value = empId;
                                    document.getElementById("modal-employee-name").value = employeeName;
                                    document.getElementById("modal-department").value = department;
                                    document.getElementById("modal-position").value = position;
                                    document.getElementById("modal-pay").value = wPay;
                                    document.getElementById("modal-date-filed").value = dateFiled;
                                    document.getElementById("modal-date-from").value = dateFrom;
                                    document.getElementById("modal-date-to").value = dateTo;
                                    document.getElementById("modal-absences-days").value = absencesDays;
                                    document.getElementById("modal-reason").value = reason;
                                    document.getElementById("modal-verified-by").value = verifiedBy;
                                    document.getElementById("modal-requested-by").value = requestedBy;
                                    document.getElementById("modal-received-by").value = receivedBy;
                                    document.getElementById("modal-status").value = status;
                                    document.getElementById("modal-leave").value = leave_type;
                                    document.getElementById("modal-leave-bal").value = leave_bal;
                                    document.getElementById("modal-leave-req").value = leave_req;
                                    document.getElementById("modal-new-bal").value = new_bal;
                                    document.getElementById("modal-approval").value = approval;

                                    var leaveModal = new bootstrap.Modal(document.getElementById('leaveModal'));
                                    leaveModal.show();
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include('../nav-and-footer/footer-area.php'); ?>