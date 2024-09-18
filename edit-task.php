<?php
$page_name = "Edit Task";
include('nav-and-footer/header-nav.php');

// Authentication check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: login_and_sign-in_form.php');
    exit(); // Stop further execution
}

// Check admin role
$user_role = $_SESSION['user_role'];

$task_id = $_GET['task_id'];

if(isset($_POST['update_task_info'])){
    $obj_admin->update_task_info($_POST, $task_id, $user_role);
}

// Fetch task details
$sql = "SELECT * FROM task_info WHERE task_id='$task_id'";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center bg-primary text-white py-3 mb-4">Edit Task</h3>
                    <form class="form-horizontal" role="form" action="" method="post" autocomplete="off">
                        <div class="form-group">
                            <label class="control-label">Task Title</label>
                            <input type="text" placeholder="Task Title" id="task_title" name="task_title" list="expense" class="form-control rounded-0" value="<?= $row['t_title']; ?>" <?php if($user_role != 1){ ?> readonly <?php } ?> required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Task Description</label>
                            <textarea name="task_description" id="task_description" placeholder="Task Description" class="form-control rounded-0" rows="5" cols="5"><?= $row['t_description']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Start Time</label>
                            <input type="text" name="t_start_time" id="t_start_time"  class="form-control rounded-0" value="<?= $row['t_start_time']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">End Time</label>
                            <input type="text" name="t_end_time" id="t_end_time" class="form-control rounded-0" value="<?= $row['t_end_time']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Assign To</label>
                                <?php 
			                        $sql = "SELECT user_id, fullname FROM tbl_admin WHERE user_role = 2";
			                        $info = $obj_admin->manage_all_info($sql);   
			                      ?>
                            <select class="form-control rounded-0" name="assign_to" id="assign_to" <?php if($user_role != 1){ ?> disabled <?php } ?>>
                                <option value="">Select</option>
                                <?php while($rows = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                                <option value="<?= $rows['user_id']; ?>" <?php if($rows['user_id'] == $row['t_user_id']){ ?> selected <?php } ?>><?= $rows['fullname']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select class="form-control rounded-0" name="status" id="status">
                                <option value="0" <?php if($row['status'] == 0){ ?>selected <?php } ?>>Incomplete</option>
                                <option value="1" <?php if($row['status'] == 1){ ?>selected <?php } ?>>In Progress</option>
                                <option value="2" <?php if($row['status'] == 2){ ?>selected <?php } ?>>Completed</option>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" name="update_task_info" class="btn btn-primary rounded-0 px-4">Update Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript">
  flatpickr('#t_start_time', {
    enableTime: true
  });

  flatpickr('#t_end_time', {
    enableTime: true
  });
</script>
<br>
<?php
include("etms/include/footer.php");
include("nav-and-footer/footer-area.php");
?>
