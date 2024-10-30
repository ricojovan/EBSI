<?php
$page_name = "Leave Form";
include('../nav-and-footer/header-nav.php');
?>

<?php
    $user_role = $_SESSION['user_role'];
    if($user_role == 1){
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
                                            <input type="text" id="employee-id" class="form-control" placeholder="Enter employee ID" disabled>
                                        </div>
                                        <div class="form-section">
                                            <label for="employee-name">Employee Name:</label>
                                            <input type="text" id="employee-name" class="form-control" placeholder="Enter employee name" disabled>
                                        </div>
                                        <div class="form-section">
                                            <label for="department">Department:</label>
                                            <input type="text" id="department" class="form-control" placeholder="Enter department" disabled>
                                        </div>
                                        <div class="form-section">
                                            <label for="employee-status">Employee Status:</label>
                                            <input type="text" id="employee-status" class="form-control" placeholder="Enter employee status" disabled>
                                        </div>
                                        <div class="form-section">
                                            <label for="position">Position:</label>
                                            <input type="text" id="position" class="form-control" placeholder="Enter position" disabled>
                                        </div>
                                    </div>

                                    <!-- Right column -->
                                    <div class="col-md-6">
                                        <div class="form-section">
                                            <label>Leave Type:</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="undertime" disabled>
                                                        <label class="form-check-label" for="undertime">Undertime</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="absences" disabled>
                                                        <label class="form-check-label" for="absences">Absences</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="bereavement" disabled>
                                                        <label class="form-check-label" for="bereavement">Bereavement</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="changeshift" disabled>
                                                        <label class="form-check-label" for="changeshift">Change Shift</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="dayoff" disabled>
                                                        <label class="form-check-label" for="dayoff">Day off</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="sick" disabled>
                                                        <label class="form-check-label" for="sick">Sick</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="emergency" disabled>
                                                        <label class="form-check-label" for="emergency">Emergency</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="halfday" disabled>
                                                        <label class="form-check-label" for="halfday">Half Day</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="birthday" disabled>
                                                        <label class="form-check-label" for="birthday">Birthday</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="vacation" disabled>
                                                        <label class="form-check-label" for="vacation">Vacation</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="maternity" disabled>
                                                        <label class="form-check-label" for="maternity">Maternity</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section">
                                            <label>Pay:</label><br>
                                            <label class="radio-inline"><input type="radio" name="pay" value="with" disabled> With Pay</label>
                                            <label class="radio-inline"><input type="radio" name="pay" value="without" disabled> Without Pay</label>
                                        </div>

                                        <div class="form-section row">
                                            <div class="col-md-4">
                                                <label for="date-filed">Date Filed:</label>
                                                <input type="date" id="date-filed" class="form-control" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="date-from">From:</label>
                                                <input type="date" id="date-from" class="form-control" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="date-to">To:</label>
                                                <input type="date" id="date-to" class="form-control" disabled>
                                            </div>
                                        </div>

                                        <div class="form-section row">
                                            <div class="col-md-6">
                                                <label for="absences-days">For Absences (Days):</label>
                                                <input type="number" id="absences-days" class="form-control" placeholder="0" min="0" disabled>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="number-of-days">Number of Days:</label>
                                                <input type="number" id="number-of-days" class="form-control" placeholder="0" min="0" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="separator"></div>

                                <!-- Reason Section -->
                                <div class="form-section">
                                    <label for="reason">Reason:</label>
                                    <textarea id="reason" class="form-control" rows="3" placeholder="Enter reason for leave" disabled></textarea>
                                </div>

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
                                            <label class="radio-inline"><input type="radio" name="approval" value="approved" required> Approved</label>
                                            <label class="radio-inline"><input type="radio" name="approval" value="disapproved"> Disapproved</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <label for="received-by">Received By (HRD):</label>
                                    <input type="text" id="received-by" class="form-control" placeholder="Enter receiver's name" required>
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex justify-content-between">
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                    <button type="button" class="btn btn-primary" id="showModalBtn">Submit</button>
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
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="modal-employee-name" class="form-label">Employee Name</label>
                                                    <input type="text" class="form-control" id="modal-employee-name" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="modal-department" class="form-label">Department</label>
                                                    <input type="text" class="form-control" id="modal-department" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="modal-position" class="form-label">Position</label>
                                                    <input type="text" class="form-control" id="modal-position" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="modal-pay" class="form-label">Pay</label>
                                                    <input type="text" class="form-control" id="modal-pay" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="modal-date-filed" class="form-label">Date Filed</label>
                                                    <input type="text" class="form-control" id="modal-date-filed" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="modal-date-from" class="form-label">Date From</label>
                                                    <input type="text" class="form-control" id="modal-date-from" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="modal-date-to" class="form-label">Date To</label>
                                                    <input type="text" class="form-control" id="modal-date-to" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="modal-absences-days" class="form-label">Absences Days</label>
                                                    <input type="text" class="form-control" id="modal-absences-days" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="modal-number-of-days" class="form-label">Number of Days</label>
                                                    <input type="text" class="form-control" id="modal-number-of-days" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="modal-reason" class="form-label">Reason</label>
                                                <textarea class="form-control" id="modal-reason" rows="3" readonly></textarea>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="modal-verified-by" class="form-label">Verified By</label>
                                                    <input type="text" class="form-control" id="modal-verified-by" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="modal-requested-by" class="form-label">Requested By</label>
                                                    <input type="text" class="form-control" id="modal-requested-by" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="modal-received-by" class="form-label">Received By</label>
                                                    <input type="text" class="form-control" id="modal-received-by" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Confirm Submission</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <script>
                                // Function to validate form fields
                                function validateForm() {
                                    let isValid = true;
                                    const requiredFields = document.querySelectorAll('#leaveForm [required]');
                                    
                                    // Reset all field styles
                                    requiredFields.forEach(field => {
                                        field.style.borderColor = '';
                                        // Remove any existing error messages
                                        const existingError = field.parentElement.querySelector('.error-message');
                                        if (existingError) {
                                            existingError.remove();
                                        }
                                    });

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

                                    // Check radio buttons and checkboxes
                                    const leaveType = document.querySelector('input[type="checkbox"]:checked');
                                    const approval = document.querySelector('input[name="approval"]:checked');

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

                                document.getElementById("showModalBtn").addEventListener("click", function () {
                                    // Validate form before showing modal
                                    if (!validateForm()) {
                                        return;
                                    }

                                    // Getting form data
                                    const employeeName = document.getElementById("employee-name").value.trim();
                                    const department = document.getElementById("department").value.trim();
                                    const position = document.getElementById("position").value.trim();
                                    const pay = document.querySelector('input[name="pay"]:checked')?.value;
                                    const dateFiled = document.getElementById("date-filed").value.trim();
                                    const dateFrom = document.getElementById("date-from").value.trim();
                                    const dateTo = document.getElementById("date-to").value.trim();
                                    const absencesDays = document.getElementById("absences-days").value.trim();
                                    const numberOfDays = document.getElementById("number-of-days").value.trim();
                                    const reason = document.getElementById("reason").value.trim();
                                    const verifiedBy = document.getElementById("verified-by").value.trim();
                                    const requestedBy = document.getElementById("requested-by").value.trim();
                                    const receivedBy = document.getElementById("received-by").value.trim();

                                    // Set modal content
                                    document.getElementById("modal-employee-name").value = employeeName;
                                    document.getElementById("modal-department").value = department;
                                    document.getElementById("modal-position").value = position;
                                    document.getElementById("modal-pay").value = pay;
                                    document.getElementById("modal-date-filed").value = dateFiled;
                                    document.getElementById("modal-date-from").value = dateFrom;
                                    document.getElementById("modal-date-to").value = dateTo;
                                    document.getElementById("modal-absences-days").value = absencesDays;
                                    document.getElementById("modal-number-of-days").value = numberOfDays;
                                    document.getElementById("modal-reason").value = reason;
                                    document.getElementById("modal-verified-by").value = verifiedBy;
                                    document.getElementById("modal-requested-by").value = requestedBy;
                                    document.getElementById("modal-received-by").value = receivedBy;

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


<!-- ----------------------------- Employee Leave Report ----------------------------- -->
<?php 
    }else if($user_role == 2){
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
                                            <input type="text" id="employee-id" class="form-control" placeholder="Enter employee ID" required>
                                        </div>
                                        <div class="form-section">
                                            <label for="employee-name">Employee Name:</label>
                                            <input type="text" id="employee-name" class="form-control" placeholder="Enter employee name" required>
                                        </div>
                                        <div class="form-section">
                                            <label for="department">Department:</label>
                                            <input type="text" id="department" class="form-control" placeholder="Enter department" required>
                                        </div>
                                        <div class="form-section">
                                            <label for="employee-status">Employee Status:</label>
                                            <input type="text" id="employee-status" class="form-control" placeholder="Enter employee status" required>
                                        </div>
                                        <div class="form-section">
                                            <label for="position">Position:</label>
                                            <input type="text" id="position" class="form-control" placeholder="Enter position" required>
                                        </div>
                                    </div>

                                    <!-- Right column -->
                                    <div class="col-md-6">
                                        <div class="form-section">
                                            <label>Leave Type:</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="undertime" required>
                                                        <label class="form-check-label" for="undertime">Undertime</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="absences" required>
                                                        <label class="form-check-label" for="absences">Absences</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="bereavement" required>
                                                        <label class="form-check-label" for="bereavement">Bereavement</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="changeshift" required>
                                                        <label class="form-check-label" for="changeshift">Change Shift</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="dayoff" required>
                                                        <label class="form-check-label" for="dayoff">Day off</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="sick" required>
                                                        <label class="form-check-label" for="sick">Sick</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="emergency" required>
                                                        <label class="form-check-label" for="emergency">Emergency</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="halfday" required>
                                                        <label class="form-check-label" for="halfday">Half Day</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="birthday" required>
                                                        <label class="form-check-label" for="birthday">Birthday</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="vacation" required>
                                                        <label class="form-check-label" for="vacation">Vacation</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="maternity" required>
                                                        <label class="form-check-label" for="maternity">Maternity</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section">
                                            <label>Pay:</label><br>
                                            <label class="radio-inline"><input type="radio" name="pay" value="with" required> With Pay</label>
                                            <label class="radio-inline"><input type="radio" name="pay" value="without" required> Without Pay</label>
                                        </div>

                                        <div class="form-section row">
                                            <div class="col-md-4">
                                                <label for="date-filed">Date Filed:</label>
                                                <input type="date" id="date-filed" class="form-control" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="date-from">From:</label>
                                                <input type="date" id="date-from" class="form-control" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="date-to">To:</label>
                                                <input type="date" id="date-to" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="form-section row">
                                            <div class="col-md-6">
                                                <label for="absences-days">For Absences (Days):</label>
                                                <input type="number" id="absences-days" class="form-control" placeholder="0" min="0" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="number-of-days">Number of Days:</label>
                                                <input type="number" id="number-of-days" class="form-control" placeholder="0" min="0" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="separator"></div>

                                <!-- Reason Section -->
                                <div class="form-section">
                                    <label for="reason">Reason:</label>
                                    <textarea id="reason" class="form-control" rows="3" placeholder="Enter reason for leave" required></textarea>
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex justify-content-between">
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                    <button type="button" class="btn btn-primary" id="showModalBtn">Submit</button>
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
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="modal-employee-name" class="form-label">Employee Name</label>
                                                    <input type="text" class="form-control" id="modal-employee-name" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="modal-department" class="form-label">Department</label>
                                                    <input type="text" class="form-control" id="modal-department" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="modal-position" class="form-label">Position</label>
                                                    <input type="text" class="form-control" id="modal-position" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="modal-pay" class="form-label">Pay</label>
                                                    <input type="text" class="form-control" id="modal-pay" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="modal-date-filed" class="form-label">Date Filed</label>
                                                    <input type="text" class="form-control" id="modal-date-filed" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="modal-date-from" class="form-label">Date From</label>
                                                    <input type="text" class="form-control" id="modal-date-from" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="modal-date-to" class="form-label">Date To</label>
                                                    <input type="text" class="form-control" id="modal-date-to" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="modal-absences-days" class="form-label">Absences Days</label>
                                                    <input type="text" class="form-control" id="modal-absences-days" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="modal-number-of-days" class="form-label">Number of Days</label>
                                                    <input type="text" class="form-control" id="modal-number-of-days" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="modal-reason" class="form-label">Reason</label>
                                                <textarea class="form-control" id="modal-reason" rows="3" readonly></textarea>
                                            </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Confirm Submission</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <script>
                                // Function to highlight empty fields
                                function highlightEmptyFields() {
                                    const requiredFields = document.querySelectorAll('#leaveForm [required]');
                                    requiredFields.forEach(field => {
                                        if (!field.value.trim()) {
                                            field.style.borderColor = '#D91656';
                                        } else {
                                            field.style.borderColor = '';
                                        }
                                    });
                                }

                                // Add event listeners to all required fields
                                requiredFields.forEach(field => {
                                    field.addEventListener('blur', highlightEmptyFields);
                                    field.addEventListener('input', function() {
                                        if (this.value.trim()) {
                                            this.style.borderColor = '';
                                        }
                                    });
                                });

                                document.getElementById("showModalBtn").addEventListener("click", function () {
                                    // Check if the form is valid
                                    if (!document.getElementById("leaveForm").checkValidity()) {
                                        // If the form is not valid, trigger the browser's default validation UI
                                        document.getElementById("leaveForm").reportValidity();
                                        highlightEmptyFields();
                                        return; // Exit the function early if the form is not valid
                                    }

                                    // Getting form data
                                    const employeeName = document.getElementById("employee-name").value.trim();
                                    const department = document.getElementById("department").value.trim();
                                    const position = document.getElementById("position").value.trim();
                                    const pay = document.querySelector('input[name="pay"]:checked')?.value;
                                    const dateFiled = document.getElementById("date-filed").value.trim();
                                    const dateFrom = document.getElementById("date-from").value.trim();
                                    const dateTo = document.getElementById("date-to").value.trim();
                                    const absencesDays = document.getElementById("absences-days").value.trim();
                                    const numberOfDays = document.getElementById("number-of-days").value.trim();
                                    const reason = document.getElementById("reason").value.trim();
                                    const verifiedBy = document.getElementById("verified-by").value.trim();
                                    const requestedBy = document.getElementById("requested-by").value.trim();
                                    const receivedBy = document.getElementById("received-by").value.trim();

                                    // Additional check for radio buttons and checkboxes
                                    const leaveType = document.querySelector('input[type="checkbox"]:checked');
                                    const approval = document.querySelector('input[name="approval"]:checked');

                                    if (!leaveType) {
                                        alert("Please select a leave type.");
                                        return;
                                    }

                                    if (!approval) {
                                        alert("Please select an approval status.");
                                        return;
                                    }

                                    // Set modal content
                                    document.getElementById("modal-employee-name").value = employeeName;
                                    document.getElementById("modal-department").value = department;
                                    document.getElementById("modal-position").value = position;
                                    document.getElementById("modal-pay").value = pay;
                                    document.getElementById("modal-date-filed").value = dateFiled;
                                    document.getElementById("modal-date-from").value = dateFrom;
                                    document.getElementById("modal-date-to").value = dateTo;
                                    document.getElementById("modal-absences-days").value = absencesDays;
                                    document.getElementById("modal-number-of-days").value = numberOfDays;
                                    document.getElementById("modal-reason").value = reason;
                                    document.getElementById("modal-verified-by").value = verifiedBy;
                                    document.getElementById("modal-requested-by").value = requestedBy;
                                    document.getElementById("modal-received-by").value = receivedBy;

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

<?php
    }
?>

<?php include('../nav-and-footer/footer-area.php'); ?>
