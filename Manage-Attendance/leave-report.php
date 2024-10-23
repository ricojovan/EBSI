<?php
$page_name = "Leave Report";
include('../nav-and-footer/header-nav.php');
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
                                                        <input type="checkbox" class="form-check-input" id="undertime">
                                                        <label class="form-check-label" for="undertime">Undertime</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="absences">
                                                        <label class="form-check-label" for="absences">Absences</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="bereavement">
                                                        <label class="form-check-label" for="bereavement">Bereavement</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="changeshift">
                                                        <label class="form-check-label" for="changeshift">Change Shift</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="dayoff">
                                                        <label class="form-check-label" for="dayoff">Day off</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="sick">
                                                        <label class="form-check-label" for="sick">Sick</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="emergency">
                                                        <label class="form-check-label" for="emergency">Emergency</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="halfday">
                                                        <label class="form-check-label" for="halfday">Half Day</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="birthday">
                                                        <label class="form-check-label" for="birthday">Birthday</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="vacation">
                                                        <label class="form-check-label" for="vacation">Vacation</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="maternity">
                                                        <label class="form-check-label" for="maternity">Maternity</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section">
                                            <label>Pay:</label><br>
                                            <label class="radio-inline"><input type="radio" name="pay" value="with" required> With Pay</label>
                                            <label class="radio-inline"><input type="radio" name="pay" value="without"> Without Pay</label>
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
                                    <input type="text" id="received-by" class="form-control" placeholder="Enter HRD receiver's name" required>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center mt-4">
                                    <button type="button" class="btn btn-primary btn-flat btn-lg mt-3" onclick="showModal()">Submit Form</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Confirm Leave Application</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please review your leave application before submitting:</p>
                <ul id="reviewList"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
function showModal() {
    const form = document.getElementById('leaveForm');
    const reviewList = document.getElementById('reviewList');
    reviewList.innerHTML = ''; // Clear previous list

    // Gather form data for review
    const employeeName = document.getElementById('employee-name').value;
    const department = document.getElementById('department').value;
    const employeeStatus = document.getElementById('employee-status').value;
    const position = document.getElementById('position').value;
    const leaveType = Array.from(document.querySelectorAll('input[type="checkbox"]:checked')).map(el => el.nextElementSibling.textContent).join(', ');
    const payType = document.querySelector('input[name="pay"]:checked').nextElementSibling.textContent;
    const dateFiled = document.getElementById('date-filed').value;
    const dateFrom = document.getElementById('date-from').value;
    const dateTo = document.getElementById('date-to').value;
    const reason = document.getElementById('reason').value;
    const leaveBalance = document.getElementById('leave-balance').value;
    const leaveRequest = document.getElementById('leave-request').value;
    const newBalance = document.getElementById('new-balance').value;
    const verifiedBy = document.getElementById('verified-by').value;
    const requestedBy = document.getElementById('requested-by').value;
    const receivedBy = document.getElementById('received-by').value;

    // Add items to review list
    reviewList.innerHTML += `<li>Employee Name: ${employeeName}</li>`;
    reviewList.innerHTML += `<li>Department: ${department}</li>`;
    reviewList.innerHTML += `<li>Employee Status: ${employeeStatus}</li>`;
    reviewList.innerHTML += `<li>Position: ${position}</li>`;
    reviewList.innerHTML += `<li>Leave Type: ${leaveType}</li>`;
    reviewList.innerHTML += `<li>Pay Type: ${payType}</li>`;
    reviewList.innerHTML += `<li>Date Filed: ${dateFiled}</li>`;
    reviewList.innerHTML += `<li>From: ${dateFrom}</li>`;
    reviewList.innerHTML += `<li>To: ${dateTo}</li>`;
    reviewList.innerHTML += `<li>Reason: ${reason}</li>`;
    reviewList.innerHTML += `<li>Leave Balance: ${leaveBalance}</li>`;
    reviewList.innerHTML += `<li>Leave Request: ${leaveRequest}</li>`;
    reviewList.innerHTML += `<li>New Balance: ${newBalance}</li>`;
    reviewList.innerHTML += `<li>Verified By: ${verifiedBy}</li>`;
    reviewList.innerHTML += `<li>Requested By: ${requestedBy}</li>`;
    reviewList.innerHTML += `<li>Received By: ${receivedBy}</li>`;

    // Show modal
    $('#reviewModal').modal('show');
}

function submitForm() {
    // This function would handle actual form submission logic
    alert('Form submitted successfully!'); // Placeholder for form submission
    $('#reviewModal').modal('hide');
    document.getElementById('leaveForm').reset(); // Reset form after submission
}
</script>

<?php
include('../nav-and-footer/footer-area.php');
?>
