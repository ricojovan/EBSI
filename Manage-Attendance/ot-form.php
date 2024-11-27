<?php

$page_name = "Overtime Form";
include('../nav-and-footer/header-nav.php');
?>
<div class="col-12 mt-3 mb-3">
    <div class="card">
        <div class="card-body">
            <h5>Overtime Records</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Overtime Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>2 hours</td>
                            <td>Approved</td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>1 hour</td>
                            <td>Pending</td>
                    </tbody>
                </table>
            </div>

            <h5>Add Overtime</h5>
            <form method="post" action="">
                <div class="form-group">
                    <label for="user_id">Employee ID:</label>
                    <input type="number" name="user_id" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="overtime_duration">Overtime Duration:</label>
                    <input type="time" name="overtime_duration" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit Overtime</button>
            </form>
        </div>
    </div>
</div>

<?php
include("../nav-and-footer/footer-area.php");
?>