<?php
$page_name = "Dashboard";

include '../nav-and-footer/header-nav.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    echo "Error: User not logged in.";
    exit();
}

// Database credentials
$host_name = 'localhost';
$user_name = 'root';
$password = '';
$db_name = 'ebsi_db';

try {
    // Create a new PDO instance
    $db = new PDO("mysql:host=$host_name;dbname=$db_name", $user_name, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get logged-in user ID from session
    $loggedInUserId = $_SESSION['admin_id'];

    // Get the current month and year
    $currentMonth = date('m');
    $currentYear = date('Y');

    // Query to count the total number of employees
    $sqlTotalEmployees = "SELECT COUNT(*) AS total_employees FROM tbl_admin";
    $stmtTotal = $db->query($sqlTotalEmployees);
    $totalEmployeesData = $stmtTotal->fetch(PDO::FETCH_ASSOC);
    $totalEmployees = $totalEmployeesData['total_employees'] ?? 0;

    // Query to count active employees (those who have timed in today)
    $currentDate = date('Y-m-d'); // Get the current date
    $sqlActiveEmployees = "
        SELECT COUNT(DISTINCT atn_user_id) AS active_employees
        FROM attendance_info
        WHERE DATE(in_time) = :currentDate";
    $stmtActive = $db->prepare($sqlActiveEmployees);
    $stmtActive->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
    $stmtActive->execute();
    $activeEmployeesData = $stmtActive->fetch(PDO::FETCH_ASSOC);
    $activeEmployees = $activeEmployeesData['active_employees'] ?? 0;

    // Query to count distinct days the employee has timed in this month
    $sqlAttendanceCount = "
        SELECT COUNT(DISTINCT DATE(in_time)) AS attendance_count 
        FROM attendance_info 
        WHERE atn_user_id = :userId 
        AND MONTH(in_time) = :currentMonth 
        AND YEAR(in_time) = :currentYear";

    $stmt = $db->prepare($sqlAttendanceCount);
    $stmt->bindParam(':userId', $loggedInUserId, PDO::PARAM_INT);
    $stmt->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
    $stmt->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
    $stmt->execute();

    $attendanceData = $stmt->fetch(PDO::FETCH_ASSOC);
    $attendanceCount = $attendanceData['attendance_count'] ?? 0;

    $db = null; // Close the database connection
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
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
                            <h2> <?php echo $totalEmployees; ?> </h2>
                        </div>
                        <canvas id="seolinechart1" height="50"></canvas>
                    </div>
                </div>
            </div>

                <div class="col-lg-4 col-md-6 mt-3 mb-3">
                    <div class="card">
                        <div class="seo-fact sbg2">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class='fa fa-check-circle'></i> Active </div>
                                <h2> <?php echo $activeEmployees; ?> </h2>
                            </div>
                            <canvas id="seolinechart2" height="50"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt-3 mb-3">
                    <div class="card">
                        <div class="seo-fact sbg3">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class='fa fa-check-circle'></i> Leave</div>
                                <h2> 2 </h2>
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
} else if ($user_role == 2) {

    // Get the logged-in employee's fullname
    $loggedInUserId = $_SESSION['admin_id']; // Assuming `user_id` is stored in the session

    try {
        // Reconnect to the database
        $db = new PDO("mysql:host=$host_name;dbname=$db_name", $user_name, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query to fetch the employee's schedule
        $sqlSchedule = "
            SELECT s.start_date, s.end_date, s.intime, s.outtime 
            FROM scheduling s
            INNER JOIN tbl_admin a ON s.fullname = a.fullname
            WHERE a.user_id = :userId
            LIMIT 1";

        $stmt = $db->prepare($sqlSchedule);
        $stmt->bindParam(':userId', $loggedInUserId, PDO::PARAM_INT);
        $stmt->execute();

        $scheduleData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Initialize default values
        $startDate = "N/A";
        $endDate = "N/A";
        $intime = "8:00 AM"; // Default time-in
        $outtime = "5:00 PM"; // Default time-out
        $numberOfDays = 0;

        if ($scheduleData) {
            $startDate = $scheduleData['start_date'];
            $endDate = $scheduleData['end_date'];

            // Check for assigned in-time and out-time
            $intime = $scheduleData['intime'] ?? "8:00 AM";
            $outtime = $scheduleData['outtime'] ?? "5:00 PM";

            // Calculate the difference in days
            $startDateObj = new DateTime($startDate);
            $endDateObj = new DateTime($endDate);
            $dateDiff = $startDateObj->diff($endDateObj);
            $numberOfDays = $dateDiff->days + 1; // Add 1 to include the start date
        }

        $db = null; // Close the database connection
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
?>

<div class="main-content-inner">
    <div class="container-fluid">
        <div class="row justify-content-start"> 
            <!-- Schedule Assign Card -->
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <div class="card shadow-sm border-light rounded">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fa fa-calendar"></i> Schedule Assign</h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h2 class="text-center text-success"><?php echo $numberOfDays; ?> Day(s) </h2>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Start Date:</strong> <span class="text-muted"><?php echo $startDate; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>End Date:</strong> <span class="text-muted"><?php echo $endDate; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Time In:</strong> <span class="text-muted"><?php echo $intime; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Time Out:</strong> <span class="text-muted"><?php echo $outtime; ?></span>
                            </li>
                        </ul>
                        <canvas id="seolinechart1" height="50" class="mt-auto"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <div class="card shadow-sm border-light rounded">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fa fa-check-circle"></i> Attendance Count (Monthly)</h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h2 class="text-center text-success"><?php echo $attendanceCount; ?></h2>
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
<?php include '../nav-and-footer/footer-area.php'; ?>