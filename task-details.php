<?php

$page_name = "Edit Task";
include('nav-and-footer/header-nav.php');

// Auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

// Check admin role
$user_role = $_SESSION['user_role'];

$task_id = $_GET['task_id'];

if(isset($_POST['update_task_info'])){
    $obj_admin->update_task_info($_POST, $task_id, $user_role);
}

$sql = "SELECT a.*, b.fullname 
        FROM task_info a
        LEFT JOIN tbl_admin b ON (a.t_user_id = b.user_id)
        WHERE task_id='$task_id'";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <h3 class="text-center bg-primary text-white py-3 mb-4">Task Details</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Task Title</td>
                                            <td><?php echo $row['t_title']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td><?php echo $row['t_description']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Start Time</td>
                                            <td><?php echo $row['t_start_time']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>End Time</td>
                                            <td><?php echo $row['t_end_time']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Assign To</td>
                                            <td><?php echo $row['fullname']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td><?php
                                                if($row['status'] == 1){
                                                    echo "In Progress";
                                                } elseif($row['status'] == 2){
                                                    echo "Completed";
                                                } else{
                                                    echo "Incomplete";
                                                } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center">
                                <a title="Update Task" href="task-info.php"><span class="btn btn-success btn-xs">Go Back</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include("etms/include/footer.php");
include("nav-and-footer/footer-area.php");

?>
