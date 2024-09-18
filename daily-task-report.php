<head>
    <title>Task Report</title>
</head>

<?php 
if(isset($_SERVER['HTTPS'])){
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
} else {
    $protocol = 'http';
}
$base_url = $protocol . "://".$_SERVER['SERVER_NAME'].'/' .(explode('/',$_SERVER['PHP_SELF'])[1]).'/';

$page_name = "Daily-Task-Report";
include('nav-and-footer/header-nav.php');

$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];

if ($user_id == NULL || $security_key == NULL) {
    header('Location: login_and_sign-in_form.php');
}

$user_role = $_SESSION['user_role'];

if(isset($_GET['delete_task'])){
    $action_id = $_GET['task_id'];
    $sql = "DELETE FROM task_info WHERE task_id = :id";
    $sent_po = "task-info.php";
    $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

if(isset($_POST['add_task_post'])){
    $obj_admin->add_new_task($_POST);
}
?>

<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?php $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d') ?>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well well-custom rounded-0">
                                <div class="gap"></div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="date" id="date" value="<?= $date ?>" class="form-control rounded-0">
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary btn-sm btn-menu" type="button" id="filter"><i class="glyphicon glyphicon-filter"></i> Filter</button>
                                        <button class="btn btn-success btn-sm btn-menu" type="button" id="print"><i class="glyphicon glyphicon-print"></i> Print</button>
                                    </div>
                                </div>
                                <center><h3>Daily Task Report</h3></center>
                                <div class="gap"></div>
                                <div class="gap"></div>
                                <div class="table-responsive" id="printout">
                                    <table class="table table-codensed table-custom table-hover">
                                        <thead class="text-uppercase bg-primary text-white">
                                            <tr>
                                                <th>#</th>
                                                <th>Task Title</th>
                                                <th>Assigned To</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if($user_role == 1){
                                                $sql = "SELECT a.*, b.fullname 
                                                        FROM task_info a
                                                        INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id) 
                                                        WHERE ('{$date}' BETWEEN date(a.t_start_time) and date(a.t_end_time))
                                                        ORDER BY a.task_id DESC";
                                            } else {
                                                $sql = "SELECT a.*, b.fullname 
                                                        FROM task_info a
                                                        INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                                                        WHERE a.t_user_id = $user_id 
                                                        AND ('{$date}' BETWEEN date(a.t_start_time) and date(a.t_end_time))
                                                        ORDER BY a.task_id DESC";
                                            } 
                                            $info = $obj_admin->manage_all_info($sql);
                                            $serial = 1;
                                            $num_row = $info->rowCount();
                                            if($num_row == 0){
                                                echo '<tr><td colspan="7">No Data found</td></tr>';
                                            }
                                            while($row = $info->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                            <tr>
                                                <td><?= $serial ?></td>
                                                <td><?= $row['t_title'] ?></td>
                                                <td><?= $row['fullname'] ?></td>
                                                <td><?= $row['t_start_time'] ?></td>
                                                <td><?= $row['t_end_time'] ?></td>
                                                <td>
                                                    <?php  
                                                    if($row['status'] == 1){
                                                        echo '<span class="badge badge-warning px-3">In Progress <i class="glyphicon glyphicon-refresh"></i></span>';
                                                    } elseif($row['status'] == 2){
                                                        echo '<span class="badge badge-success px-3">Completed <i class="glyphicon glyphicon-ok"></i></span>';
                                                    } else {
                                                        echo '<span class="badge badge-secondary px-3">Incomplete <i class="glyphicon glyphicon-remove"></i></span>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php $serial++; } ?>
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

<?php include("etms/include/footer.php"); ?>
<?php include("nav-and-footer/footer-area.php"); ?>

<noscript>
    <div>
        <style>
            body {
                background-image: none !important;
            }
            .mb-0 {
                margin: 0px;
            }
        </style>
        <div style="line-height:1em">
            <h4 class="mb-0 text-center"><b>Human Resources Management System</b></h4>
            <h4 class="mb-0 text-center"><b>Daily Task Report</b></h4>
            <div class="mb-0 text-center"><b>as of</b></div>
            <div class="mb-0 text-center"><b><?= date("F d, Y", strtotime($date)) ?></b></div>
        </div>
        <hr>
    </div>
</noscript>

<script type="text/javascript">
    $(function(){
        $('#filter').click(function(){
            location.href="./daily-task-report.php?date="+$('#date').val()
        })
        $('#print').click(function(){
            var h = $('head').clone()
            var ns = $($('noscript').html()).clone()
            var p = $('#printout').clone()
            var base = '<?= $base_url ?>';
            h.find('link').each(function(){
                $(this).attr('href', base + $(this).attr('href'))
            })
            h.find('script').each(function(){
                if($(this).attr('src') != "")
                $(this).attr('src', base + $(this).attr('src'))
            })
            p.find('.table').addClass('table-bordered')
            var nw = window.open("", "_blank","width:"+($(window).width() * .8)+",left:"+($(window).width() * .1)+",height:"+($(window).height() * .8)+",top:"+($(window).height() * .1))
            nw.document.querySelector('head').innerHTML = h.html()
            nw.document.querySelector('body').innerHTML = ns[0].outerHTML
            nw.document.querySelector('body').innerHTML += p[0].outerHTML
            nw.document.close()
            setTimeout(() => {
                nw.print()
                setTimeout(() => {
                    nw.close()
                }, 200);
            }, 200);
        })
    })
</script>
