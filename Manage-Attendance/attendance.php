<?php

$page_name = "Attendance";
include('../nav-and-footer/header-nav.php');

// User session and authentication check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
$user_role = $_SESSION['user_role'];

if ($user_id == NULL || $security_key == NULL) {
    header('Location: ../Interface/login.php');
}

if (isset($_GET['delete_attendance'])) {
    $action_id = $_GET['aten_id'];
    $sql = "DELETE FROM attendance_info WHERE aten_id = :id";
    $sent_po = "../Manage-Attendance/attendance.php";
    $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
}

if (isset($_POST['add_punch_in'])) {
    // Check if the user has already punched in today
    $today = date('Y-m-d');
    $sql = "SELECT * FROM attendance_info WHERE atn_user_id = :user_id AND DATE(in_time) = :today";
    $stmt = $obj_admin->db->prepare($sql); // Use $obj_admin->db for PDO object
    $stmt->execute(['user_id' => $user_id, 'today' => $today]);
    
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('You have already timed in today.');</script>";
    } else {
        // Proceed to add punch in
        $date = new DateTime('now', new DateTimeZone('Asia/Manila'));
        $punch_in_time = $date->format('Y-m-d H:i:s');

        try {
            // Set pause_duration to '00:00:00' when punching in
            $add_attendance = $obj_admin->db->prepare("INSERT INTO attendance_info (atn_user_id, in_time, pause_duration) VALUES (:user_id, :punch_in_time, '00:00:00')");
            $add_attendance->execute(['user_id' => $user_id, 'punch_in_time' => $punch_in_time]);

            header('Location: ../Manage-Attendance/attendance.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}



if (isset($_POST['add_punch_out'])) {
    $obj_admin->add_punch_out($_POST);
}

if (isset($_POST['pause_time'])) {
    $obj_admin->pause_time($_POST);
}

if (isset($_POST['resume_time'])) {
    $obj_admin->resume_time($_POST);
}

?>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Bootstrap Grid Start -->
<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well well-custom">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="btn-group">
                                            <?php 
                                            $sql = "SELECT * FROM attendance_info WHERE atn_user_id = $user_id AND out_time IS NULL";
                                            $info = $obj_admin->manage_all_info($sql);
                                            $num_row = $info->rowCount();
                                            
                                            if ($num_row == 0) {
                                            ?>
                                            <div class="btn-group">
                                                <form method="post" role="form" action="">
                                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                                    <button type="submit" name="add_punch_in" class="btn btn-primary btn-lg rounded">Time In</button>
                                                </form>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="group-d" class="table table-codensed table-custom table-hover">
                                        <thead class="text-uppercase bg-primary text-white">
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Name</th>
                                                <th>In Time</th>
                                                <th>Out Time</th>
                                                <th>Total Duration</th>
                                                <th>Status</th>
                                                <th <?php if($user_role == 2){ ?> style="display:none" <?php } ?>>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if ($user_role == 1) {
                                                $sql = "SELECT a.*, b.fullname 
                                                        FROM attendance_info a
                                                        LEFT JOIN tbl_admin b ON(a.atn_user_id = b.user_id)
                                                        ORDER BY a.aten_id DESC";
                                            } else {
                                                $sql = "SELECT a.*, b.fullname 
                                                        FROM attendance_info a
                                                        LEFT JOIN tbl_admin b ON(a.atn_user_id = b.user_id)
                                                        WHERE atn_user_id = $user_id
                                                        ORDER BY a.aten_id DESC";
                                            }
                                            
                                            $info = $obj_admin->manage_all_info($sql);
                                            $serial = 1;
                                            $num_row = $info->rowCount();
                                            
                                            if ($num_row == 0) {
                                                echo '<tr><td colspan="7">No Data found</td></tr>';
                                            }

                                            while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
                                                  
                                            ?>
                                            <tr>
                                                <td><?php echo $serial; $serial++; ?></td>
                                                <td><?php echo $row['fullname']; ?></td>
                                                <td><?php echo $row['in_time']; ?></td>
                                                <td><?php echo $row['out_time']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($row['total_duration'] == null) {
                                                        $date = new DateTime('now', new DateTimeZone('Asia/Manila'));
                                                        $current_time = $date->format('d-m-Y H:i:s');

                                                        $dteStart = new DateTime($row['in_time']);
                                                        $dteEnd = new DateTime($current_time);
                                                        $dteDiff = $dteStart->diff($dteEnd);
                                                        echo $dteDiff->format("%H:%I:%S");
                                                    } else {
                                                        echo $row['total_duration'];
                                                    }
                                                    ?>
                                                </td>
                                                <?php if ($row['out_time'] == null) { ?>
                                                <td>
                                                    <form method="post" role="form" action="" class="attendance-form">
                                                        <input type="hidden" name="punch_in_time" value="<?php echo $row['in_time']; ?>">
                                                        <input type="hidden" name="aten_id" value="<?php echo $row['aten_id']; ?>">

                                                        <?php if ($row['pause_time'] == null) { ?>
                                                        <button type="submit" name="pause_time" class="btn btn-warning btn-xs rounded">Pause Time</button>
                                                        <button type="submit" name="add_punch_out" class="btn btn-danger btn-xs rounded" onclick="return confirm('Are you sure you want to Time Out?');">Time Out</button>
                                                        <?php } else { ?>
                                                        <button type="submit" name="resume_time" class="btn btn-success btn-xs rounded">Resume Time</button>
                                                        <?php } ?>
                                                    </form>
                                                </td>
                                                <?php } else { ?>
                                                <td class="text-center">------</td>
                                                <?php } ?>

                                                <?php if ($user_role == 1) { ?>
                                                <td>
                                                    <a title="Delete" href="?delete_attendance=delete_attendance&aten_id=<?php echo $row['aten_id']; ?>" onclick=" return check_delete();"><i class="fa fa-trash-o"></i></a>
                                                </td>
                                                <?php } else { ?>
                                                <td></td>
                                                <?php } ?>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap Grid End -->

<?php
include("../etms/include/footer.php");
include("../nav-and-footer/footer-area.php");
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pauseButtons = document.querySelectorAll('button[name="pause_time"]');
        const resumeButtons = document.querySelectorAll('button[name="resume_time"]');
        const timeOutButtons = document.querySelectorAll('button[name="add_punch_out"]');

        pauseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const timestamp = Date.now(); // Get the current timestamp
                localStorage.setItem('pauseTimestamp', timestamp); // Store the timestamp in localStorage

                // Hide Time Out button when Pause is clicked
                const form = button.closest('form');
                const timeOutButton = form.querySelector('button[name="add_punch_out"]');
                if (timeOutButton) {
                    timeOutButton.style.display = 'none'; // Hide the Time Out button
                }
            });
        });

        resumeButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Show Time Out button when Resume is clicked
                const form = button.closest('form');
                const timeOutButton = form.querySelector('button[name="add_punch_out"]');
                if (timeOutButton) {
                    timeOutButton.style.display = 'inline'; // Show the Time Out button
                }
            });
        });

        // Check for the stored timestamp and calculate elapsed time
        const pauseTimestamp = localStorage.getItem('pauseTimestamp');
        if (pauseTimestamp) {
            const elapsedTime = (Date.now() - parseInt(pauseTimestamp)) / 1000; // Calculate elapsed time in seconds

            // If more than 10 seconds have passed since the pause time
            if (elapsedTime >= 10) {
                alert("Don't forget to resume before you continue to work!");
                localStorage.removeItem('pauseTimestamp'); // Clear the timestamp after showing the alert
            } else {
                // Set a timeout for the remaining time until the alert should show
                setTimeout(function() {
                    alert("Don't forget to resume before you continue to work!");
                    localStorage.removeItem('pauseTimestamp'); // Clear the timestamp after showing the alert
                }, (10 - elapsedTime) * 1000); // Remaining time in milliseconds
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
