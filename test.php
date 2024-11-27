<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Form Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding-top: 30px;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
            font-weight: bold;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .form-section label {
            font-weight: 600;
            color: #495057;
        }

        .form-section input, .form-section textarea {
            border-radius: 4px;
        }

        .leave-type-checkbox {
            margin-bottom: 10px;
        }

        .radio-inline input {
            margin-right: 5px;
        }

        .separator {
            margin-top: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .btn-submit {
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2 class="form-title">E-BRIGHT RETAIL CORP.<br>Leave Form Application</h2>
            <p class="text-center text-muted">Note: Please make sure to accurately supply all necessary information prior to submission, otherwise the form is invalid.</p>

            <form>
                <div class="row">
                    <!-- Left column -->
                    <div class="col-md-6">
                        <div class="form-section">
                            <label for="employee-name">Employee Name:</label>
                            <input type="text" id="employee-name" class="form-control" placeholder="Enter employee name">
                        </div>
                        <div class="form-section">
                            <label for="department">Department:</label>
                            <input type="text" id="department" class="form-control" placeholder="Enter department">
                        </div>
                        <div class="form-section">
                            <label for="employee-status">Employee Status:</label>
                            <input type="text" id="employee-status" class="form-control" placeholder="Enter employee status">
                        </div>
                        <div class="form-section">
                            <label for="position">Position:</label>
                            <input type="text" id="position" class="form-control" placeholder="Enter position">
                        </div>
                    </div>

                    <!-- Right column -->
                    <div class="col-md-6">
                        <div class="form-section">
                            <label>Leave Type:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="leave-type-checkbox"><input type="checkbox"> Undertime</div>
                                    <div class="leave-type-checkbox"><input type="checkbox"> Sick</div>
                                    <div class="leave-type-checkbox"><input type="checkbox"> Bereavement</div>
                                    <div class="leave-type-checkbox"><input type="checkbox"> Change Shift</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="leave-type-checkbox"><input type="checkbox"> Emergency</div>
                                    <div class="leave-type-checkbox"><input type="checkbox"> Half Day</div>
                                    <div class="leave-type-checkbox"><input type="checkbox"> Absences</div>
                                    <div class="leave-type-checkbox"><input type="checkbox"> Vacation</div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="form-section">
                            <label>Pay:</label><br>
                            <label class="radio-inline"><input type="radio" name="pay" value="with"> With Pay</label>
                            <label class="radio-inline"><input type="radio" name="pay" value="without"> Without Pay</label>
                        </div>

                        <div class="form-section row">
                            <div class="col-md-4">
                                <label for="date-filed">Date Filed:</label>
                                <input type="date" id="date-filed" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="date-from">From:</label>
                                <input type="date" id="date-from" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="date-to">To:</label>
                                <input type="date" id="date-to" class="form-control">
                            </div>
                        </div>

                        <div class="form-section row">
                            <div class="col-md-6">
                                <label for="absences">For Absences:</label>
                                <input type="number" id="absences" class="form-control" placeholder="0">
                            </div>
                            <div class="col-md-6">
                                <label for="days">Number of Days:</label>
                                <input type="number" id="days" class="form-control" placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="separator"></div>

                <!-- Reason Section -->
                <div class="form-section">
                    <label for="reason">Reason:</label>
                    <textarea id="reason" class="form-control" rows="3" placeholder="Enter reason for leave"></textarea>
                </div>

                <!-- Leave Balance Section -->
                <div class="form-section row">
                    <div class="col-md-4">
                        <label for="leave-balance">Leave Balance:</label>
                        <input type="text" id="leave-balance" class="form-control" placeholder="Enter leave balance">
                    </div>
                    <div class="col-md-4">
                        <label for="leave-request">Leave Request:</label>
                        <input type="text" id="leave-request" class="form-control" placeholder="Enter leave request">
                    </div>
                    <div class="col-md-4">
                        <label for="new-balance">New Balance:</label>
                        <input type="text" id="new-balance" class="form-control" placeholder="Enter new balance">
                    </div>
                </div>

                <!-- Signature Section -->
                <div class="form-section row">
                    <div class="col-md-6">
                        <label for="verified-by">Verified By:</label>
                        <input type="text" id="verified-by" class="form-control" placeholder="Enter verifier's name">
                    </div>
                    <div class="col-md-6">
                        <label for="requested-by">Requested By (Immediate Supervisor):</label>
                        <input type="text" id="requested-by" class="form-control" placeholder="Enter supervisor's name">
                        <div class="mt-2">
                            <label class="radio-inline"><input type="radio" name="approval" value="approved"> Approved</label>
                            <label class="radio-inline"><input type="radio" name="approval" value="disapproved"> Disapproved</label>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <label for="received-by">Received By (HRD):</label>
                    <input type="text" id="received-by" class="form-control" placeholder="Enter HRD receiver's name">
                </div>

                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-submit">Submit Leave Form</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
