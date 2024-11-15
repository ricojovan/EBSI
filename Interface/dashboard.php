<?php
$page_name="Dashboard";

include '../nav-and-footer/header-nav.php';

// Database credentials
$host_name='localhost';
$user_name='root';
$password='';
$db_name='ebsi_db';

try {
    // Create a new PDO instance
    $db = new PDO("mysql:host=$host_name;dbname=$db_name", $user_name, $password);
    // Set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to count employees with user_role = 2
    $sql = "SELECT COUNT(*) AS user_id FROM tbl_admin WHERE user_role = 2";

    // Execute the query
    $result = $db->query($sql);

    // Check if query executed successfully
    if ($result) {
        // Fetch the row as an associative array
        $row = $result->fetch(PDO::FETCH_ASSOC);

        // Extract the user count
        $employeeCount = isset($row['user_id']) ? $row['user_id'] : 0;

        // Close the result set
        $result->closeCursor();
    } else {
        // Handle query execution error here
        $employeeCount = 0;
    }

    // Query to count tasks in progress (status = 1) from task_info table
    $sqlInProgressCount = "SELECT COUNT(*) AS task_id FROM task_info WHERE status = 1";

    // Execute the in progress task count query
    $resultInProgressCount = $db->query($sqlInProgressCount);

    // Check if in progress task count query executed successfully
    if ($resultInProgressCount) {
        // Fetch the row as an associative array
        $rowInProgressCount = $resultInProgressCount->fetch(PDO::FETCH_ASSOC);

        // Extract the in progress task count
        $inProgressCount = isset($rowInProgressCount['task_id']) ? $rowInProgressCount['task_id'] : 0;

        // Close the result set
        $resultInProgressCount->closeCursor();
    } else {
        // Handle in progress task count query execution error here
        $inProgressCount = 0;
    }


    // Query to count incomplete tasks (status = 0) from task_info table
    $sqlIncompleteCount = "SELECT COUNT(*) AS task_id FROM task_info WHERE status = 0";

    // Execute the incomplete task count query
    $resultIncompleteCount = $db->query($sqlIncompleteCount);

    // Check if incomplete task count query executed successfully
    if ($resultIncompleteCount) {
        // Fetch the row as an associative array
        $rowIncompleteCount = $resultIncompleteCount->fetch(PDO::FETCH_ASSOC);

        // Extract the incomplete task count
        $incompleteCount = isset($rowIncompleteCount['task_id']) ? $rowIncompleteCount['task_id'] : 0;

        // Close the result set
        $resultIncompleteCount->closeCursor();
    } else {
        // Handle incomplete task count query execution error here
        $incompleteCount = 0;
    }

    // Close the database connection
    $db = null;
} catch(PDOException $e) {
    // Display error message if connection or query fails
    echo "Connection failed: " . $e->getMessage();
    exit(); // Stop further execution
}
?>
        <!-- page title area end -->
         
         <!-- THIS IS ADMIN SIDE -->
        <?php
                        $user_role = $_SESSION['user_role'];
                        if($user_role == 1){
                        ?>
<div class="main-content-inner">
    <div class="container-fluid">
        <div class="row justify-content-start"> 
            <!-- seo fact area start -->
            <div class="col-lg-4 col-md-6 mt-3 mb-3">
                <div class="card">
                    <div class="seo-fact sbg1">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="fa fa-user"></i> Employees</div>
                            <h2><?php echo $employeeCount; ?></h2>
                        </div>
                        <canvas id="seolinechart1" height="50"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-3 mb-3">
                <div class="card">
                    <div class="seo-fact sbg2">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class='fa fa-check-circle'></i> Time in</div>
                            <h2><?php echo $inProgressCount; ?></h2>
                        </div>
                        <canvas id="seolinechart2" height="50"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-3 mb-3">
                <div class="card">
                    <div class="seo-fact sbg3">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class='fa fa-check-circle'></i> **********</div>
                            <h2><?php echo $incompleteCount; ?></h2>
                        </div>
                        <canvas id="seolinechart2" height="50"></canvas>
                    </div>
                </div>
            </div>    
            <!-- seo fact area end -->
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table id="group-d" class="table table-condensed table-custom table-hover">
                                    <thead class="text-uppercase table-bg-default text-white">
                                        <tr>
                                            <th>S.N.</th>
                                            <th>Name</th>
                                            <th>In Time</th>
                                            <th>Out Time</th>
                                            <th>Total Duration</th>
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

<!--THIS IS EMPLOYEE SIDE-->
<?php 
    } else if($user_role == 2) {
?>

<div class="main-content-inner">
    <div class="container-fluid">
        <div class="row justify-content-start"> 
            <!-- SEO fact area start -->
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <div class="card shadow-sm border-light rounded">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fa fa-calendar"></i> Schedule Assign</h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h2 class="text-center text-success">10</h2>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Start Time:</strong> <span class="text-muted">09:00 AM</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>End Time:</strong> <span class="text-muted">05:00 PM</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Start Date:</strong> <span class="text-muted">2023-10-01</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>End Date:</strong> <span class="text-muted">2023-10-31</span>
                            </li>
                        </ul>
                        <canvas id="seolinechart1" height="50" class="mt-auto"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <div class="card shadow-sm border-light rounded">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fa fa-check-circle"></i> Attendance Count</h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h2 class="text-center text-success">25</h2>
                        <canvas id="seolinechart2" height="50" class="mt-auto"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <div class="card shadow-sm border-light rounded">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fa fa-times-circle"></i> Leave Count</h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h2 class="text-center text-danger">5</h2>
                        <canvas id="seolinechart3" height="50" class="mt-auto"></canvas>
                    </div>
                </div>
            </div>    
            <!-- SEO fact area end -->
        </div>
    </div>
</div>

<?php
    }
?>
   <!-- Main content end -->
    <!-- main content area end -->
        <?php include '../nav-and-footer/footer-area.php';?>  

