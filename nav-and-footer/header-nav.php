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
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <!--datatable bootstrap 5-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />

    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">


    <link rel="stylesheet" href="../etms//assets/bootstrap-datepicker/css/datepicker.css">
    <link rel="stylesheet" href="./etms//assets/bootstrap-datepicker/css/datepicker-custom.css">

    
    
    <script src="../etms//assets/js/custom.js"></script>
    <script src="../etms//assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="../etms//assets/bootstrap-datepicker/js/datepicker-custom.js"></script>

    <script type="text/javascript">
    
    /* delete function confirmation  */
    function check_delete() {
      var check = confirm('Are you sure you want to delete this?');
        if (check) {
         
            return true;
        } else {
            return false;
      }
    }
  </script>

</head>
<body class="body-bg">       
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <!-- preloader area start -->
    <!-- <div id="preloader">
        <div class="loader"></div>
    </div> -->
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
                                    <li <?php if($page_name == "Payroll" ){echo "class=\"active\"";} ?>>
                                        <a href="../Manage-Payroll/payroll.php"><i class='fa fa-history'></i><span>Payroll</span></a>
                                    </li>
                                    <li <?php if($page_name == "Attendance" ){echo "class=\"active\"";} ?>>
                                        <a href="../Manage-Attendance/attendance.php"><i class="fa fa-calendar-check-o"></i>  Attendance </a>
                                    </li>
                                    <li <?php if($page_name == "Admin" ){echo "class=\"active\"";} ?>>
                                        <a href="../Manage-Admin/manage-admin.php"><i class="fa fa-user"></i>  Administration</span></a>
                                    </li>
                                    <li <?php if($page_name == "Attendance Report" ){echo "class=\"active\"";} ?>>
                                        <a href="../Manage-Attendance/report.php"><i class="fa fa-envelope-o"></i>  Attendance Report</a>
                                    </li>
                        </ul>
                        <?php 
    }else if($user_role == 2){
?>
    <ul class="metismenu" id="menu">
        <li <?php if($page_name == "Attendance" ){echo "class=\"active\"";} ?>><a href="../Manage-Attendance/attendance.php"><i class="fa fa-calendar-check-o"></i>Attendance</a></li>
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
                        <div class="search-box pull-left">
                            <form action="#">
                                <input type="text" name="search" placeholder="Search..." required>
                                <i class="ti-search"></i>
                            </form>
                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li class="dropdown">
                                <i class="ti-bell dropdown-toggle" data-toggle="dropdown">
                                    <span>2</span>
                                </i>
                                <div class="dropdown-menu bell-notify-box notify-box">
                                    <span class="notify-title">You have 3 new notifications <a href="#">view all</a></span>
                                    <div class="nofity-list">
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb"><i class="ti-key btn-danger"></i></div>
                                            <div class="notify-text">
                                                <p>You have Changed Your Password</p>
                                                <span>Just Now</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            
                        </ul>
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
                            <img class="avatar user-thumb" src="../assets/images/author/avatar.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php echo $user_name; ?><i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="?logout=logout">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
             <!-- mobile_menu -->
<div class="col-12 d-block d-lg-none">
<div id="mobile_menu"></div>
</div>   
 
</body>
</html>
