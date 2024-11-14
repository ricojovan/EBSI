<?php

$page_name = "Overtime Form";
include('../nav-and-footer/header-nav.php');

// Handle form submission for adding overtime
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $overtime_duration = $_POST['overtime_duration'];

    // Insert into overtime_info table
    $sql = "INSERT INTO overtime_info (user_id, overtime_duration) VALUES (:user_id, :overtime_duration)";
    $stmt = $obj_admin->db->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'overtime_duration' => $overtime_duration]);

    // Redirect to the same page to avoid resubmission
    header('Location: ot-form.php');
    exit();
}

// Fetch overtime records
$sql = "SELECT a.fullname, o.overtime_duration, o.status 
        FROM overtime_info o 
        JOIN tbl_admin a ON o.user_id = a.user_id";
$info = $obj_admin->manage_all_info($sql);

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
                        <?php while ($row = $info->fetch(PDO::FETCH_ASSOC)) { ?>
                        <tr>
                            <td><?php echo $row['fullname']; ?></td>
                            <td><?php echo $row['overtime_duration']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                        </tr>
                        <?php } ?>
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