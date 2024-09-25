<?php
$page_name="dashboard";

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
    
    <body>
        <!-- page title area end -->
        <div class="main-content-inner">
            <div class="container">
                <div class="row">
                    <!-- seo fact area start -->
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-6 mt-5 mb-3">
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
                            <div class="col-md-6 mt-md-5 mb-3">
                                <div class="card">
                                    <div class="seo-fact sbg2">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon"><i class='fa fa-check-circle'></i> In Progress Task</div>
                                            <h2><?php echo $inProgressCount; ?></h2>
                                        </div>
                                        <canvas id="seolinechart2" height="50"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="seo-fact sbg4">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon">Incomplete</div>
                                            <h2><?php echo $incompleteCount; ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- seo fact area end -->
                     <!-- Map Area -->
                <div class="col-lg-4 mt-5">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="header-title">Marketing Area</h4>
                            <div id="seomap"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content end -->
                </div>
            </div>
        </div>
        <!-- main content area end -->
        <?php include '../nav-and-footer/footer-area.php';?>  
</body>
</html>
