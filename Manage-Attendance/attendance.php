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
        echo "<script>
                $(document).ready(function() {
                    $('#timed-in-modal').modal('show');
                });
              </script>";
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
    $punch_out_time = new DateTime('now', new DateTimeZone('Asia/Manila'));
    $out_time = $punch_out_time->format('Y-m-d H:i:s');
    
    // Get the punch-in time from the database
    $aten_id = $_POST['aten_id'];
    $sql = "SELECT in_time, total_duration FROM attendance_info WHERE aten_id = :aten_id";
    $stmt = $obj_admin->db->prepare($sql);
    $stmt->execute(['aten_id' => $aten_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $punch_in_time = new DateTime($row['in_time']);
    $existing_duration = !empty($row['total_duration']) ? $row['total_duration'] : '00:00:00';
    
    // Calculate duration between punch-in and punch-out
    $total_duration = $punch_in_time->diff($punch_out_time);

    // If there is an existing duration (from the active "Time In" session), add it
    if (!empty($existing_duration)) {
        // Convert existing duration to seconds
        $existing_parts = explode(':', $existing_duration);
        $existing_seconds = ($existing_parts[0] * 3600) + ($existing_parts[1] * 60) + $existing_parts[2];
        
        // Add the new time span to the existing duration
        $new_duration_seconds = ($total_duration->h * 3600) + ($total_duration->i * 60) + $total_duration->s;
        $final_duration_seconds = $existing_seconds + $new_duration_seconds;

        // Convert total duration back to hours, minutes, seconds
        $hours = floor($final_duration_seconds / 3600);
        $minutes = floor(($final_duration_seconds % 3600) / 60);
        $seconds = $final_duration_seconds % 60;

        $formatted_duration = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    } else {
        // No existing duration, use the new calculation
        $formatted_duration = $total_duration->format('%H:%I:%S');
    }

    // Update attendance info with punch-out time and total duration
    $sql_update = "UPDATE attendance_info SET out_time = :out_time, total_duration = :total_duration WHERE aten_id = :aten_id";
    $stmt_update = $obj_admin->db->prepare($sql_update);
    $stmt_update->execute([
        'out_time' => $out_time,
        'total_duration' => $formatted_duration,
        'aten_id' => $aten_id
    ]);

    header('Location: ../Manage-Attendance/attendance.php');
}



if (isset($_POST['pause_time'])) {
    $obj_admin->pause_time($_POST);
}

if (isset($_POST['resume_time'])) {
    $obj_admin->resume_time($_POST);
}

?>

<div class="modal fade" id="timed-in-modal" tabindex="-1" role="dialog" aria-labelledby="timedInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timedInModalLabel">Alert</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>You have already timed in today.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Bootstrap Grid Start -->
<div class="col-12 mt-3 mb-3">
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
                                                    <button type="submit" name="add_punch_in" class="btn btn-default table-bg-default btn-lg rounded mb-3">Time In</button>
                                                </form>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="group-d" class="table table-custom table-hover">
                                        <thead class="text-uppercase table-bg-default text-white">
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
                                                <td>
                                                <?php
                                                    // Extract the time component from the 'in_time'
                                                    $in_time = new DateTime($row['in_time']);
                                                    $time_only = $in_time->format('H:i');

                                                    // Compare the time with 8:10 AM and apply red color if late
                                                    if ($time_only > '08:10') {
                                                        echo "<span style='color: red;'>{$row['in_time']}</span>";
                                                    } else {
                                                        echo $row['in_time'];
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $row['out_time']; ?></td>
                                                <td>
                                                <?php
                                                    // Get the current time
                                                    $current_time = new DateTime('now', new DateTimeZone('Asia/Manila'));
                                                    $current_time_formatted = $current_time->format('H:i');

                                                    // If it's past 5 PM and there's no punch out, set it to 5 PM
                                                    if ($current_time_formatted > '17:00' && empty($row['out_time'])) {
                                                        $out_time = new DateTime($row['in_time']);
                                                        $out_time->setTime(17, 0); // Set time to 5:00 PM

                                                        // Update out_time in the database
                                                        $sql_auto_timeout = "UPDATE attendance_info SET out_time = :out_time WHERE aten_id = :aten_id";
                                                        $stmt_auto_timeout = $obj_admin->db->prepare($sql_auto_timeout);
                                                        $stmt_auto_timeout->execute([
                                                            'out_time' => $out_time->format('Y-m-d H:i:s'),
                                                            'aten_id' => $row['aten_id']
                                                        ]);
                                                    }

                                                    if ($row['total_duration'] == null) {
                                                        // Get the current time
                                                        $date = new DateTime('now', new DateTimeZone('Asia/Manila'));
                                                        $current_time = $date->format('Y-m-d H:i:s');

                                                        // Get punch in and current time
                                                        $dteStart = new DateTime($row['in_time']);
                                                        $dteEnd = new DateTime($current_time);

                                                        // Calculate total duration between punch in and current time
                                                        $dteDiff = $dteStart->diff($dteEnd);

                                                        // Convert the difference to seconds
                                                        $totalDurationInSeconds = ($dteDiff->h * 3600) + ($dteDiff->i * 60) + $dteDiff->s;

                                                        // Check if the time period spans across the break time (12 PM - 1 PM)
                                                        $inTimeHour = (int)$dteStart->format('H');
                                                        $outTimeHour = (int)$dteEnd->format('H');

                                                        // Subtract 1 hour if the time spans 12 PM - 1 PM
                                                        $breakTimeToSubtract = 0;
                                                        if ($inTimeHour <= 12 && $outTimeHour >= 13) {
                                                            $breakTimeToSubtract = 1; // Subtract 1 hour for the break time
                                                        }

                                                        // Adjust total duration by subtracting break time
                                                        $totalDurationInSeconds -= ($breakTimeToSubtract * 3600);

                                                        // Handling pause duration if any
                                                        if (!empty($row['pause_duration'])) {
                                                            $pauseDurationInSeconds = strtotime($row['pause_duration']) - strtotime('TODAY');
                                                            $totalDurationInSeconds -= $pauseDurationInSeconds; // Subtract the pause time
                                                        }

                                                        // Convert total duration back to hours, minutes, seconds
                                                        $hours = floor($totalDurationInSeconds / 3600);
                                                        $minutes = floor(($totalDurationInSeconds % 3600) / 60);
                                                        $seconds = $totalDurationInSeconds % 60;

                                                        // Format the total duration
                                                        $totalDurationFormatted = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

                                                        // Output the total duration
                                                        echo $totalDurationFormatted;
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
                                                        
                                                        <button type="button" class="btn btn-danger btn-xs rounded" data-toggle="modal" data-target="#exampleModalCenter">Time Out</button>
                                                        
                                                        <div class="modal fade" id="exampleModalCenter">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Confirm Time Out</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are you sure you want to time out? Please ensure that all your work is saved before proceeding.</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="add_punch_out" class="btn btn-primary">Save changes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


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
                                                    
                                                    <button type="button" class="btn btn-danger btn-xs rounded" data-toggle="modal" data-target="#delete-modal"><i class="fa fa-trash-o"></i></button>
                                                    

                                                    <div class="modal fade" id="delete-modal">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Confirm Deletion</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are you sure you want to permanently remove this item?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <a title="Delete" href="?delete_attendance=delete_attendance&aten_id=<?php echo $row['aten_id']; ?>" class="btn btn-danger btn-sm" ><i class="fa fa-trash-o"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
<div id="alert-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 1050;"></div>
<?php
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

    // Function to create and show the alert
    function showAlert() {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.setAttribute('role', 'alert');
        alertDiv.innerHTML = `
            <strong>Hello!</strong> Don't forget to resume before you continue to work!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span class="fa fa-times"></span>
            </button>
        `;

        // Append the alert to the container
        document.getElementById('alert-container').appendChild(alertDiv);

        // Automatically fade out the alert after 5 seconds
        setTimeout(() => {
            $(alertDiv).alert('close');
        },10000);
    }

    // If more than 10 seconds have passed since the pause time
    if (elapsedTime >= 10) {
        showAlert();
        localStorage.removeItem('pauseTimestamp'); // Clear the timestamp after showing the alert
    } else {
        // Set a timeout for the remaining time until the alert should show
        setTimeout(function() {
            showAlert();
            localStorage.removeItem('pauseTimestamp'); // Clear the timestamp after showing the alert
        }, (10 - elapsedTime) * 1000); // Remaining time in milliseconds
    }
}

    });
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
