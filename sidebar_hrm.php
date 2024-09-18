
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>HRM - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <!--datatable bootstrap 5-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />

    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">

</head>

<!-- header area start -->
<div class="header-area header-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-9  d-none d-lg-block">
                        <div class="horizontal-menu">
                        <?php
                        $user_role = $_SESSION['user_role'];
                        if($user_role == 1){
                        ?>
                            <nav>
                                <ul id="nav_menu">
                                    <li class="active">
                                        <a href="dashboard.php"><i class='fa fa-bar-chart-o'></i><span>dashboard</span></a>
                                    </li>
                                    <li>
                                        <a href="employee_management.php"><i class='fa fa-users'></i><span>Employee Management</span></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class='fa fa-history'></i><span>Payroll</span></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class='fa fa-history'></i><span>Logs</span></a>
                                    </li>
        <li <?php if($page_name == "Task_Info" ){echo "class=\"active\"";} ?>><a href="./etms/task-info.php">Task Mangement</a></li>
        <li <?php if($page_name == "Attendance" ){echo "class=\"active\"";} ?>><a href="etms/attendance-info.php">Attendance </a></li>
        <li <?php if($page_name == "Admin" ){echo "class=\"active\"";} ?>><a href="manage-admin.php">Administration</span></a></li>
        <li <?php if($page_name == "Daily-Task-Report" ){echo "class=\"active\"";} ?>><a href="daily-task-report.php">Task Report</a></li>
        <li <?php if($page_name == "Daily-Attennce-Report" ){echo "class=\"active\"";} ?>><a href="daily-attendance-report.php">Attendance Report</a></li>
                                </ul>

    <?php 
     }else if($user_role == 2){

      ?>
          <!-- Collect the nav links, forms, and other content for toggling -->
  
      <ul>
        <li <?php if($page_name == "Task_Info" ){echo "class=\"active\"";} ?>><a href="task-info.php">Task Mangement<span style="font-size:16px; color:#5bcad9;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tasks"></span></a></li>
        <li <?php if($page_name == "Attendance" ){echo "class=\"active\"";} ?>><a href="attendance-info.php">Attendance <span style="font-size:16px; color:#5bcad9;" class="pull-right hidden-xs showopacity glyphicon glyphicon-calendar"></span></a></li>
        <li ><a href="?logout=logout">Logout<span style="font-size:16px; color:#5bcad9;" class="pull-right hidden-xs showopacity glyphicon glyphicon-log-out"></span></a></li>
      </ul>
    
      <?php
     }else{
       header('Location: login_and_sign-in_form.php');
     }
    ?>
                            </nav>
                        </div>
                    </div>
                    <!-- nav and search button -->
                    <div class="col-lg-3 clearfix">
                        <div class="search-box">
                            <form action="#">
                                <input type="text" name="search" placeholder="Search..." required>
                                <i class="ti-search"></i>
                            </form>
                        </div>
                    </div>
                    <!-- mobile_menu -->
                    <div class="col-12 d-block d-lg-none">
                        <div id="mobile_menu"></div>
                    </div>
                </div>
            </div>
        </div>