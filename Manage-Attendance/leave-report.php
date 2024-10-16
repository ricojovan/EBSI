<?php
$page_name = "Leave Report";
include('../nav-and-footer/header-nav.php');
?>

<div class="col-12 mt-3 mb-3">
    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well well-custom">
                                <div class="form-container p-4 bg-light rounded shadow-sm">
                                <div class="card shadow">
                                    <div class="card-header text-center">
                                        <h2>E-BRIGHT RETAIL CORP.</h2>
                                        <h4>LEAVE FORM APPLICATION</h4>
                                        <p><strong>Note:</strong> Please make sure to accurately supply all necessary information prior to submission, otherwise the form is invalid.</p>
                                    </div>
                                    <div class="form-header p-3 bg-primary text-white rounded mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Form Code:</strong> FC-HRD-007<br>
                                                <strong>Version:</strong> 2.0<br>
                                                <strong>Effective Date:</strong> 05/03/2024<br>
                                                <strong>Approved by:</strong> RSV
                                            </div>
                                        </div>
                                    </div>

                                    <form>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label>Employee Name:</label>
                                                <input type="text" class="form-control" placeholder="Enter employee name">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Date Filed:</label>
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>Department:</label>
                                                <input type="text" class="form-control" placeholder="Enter department">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Employee Status:</label>
                                                <input type="text" class="form-control" placeholder="Enter status">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Position:</label>
                                                <input type="text" class="form-control" placeholder="Enter position">
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Leave Type</th>
                                                        <th>With Pay</th>
                                                        <th>Without Pay</th>
                                                        <th>Dates/Hours</th>
                                                        <th>For Absences</th>
                                                        <th>From</th>
                                                        <th>To</th>
                                                        <th>Number of Days</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="undertime">
                                                                <label class="form-check-label" for="undertime">Undertime</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="changeshift">
                                                                <label class="form-check-label" for="changeshift">Change Shift</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="absences">
                                                                <label class="form-check-label" for="absences">Absences</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="vacation">
                                                                <label class="form-check-label" for="vacation">Vacation</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="sick">
                                                                <label class="form-check-label" for="sick">Sick</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="emergency">
                                                                <label class="form-check-label" for="emergency">Emergency</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="birthday">
                                                                <label class="form-check-label" for="birthday">Birthday</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="maternity">
                                                                <label class="form-check-label" for="maternity">Maternity</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="bereavement">
                                                                <label class="form-check-label" for="bereavement">Bereavement</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="halfday">
                                                                <label class="form-check-label" for="halfday">Half Day</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="dayoff">
                                                                <label class="form-check-label" for="dayoff">Day off</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="with-pay" name="customRadio" class="custom-control-input">
                                                                <label class="custom-control-label" for="with-pay">With Pay</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="without-pay" name="customRadio" class="custom-control-input">
                                                                <label class="custom-control-label" for="without-pay">Without Pay</label>
                                                            </div>
                                                        </td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="date" class="form-control"></td>
                                                        <td><input type="date" class="form-control"></td>
                                                        <td><input type="number" class="form-control"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="form-group">
                                            <label>Reason:</label>
                                            <textarea class="form-control" rows="3"></textarea>
                                        </div>

                                        <div class="leave-balance bg-light p-3 rounded mb-4">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Leave Balance:</label>
                                                    <input type="text" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Leave Request:</label>
                                                    <input type="text" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>New Balance:</label>
                                                    <input type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label>Verified by:</label>
                                            <input type="text" class="form-control" disabled>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Approved by:</label>
                                                <input type="text" class="form-control" placeholder="Immediate Supervisor">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Received by:</label>
                                                <input type="text" class="form-control" placeholder="HRD">
                                            </div>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="approval" id="approved" value="approved">
                                            <label class="form-check-label" for="approved">Approved</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="approval" id="disapproved" value="disapproved">
                                            <label class="form-check-label" for="disapproved">Disapproved</label>
                                        </div>

                                        <div class="reminders mt-4 p-3 bg-light rounded">
                                            <h6 class="text-secondary">Reminders:</h6>
                                            <ul>
                                                <li>For Undertime (1-2 hrs. prior official time out), filing is prior to leaving the office or no later than the next working day for emergency instances.</li>
                                                <li>For Half Day, it must be approved at least one (1) day before the actual day. For emergencies, approval must be secured before leaving.</li>
                                                <li>For Change Shift/Day Off, filing must be at least one (1) day prior to the actual day.</li>
                                                <li>For Sick Leave, taking leave for more than one (1) day will require a medical certificate.</li>
                                                <li>For Vacation Leave/Day Off, the application must be properly filled out and submitted in duplicate.</li>
                                            </ul>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-block mt-4">Submit Application</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("../nav-and-footer/footer-area.php");
?>