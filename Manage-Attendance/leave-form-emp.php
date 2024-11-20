<?php
$page_name = "Leave Form";
include('../nav-and-footer/header-nav.php');

$empId = $_SESSION['admin_id'];
$empDptmt = $_SESSION['empDepartment'];
$empstatus = $_SESSION['empStatus'];
$empPosition = $_SESSION['empPosition'];

if (isset($_POST['add_leave_data'])) {
    $error = $obj_admin->add_leave_data($_POST);
}
?>

<div class="col-12 mt-3 mb-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-success" role="alert"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <div class="container">
                        <div class="form-container">
                            <h2 class="form-title">E-BRIGHT RETAIL CORP.<br>Leave Form Application</h2>
                            <p class="text-center text-muted">
                                Note: Please make sure to accurately supply all necessary information prior to submission, otherwise the form is invalid.
                            </p>

                            <form id="leaveForm">
                                <div class="row">
                                    <!-- Left column -->
                                    <input type="hidden" value=<?php echo $empId ?> id="employee-id" class="form-control" placeholder="Enter employee ID">
                                    <input type="hidden" value="<?php echo $user_name ?>" id="employee-name" class="form-control" placeholder="Enter employee name">
                                    <input type="hidden" value=<?php echo $empDptmt ?> id="department" class="form-control" placeholder="Enter department">
                                    <input type="hidden" value=<?php echo $empstatus ?> id="employee-status" class="form-control" placeholder="Enter employee status">
                                    <input type="hidden" value=<?php echo $empPosition ?> id="position" class="form-control" placeholder="Enter position">

                                    <div class="col-md-6 mt-3">
                                        <div class="form-section">
                                            <label for="reason">Reason:</label>
                                            <textarea id="reason" class="form-control" style="height: 20.8rem; resize: none;" placeholder="Enter reason for leave"></textarea>
                                        </div>
                                    </div>

                                    <!-- Right column -->
                                    <div class="col-md-6 mt-3">
                                        <div class="form-section">
                                            <label>Leave Type:</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="leave" value="Undertime" class="form-check-input single-checkbox" id="undertime">
                                                        <label class="form-check-label" for="undertime">Undertime</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="leave" value="Absences" class="form-check-input single-checkbox" id="absences">
                                                        <label class="form-check-label" for="absences">Absences</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="leave" value="Bereavement" class="form-check-input single-checkbox" id="bereavement">
                                                        <label class="form-check-label" for="bereavement">Bereavement</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="leave" value="Change Shift" class="form-check-input single-checkbox" id="changeshift">
                                                        <label class="form-check-label" for="changeshift">Change Shift</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="leave" value="Day off" class="form-check-input single-checkbox" id="dayoff">
                                                        <label class="form-check-label" for="dayoff">Day off</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="leave" value="Sick" class="form-check-input single-checkbox" id="sick">
                                                        <label class="form-check-label" for="sick">Sick</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="leave" value="Emergency" class="form-check-input single-checkbox" id="emergency">
                                                        <label class="form-check-label" for="emergency">Emergency</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="leave" value="Half Day" class="form-check-input single-checkbox" id="halfday">
                                                        <label class="form-check-label" for="halfday">Half Day</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="leave" value="Birthday" class="form-check-input single-checkbox" id="birthday">
                                                        <label class="form-check-label" for="birthday">Birthday</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="leave" value="Vacation" class="form-check-input single-checkbox" id="vacation">
                                                        <label class="form-check-label" for="vacation">Vacation</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="leave" value="Maternity" class="form-check-input single-checkbox" id="maternity">
                                                        <label class="form-check-label" for="maternity">Maternity</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="separator"></div>

                                        <div class="form-section">
                                            <label for="pay">Pay: </label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="With Pay" name="pay" checked>With Pay
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="Without Pay" name="pay">Without Pay
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="separator"></div>

                                        <div class="form-section row">
                                            <div class="col-md-6">
                                                <label for="date-from">From:</label>
                                                <input type="date" id="date-from" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="date-to">To:</label>
                                                <input type="date" id="date-to" class="form-control">
                                            </div>
                                        </div>
                                        <input type="hidden" id="absences-days" class="form-control" placeholder="0" min="0">
                                    </div>
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
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="modal-employee-name" class="form-label">Employee Name</label>
                                                        <input type="text" name="emp_name" class="form-control" id="modal-employee-name" readonly>
                                                    </div>
                                                    <div class="col-md-6">
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
                                                        <label for="modal-pay" class="form-label">Pay</label>
                                                        <input type="text" name="pay" class="form-control" id="modal-pay" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="modal-leave-type" class="form-label">Leave Type</label>
                                                        <input type="text" name="emp_leaveType" class="form-control" id="modal-leave-type" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="modal-absences-days" class="form-label">Absence Day(s)</label>
                                                        <input type="text" name="emp_Abs" class="form-control" id="modal-absences-days" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label for="modal-date-filed" class="form-label">Date Filed</label>
                                                        <input type="text" name="emp_DateFiled" class="form-control" id="modal-date-filed" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="modal-date-from" class="form-label">Date From</label>
                                                        <input type="text" name="emp_DateFrom" class="form-control" id="modal-date-from" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="modal-date-to" class="form-label">Date To</label>
                                                        <input type="text" name="emp_DateTo" class="form-control" id="modal-date-to" readonly>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="modal-reason" class="form-label">Reason</label>
                                                    <textarea class="form-control" name="emp_Reason" style="resize: none;" id="modal-reason" rows="3" readonly></textarea>
                                                </div>
                                                <input type="hidden" name="emp_status" class="form-control" id="modal-employee-status" readonly>
                                                <input type="hidden" class="form-control" id = "modal-employee-id" name="emp_id" value="">
                                                <div class="form-group text-right mt-4">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="add_leave_data" class="btn btn-primary">Confirm Submission</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                const checkboxes = document.querySelectorAll('.single-checkbox');

                                checkboxes.forEach((checkbox) => {
                                    checkbox.addEventListener('change', function() {
                                        if (this.checked) {
                                            checkboxes.forEach((box) => {
                                                if (box !== this) {
                                                    box.checked = false;
                                                }
                                            });
                                        }
                                    });
                                });

                                const date = new Date();
                                const formatDate = date.toISOString().split('T')[0];
                                const dateFrom = document.getElementById('date-from');
                                const dateTo = document.getElementById('date-to');
                                const totalDaysSpan = document.getElementById('absences-days');
                                dateFrom.min = formatDate;
                                dateFrom.addEventListener('change', function() {
                                    const selectedDate = dateFrom.value;
                                    if (selectedDate) {
                                        dateTo.min = selectedDate;
                                    } else {
                                        dateTo.removeAttribute('min');
                                    }
                                });

                                function calculateDays() {
                                    const fromDate = new Date(dateFrom.value);
                                    const toDate = new Date(dateTo.value);

                                    if (dateFrom.value && dateTo.value) {

                                        const timeDifference = toDate - fromDate;

                                        const dayDifference = timeDifference / (1000 * 60 * 60 * 24);

                                        totalDaysSpan.value = dayDifference >= 0 ? dayDifference : 0;
                                    } else {
                                        totalDaysSpan.value = 0;
                                    }
                                }

                                dateFrom.addEventListener('change', calculateDays);
                                dateTo.addEventListener('change', calculateDays);

                                // Function to validate form fields
                                function validateForm() {
                                    let isValid = true;
                                    const requiredFields = document.querySelectorAll('#leaveForm [required]');
                                    const errorMessages = document.querySelectorAll('.error-message');
                                    errorMessages.forEach(message => message.remove());

                                    // Check each required field
                                    requiredFields.forEach(field => {
                                        if (!field.value.trim()) {
                                            isValid = false;
                                            field.style.borderColor = '#D91656';

                                            // Add error message below the field
                                            const errorDiv = document.createElement('div');
                                            errorDiv.className = 'error-message';
                                            errorDiv.style.color = '#D91656';
                                            errorDiv.style.fontSize = '12px';
                                            errorDiv.style.marginTop = '5px';
                                            errorDiv.textContent = 'This field is required';
                                            field.parentElement.appendChild(errorDiv);
                                        }
                                    });

                                    // Check if 'From' and 'To' dates are filled and valid
                                    const dateFrom = document.getElementById('date-from');
                                    const dateTo = document.getElementById('date-to');
                                    const dateFromValue = dateFrom.value.trim();
                                    const dateToValue = dateTo.value.trim();

                                    if (!dateFromValue || !dateToValue) {
                                        isValid = false;
                                        if (!dateFromValue) {
                                            dateFrom.style.borderColor = '#D91656';
                                            addErrorMessage(dateFrom, 'Please select a "From" date');
                                        }
                                        if (!dateToValue) {
                                            dateTo.style.borderColor = '#D91656';
                                            addErrorMessage(dateTo, 'Please select a "To" date');
                                        }
                                    } else if (dateFromValue > dateToValue) {
                                        isValid = false;
                                        dateFrom.style.borderColor = '#D91656';
                                        dateTo.style.borderColor = '#D91656';
                                        addErrorMessage(dateFrom, 'The "From" date cannot be later than the "To" date');
                                    }

                                    // Check radio buttons and checkboxes for leave type
                                    const leaveType = document.querySelector('input[type="checkbox"]:checked');
                                    if (!leaveType) {
                                        isValid = false;
                                        const leaveTypeSection = document.querySelector('.form-section:has(input[type="checkbox"])');
                                        const errorDiv = document.createElement('div');
                                        errorDiv.className = 'error-message';
                                        errorDiv.style.color = '#D91656';
                                        errorDiv.style.fontSize = '12px';
                                        errorDiv.style.marginTop = '5px';
                                        errorDiv.textContent = 'Please select a leave type';
                                        leaveTypeSection.appendChild(errorDiv);
                                    }

                                    // Validate reason field
                                    const reasonField = document.getElementById('reason');
                                    if (!reasonField.value.trim()) {
                                        isValid = false;
                                        reasonField.style.borderColor = '#D91656';

                                        const errorDiv = document.createElement('div');
                                        errorDiv.className = 'error-message';
                                        errorDiv.style.color = '#D91656';
                                        errorDiv.style.fontSize = '12px';
                                        errorDiv.style.marginTop = '5px';
                                        errorDiv.textContent = 'Please enter a reason for your leave';
                                        reasonField.parentElement.appendChild(errorDiv);
                                    }

                                    return isValid;
                                }

                                // Helper function to add error messages
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

                                // Add input event listeners to remove error styling when user starts typing
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
                                    // Validate form before showing modal
                                    if (!validateForm()) {
                                        return;
                                    }

                                    // Getting form data
                                    const employeeId = document.getElementById("employee-id").value.trim();
                                    const employeeName = document.getElementById("employee-name").value.trim();
                                    const department = document.getElementById("department").value.trim();
                                    const position = document.getElementById("position").value.trim();
                                    const pay = document.querySelector('input[name="pay"]:checked')?.value;
                                    const leaveType = document.querySelector('.single-checkbox:checked').value;
                                    const empStatus = document.getElementById("employee-status").value.trim();
                                    const dateFiled = formatDate;
                                    const absencesDays = document.getElementById("absences-days").value.trim();
                                    const dateFrom = document.getElementById("date-from").value.trim();
                                    const dateTo = document.getElementById("date-to").value.trim();
                                    const reason = document.getElementById("reason").value.trim();

                                    // Set modal content
                                    document.getElementById("modal-employee-id").value = employeeId;
                                    document.getElementById("modal-employee-status").value = empStatus;
                                    document.getElementById("modal-employee-name").value = employeeName;
                                    document.getElementById("modal-department").value = department;
                                    document.getElementById("modal-position").value = position;
                                    document.getElementById("modal-pay").value = pay;
                                    document.getElementById("modal-date-filed").value = dateFiled;
                                    document.getElementById("modal-date-from").value = dateFrom;
                                    document.getElementById("modal-date-to").value = dateTo;
                                    document.getElementById("modal-leave-type").value = leaveType;
                                    document.getElementById("modal-absences-days").value = absencesDays;
                                    document.getElementById("modal-reason").value = reason;

                                    // Show the modal
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