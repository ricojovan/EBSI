<?php
require '../etms/authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: ../Interface/login.php');
}

// check admin
$user_role = $_SESSION['user_role'];
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../assets/images/icon/palinis-po-icon.png" type="image/png">
    <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
    
    <!-- Bootstrap and core CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="../assets/css/styles.css">

    <!-- Datepicker and FullCalendar -->
    <link rel="stylesheet" href="../etms/assets/bootstrap-datepicker/css/datepicker.css">
    <link rel="stylesheet" href="../etms/assets/bootstrap-datepicker/css/datepicker-custom.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/main.min.css' rel='stylesheet' />

    <!-- Amcharts CSS -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Modernizr (for legacy browser support) -->
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js (for dropdowns) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>

    
    
    <!-- Confirmation Function (can stay here if it's small) -->
    <script type="text/javascript">
        function check_delete() {
            return confirm('Are you sure you want to delete this?');
        }
    </script>
</head>

<body>       
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <!-- preloader area start -->
     <!-- <div id="preloader">
        <div class="loader"></div>
    </div>  -->
    <!-- preloader area end -->

    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="../Interface/dashboard.php"><img src="../assets/images/icon/white-logo-small-aeternitas.png" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                    <?php
                        $user_role = $_SESSION['user_role'];
                        if($user_role == 1){
                        ?>
                        <ul class="metismenu" id="menu">
                                    <li <?php if($page_name == "Dashboard" ){echo "class=\"active\"";} ?>>
                                        <a href="../Interface/dashboard.php"><i class='fa fa-bar-chart-o'></i><span>Dashboard</span></a>
                                    </li>
                                    <li class="<?php if(in_array($page_name, ['Attendance', 'Leave Report', 'Overtime Report', 'Scheduling'])) { echo 'active'; } ?>">
                                        <a href="javascript:void(0)" aria-expanded="<?php echo in_array($page_name, ['Attendance', 'Leave Report', 'Overtime Report', 'Scheduling']) ? 'true' : 'false'; ?>">
                                            <i class="fa fa-clock-o"></i><span>Time Keeping</span>
                                        </a>
                                        <ul class="collapse metismenu <?php if(in_array($page_name, ['Attendance', 'Leave Report', 'Overtime Report', 'Scheduling'])) { echo 'in'; } ?>" id="menu">
                                            <li <?php if($page_name == "Attendance" ){echo "class=\"active\"";} ?>><a href="../Manage-Attendance/attendance.php"><span>Attendance</span></a></li>
                                            <li <?php if($page_name == "Leave Report" ){echo "class=\"active\"";} ?>><a href="../Manage-Attendance/leave-report.php"><span>Leave Report</span></a></li>
                                            <li <?php if($page_name == "Overtime Report" ){echo "class=\"active\"";} ?>><a href="../Manage-Attendance/ot-report.php"><span>OT Report</span></a></li>
                                            <li <?php if($page_name == "Scheduling" ){echo "class=\"active\"";} ?>><a href="../Manage-Attendance/scheduling.php"><span>Scheduling</span></a></li>
                                        </ul>
                                    </li>
                                    <li <?php if($page_name == "Payroll" ){echo "class=\"active\"";} ?>>
                                        <a href="../Manage-Payroll/payroll.php"><i class='fa fa-history'></i><span>Payroll</span></a>
                                    </li>
                                    <li <?php if($page_name == "Attendance Report" ){echo "class=\"active\"";} ?>>
                                        <a href="../Manage-Attendance/report.php"><i class="fa fa-envelope-o"></i>&nbsp;Attendance Report</a>
                                    </li>
                                    <li <?php if($page_name == "Admin" ){echo "class=\"active\"";} ?>>
                                        <a href="../Manage-Admin/manage-admin.php"><i class="fa fa-user"></i><span>Administration</span></a>
                                    </li>
                        </ul>
                        <?php 
    }else if($user_role == 2){
?>
    <ul class="metismenu" id="menu">
        <li <?php if($page_name == "Attendance" ){echo "class=\"active\"";} ?>><a href="../Manage-Attendance/attendance.php"><i class="fa fa-calendar-check-o"></i>Attendance</a></li>
        <li <?php if($page_name == "Leave Report" ){echo "class=\"active\"";} ?>><a href="../Manage-Attendance/leave-form-emp.php"><span>Leave Form</span></a></li>
    </ul>
<?php
    }else{
        header('Location: ../Interface/login.php');
    }
?>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <div class="float-right">
                            <div id="currentDateTime" class="text-right d-flex align-items-center bg-light rounded p-2 shadow-sm" style="cursor: pointer;" data-toggle="modal" data-target="#dateDetailsModal">
                                <i class="fa fa-calendar mr-2 text-primary" aria-hidden="true"></i>
                                <div>
                                    <div id="currentDate" class="font-weight-bold"></div>
                                    <div id="currentTime" class="text-muted"></div>
                                </div>
                            </div>
                        </div>
                        <script>
                            function updateDateTime() {
                                var now = new Date();
                                var date = now.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                                var time = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                                document.getElementById('currentDate').textContent = date;
                                document.getElementById('currentTime').textContent = time;
                            }
                            updateDateTime();
                            setInterval(updateDateTime, 1000);

                            document.getElementById('currentDateTime').addEventListener('click', function() {
                                var now = new Date();
                                var details = {
                                    dayOfWeek: now.toLocaleDateString('en-US', { weekday: 'long' }),
                                    dayOfMonth: now.getDate(),
                                    month: now.toLocaleDateString('en-US', { month: 'long' }),
                                    year: now.getFullYear(),
                                    dayOfYear: Math.floor((now - new Date(now.getFullYear(), 0, 0)) / (1000 * 60 * 60 * 24)),
                                    weekNumber: Math.ceil((((now - new Date(now.getFullYear(), 0, 1)) / 86400000) + 1) / 7)
                                };
                                
                                var modalBody = document.querySelector('#dateDetailsModal .modal-body');
                                modalBody.innerHTML = `
                                    <p><strong>Day of Week:</strong> ${details.dayOfWeek}</p>
                                    <p><strong>Day of Month:</strong> ${details.dayOfMonth}</p>
                                    <p><strong>Month:</strong> ${details.month}</p>
                                    <p><strong>Year:</strong> ${details.year}</p>
                                    <p><strong>Day of Year:</strong> ${details.dayOfYear}</p>
                                    <p><strong>Week of Year:</strong> ${details.weekNumber}</p>
                                `;
                            });
                        </script>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="dateDetailsModal" tabindex="-1" role="dialog" aria-labelledby="dateDetailsModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="dateDetailsModalLabel">Date Details</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Date details will be inserted here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left"><?php echo isset($page_name) ? $page_name : ''; ?></h4>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <?php
                                $user_profile = 'avatar.png'; // Default image
                                if (isset($obj_admin)) {
                                    $profile_query = $obj_admin->db->query("SELECT em_profile FROM tbl_admin WHERE fullname = '$user_name'");
                                    if ($profile_query && $profile_result = $profile_query->fetch(PDO::FETCH_ASSOC)) {
                                        $user_profile = $profile_result['em_profile'] ?: 'avatar.png';
                                    }
                                }
                                // Add this line temporarily to debug the path
                                $image_path = "../author/" . htmlspecialchars($user_profile);
                                echo "<!-- Debug: Image path = $image_path -->"; // This will show in page source
                            ?>
                            <img class="avatar user-thumb" 
                                 src="../author/<?php echo htmlspecialchars($user_profile); ?>" 
                                 alt="avatar"
                                 onerror="console.log('Failed to load image:', this.src); this.src='../assets/images/author/avatar.png';">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php echo $user_name; ?><i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="?logout=logout">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
 
<div id="alert-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 1050;"></div>

