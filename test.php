<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Form Application</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header text-center">
                <h2>E-BRIGHT RETAIL CORP.</h2>
                <h4>LEAVE FORM APPLICATION</h4>
                <p><strong>Note:</strong> Please make sure to accurately supply all necessary information prior to submission, otherwise the form is invalid.</p>
            </div>

            <div class="card-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="employee_name" class="form-label">Employee Name:</label>
                            <input type="text" class="form-control" id="employee_name" name="employee_name">
                        </div>
                        <div class="col-md-3">
                            <label for="department" class="form-label">Department:</label>
                            <input type="text" class="form-control" id="department" name="department">
                        </div>
                        <div class="col-md-3">
                            <label for="position" class="form-label">Position:</label>
                            <input type="text" class="form-control" id="position" name="position">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="date_filed" class="form-label">Date Filed:</label>
                            <input type="date" class="form-control" id="date_filed" name="date_filed">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Leave Type:</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="undertime" value="undertime">
                            <label class="form-check-label" for="undertime">Undertime</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="half_day" value="half_day">
                            <label class="form-check-label" for="half_day">Half Day</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="change_shift" value="change_shift">
                            <label class="form-check-label" for="change_shift">Change Shift</label>
                        </div>
                        <!-- Add more checkboxes here based on the image -->
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Employee Status:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="with_pay" value="with_pay">
                                <label class="form-check-label" for="with_pay">With Pay</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="without_pay" value="without_pay">
                                <label class="form-check-label" for="without_pay">Without Pay</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="from_date" class="form-label">Dates/Hours From:</label>
                            <input type="date" class="form-control" id="from_date" name="from_date">
                        </div>
                        <div class="col-md-6">
                            <label for="to_date" class="form-label">To:</label>
                            <input type="date" class="form-control" id="to_date" name="to_date">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason:</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="requested_by" class="form-label">Requested by:</label>
                            <input type="text" class="form-control" id="requested_by" name="requested_by">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="approved" value="approved">
                                <label class="form-check-label" for="approved">Approved</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="disapproved" value="disapproved">
                                <label class="form-check-label" for="disapproved">Disapproved</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="immediate_superior" class="form-label">Immediate Superior:</label>
                            <input type="text" class="form-control" id="immediate_superior" name="immediate_superior">
                        </div>
                        <div class="col-md-6">
                            <label for="received_by" class="form-label">Received by:</label>
                            <input type="text" class="form-control" id="received_by" name="received_by">
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <h5>Reminders</h5>
                        <p>1. For Undertime (1-2 hrs. prior official time out).</p>
                        <p>2. Filing is one (1) day prior to the actual day for emergency cases, etc.</p>
                        <!-- Add more reminders as needed -->
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>