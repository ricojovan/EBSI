<?php
$page_name = "Task_Info";
include('nav-and-footer/header-nav.php');

if (isset($_GET['delete_task'])) {
    $action_id = $_GET['task_id'];

    $sql = "DELETE FROM task_info WHERE task_id = :id";
    $sent_po = "task-info.php";
    $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
}

if (isset($_POST['add_task_post'])) {
    $obj_admin->add_new_task($_POST);
}
?>

<!-- Bootstrap Grid start -->
<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <!-- Start 12 column grid system -->
            <div class="row">
                <div class="col-12">

                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog add-category-modal">
                            <!-- Modal content-->
                            <div class="modal-content rounded-0">
                                <div class="modal-header">
                                    <h2 class="modal-title">Assign New Task</h2>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body rounded-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form role="form" action="" method="post" autocomplete="off">



                                            <!-- <div class="form-group">
    <label class="control-label text-p-reset">Task Title</label>
    <input type="text" placeholder="Task Title" id="task_title" name="task_title" list="expense" class="form-control rounded-0" id="default" required>
</div> -->




                                            <div class="form-group">
    <label class="control-label text-p-reset">Task Title</label>
    <select name="task_title" id="task_title" class="form-control rounded-0" required>
        <option value="">Select Activity...</option>
        <?php
        // Fetch activities from the home_tasks table
        $sql = "SELECT DISTINCT activity FROM home_tasks";
        $result = $obj_admin->manage_all_info($sql);
        
        // Loop through the results and create option elements
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['activity'] . "'>" . $row['activity'] . "</option>";
        }
        ?>
    </select>
</div>
                                                <div class="form-group">
                                                    <label class="control-label text-p-reset">Task Description</label>
                                                    <textarea name="task_description" id="task_description" placeholder="Task Description" class="form-control rounded-0" rows="5" cols="5"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label text-p-reset">Start Time</label>
                                                    <input type="text" name="t_start_time" id="t_start_time" class="form-control rounded-0">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label text-p-reset">End Time</label>
                                                    <input type="text" name="t_end_time" id="t_end_time" class="form-control rounded-0">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label text-p-reset">Assign To</label>
                                                    <?php
                                                    $sql = "SELECT user_id, fullname FROM tbl_admin WHERE user_role = 2";
                                                    $info = $obj_admin->manage_all_info($sql);
                                                    ?>
                                                    <select class="form-control rounded-0" name="assign_to" id="assign_to" required>
                                                        <option value="">Select Employee...</option>
                                                        <?php while ($row = $info->fetch(PDO::FETCH_ASSOC)) { ?>
                                                            <option value="<?php echo $row['user_id']; ?>"><?php echo $row['fullname']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <button type="submit" name="add_task_post" class="btn btn-primary rounded-0 btn-block">Assign Task</button>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <button type="submit" class="btn btn-secondary rounded-0 btn-block" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="well well-custom rounded-0">
                                <div class="gap"></div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="btn-group">
                                            <?php if ($user_role == 1) { ?>
                                                <div class="btn-group">
                                                    <button class="btn btn-info btn-menu" data-toggle="modal" data-target="#myModal">Assign New Task</button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <center><h3>Task Management Section</h3></center>
                                <div class="gap"></div>
                                <div class="gap"></div>
                                <div class="table-responsive">
                                    <table id="dataTable3" class="table table-codensed table-custom table-hover">
                                        <thead class="text-uppercase bg-primary text-white">
                                            <tr>
                                                <th>#</th>
                                                <th>Task Title</th>
                                                <th>Assigned To</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($user_role == 1) {
                                                $sql = "SELECT a.*, b.fullname 
                                                      FROM task_info a
                                                      INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                                                      ORDER BY a.task_id DESC";
                                            } else {
                                                $sql = "SELECT a.*, b.fullname 
                                                FROM task_info a
                                                INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                                                WHERE a.t_user_id = $user_id
                                                ORDER BY a.task_id DESC";
                                            }
                                            $info = $obj_admin->manage_all_info($sql);
                                            $serial  = 1;
                                            $num_row = $info->rowCount();
                                            if ($num_row == 0) {
                                                echo '<tr><td colspan="7">No Data found</td></tr>';
                                            }
                                            while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $serial;
                                                        $serial++; ?></td>
                                                    <td><?php echo $row['t_title']; ?></td>
                                                    <td><?php echo $row['fullname']; ?></td>
                                                    <td><?php echo $row['t_start_time']; ?></td>
                                                    <td><?php echo $row['t_end_time']; ?></td>
                                                    <td>
                                                        <?php if ($row['status'] == 1) {
                                                            echo '<small class="label label-warning px-3" style="background-color: #ffa500; padding: 5px;"> In Progress <i class=\'fa fa-circle-o-notch fa-lg\' style=\'color:#000\'></i> </small>';
                                                        } elseif ($row['status'] == 2) {
                                                            echo '<small class="label label-success px-3" style="background-color: #60f312; padding: 5px;"> Completed <i class=\'fa fa-check fa-lg\' style=\'color:#000\'></i> </small>';
                                                        } else {
                                                            echo '<small class="label label-default border px-3" style="background-color: #ccc; padding: 5px;"> In Complete <i class=\'fa fa-hourglass-start fa-lg\' style=\'color:#000\'></i> </small>';
                                                        } ?>
                                                    </td>
                                                    <td><a title="Update Task" href="edit-task.php?task_id=<?php echo $row['task_id']; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                                        <a title="View" href="task-details.php?task_id=<?php echo $row['task_id']; ?>"><i class="fa fa-folder-open-o"></i></a>&nbsp;&nbsp;
                                                        <?php if ($user_role == 1) { ?>
                                                            <a title="Delete" href="?delete_task=delete_task&task_id=<?php echo $row['task_id']; ?>" onclick=" return check_delete();"><i class="fa fa-trash-o"></i></a></td>
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
<!-- Bootstrap Grid end -->

<?php
include("etms/include/footer.php");
include("nav-and-footer/footer-area.php");
?>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script type="text/javascript">
    flatpickr('#t_start_time', {
        enableTime: true
    });

    flatpickr('#t_end_time', {
        enableTime: true
    });

</script>
