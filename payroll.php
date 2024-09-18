<?php
$page_name = "Payroll";
include('nav-and-footer/header-nav.php');


// Create an instance of the admin class
$admin_class = new admin_class();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_new_payroll'])) {
    // Retrieve form data
    $payroll_code = $_POST['payroll_code'];
    $start_date = $_POST['t_start_time'];
    $end_date = $_POST['t_end_time'];
    $type = $_POST['type'];

    try {
        // Create prepared statement
        $sql = "INSERT INTO payroll_list (code, start_date, end_date, type) VALUES (?, ?, ?, ?)";
        $stmt = $admin_class->db->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(1, $payroll_code);
        $stmt->bindParam(2, $start_date);
        $stmt->bindParam(3, $end_date);
        $stmt->bindParam(4, $type);

        // Execute statement
        if ($stmt->execute()) {
            // Data inserted successfully
            echo "Payroll created successfully!";
        } else {
            // Error occurred
            echo "Error: Unable to create payroll.";
        }
    } catch (PDOException $e) {
        // Handle PDO exception
        echo "Error: " . $e->getMessage();
    }
}


// Handle Delete Action
if (isset($_GET['delete_task']) && isset($_GET['id'])) {
    $action_id = $_GET['id'];

    try {
        $sql = "DELETE FROM payroll_list WHERE id = ?";
        
        // Check if $admin_class and db property are valid
        if ($admin_class && $admin_class->db) {
            $stmt = $admin_class->db->prepare($sql);
            $stmt->bindParam(1, $action_id);

            if ($stmt->execute()) {
                // Delete successful
                $sent_po = "payroll.php";
                header("Location: $sent_po"); // Redirect after successful delete
                exit();
            } else {
                // Error occurred
                echo "Error: Unable to delete payroll.";
            }
        } else {
            echo "Error: Database connection not available.";
        }
    } catch (PDOException $e) {
        // Handle PDO exception
        echo "Error: " . $e->getMessage();
    }
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
                                    <h2 class="modal-title">Create New Payroll</h2>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body rounded-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form role="form" action="" method="post" autocomplete="off">
                                            <div class="form-group">
    <label class="control-label text-p-reset">Payroll Code</label>
    <input type="text" placeholder="Payroll Code" id="payroll_code" name="payroll_code" list="expense" class="form-control rounded-0" required>
</div>
                                                <div class="form-group">
                                                    <label class="control-label text-p-reset">Start Date</label>
                                                    <input type="text" name="t_start_time" id="start_time" class="t_start_time form-control rounded-0">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label text-p-reset">Cut-off Date</label>
                                                    <input type="text" name="t_end_time" id="end_time" class="t_end_time form-control rounded-0">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label text-p-reset">Payroll Type</label>
                                                    <?php
                                                    if(isset($_GET['id']) && $_GET['id'] > 0){
                                                        $qry = $conn->query("SELECT * from payroll_list where id = '{$_GET['id']}' ");
                                                        if($qry->num_rows > 0){
                                                            foreach($qry->fetch_assoc() as $k => $v){
                                                                $$k=$v;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <select class="custom-selec form-control rounded-0" name="type" id="type" required>
                                                        <option value="">Select Employee...</option>
                                                        <option value="1" <?php echo isset($type) && $type == 1 ? 'selected' : '' ?>>Monthly</option>
                                                        <option value="2" <?php echo isset($type) && $type == 2 ? 'selected' : '' ?>>Semi-Monthly</option>
                                                        <option value="3" <?php echo isset($type) && $type == 3 ? 'selected' : '' ?>>Daily</option>
                                                    </select>

                                                    


                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <button type="submit" name="add_new_payroll" class="btn btn-primary rounded-0 btn-block">Create Payroll</button>
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
                                                    <button class="btn btn-info btn-menu" data-toggle="modal" data-target="#myModal">Create New Payroll</button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <center><h3>Payroll Management Section</h3></center>
                                <div class="gap"></div>
                                <div class="gap"></div>
                                <div class="table-responsive">
                                <table id="dataTable3" class="table table-codensed table-custom table-hover">
    <thead class="text-uppercase bg-primary text-white">
        <tr>
            <th>Date Added</th>
            <th>Code</th>
            <th>Start</th>
            <th>End</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch payroll data from the database
        $sql = "SELECT * FROM payroll_list";
        $stmt = $admin_class->db->prepare($sql);
        $stmt->execute();
        $payrolls = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if there are any records
        if ($payrolls) {
            // Loop through each payroll record
            foreach ($payrolls as $row) {
        ?>
                <tr>
                    <td><?php echo $row['date_created']; ?></td>
                    <td><?php echo $row['code']; ?></td>
                    <td><?php echo $row['start_date']; ?></td>
                    <td><?php echo $row['end_date']; ?></td>
                    <td>
                        <?php
                        // Display payroll type based on value
                        switch ($row['type']) {
                            case 1:
                                echo "Monthly";
                                break;
                            case 2:
                                echo "Semi-Monthly";
                                break;
                            case 3:
                                echo "Daily";
                                break;
                            default:
                                echo "Unknown";
                        }
                        ?>
                    </td>
                    <td>
                    <a title="View" href="payslip_list.php?id=<?php echo $row['id']; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                    <a title="Edit" href="#" ><i class="fa fa-folder-open-o"></i></a>&nbsp;&nbsp;
                    <?php if ($user_role == 1) { ?>
                    <a title="Delete" href="#" onclick="confirmDelete(<?php echo $row['id']; ?>);"><i class="fa fa-trash-o"></i></a>

        <?php } ?>
</td>

                </tr>
        <?php
            }
        } else {
            // No records found
            echo '<tr><td colspan="6">No payroll records found</td></tr>';
        }
        ?>
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
    flatpickr('.t_start_time', {
        enableTime: true
    });

    flatpickr('.t_end_time', {
        enableTime: true
    });

    // JavaScript function for delete confirmation
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this payroll record?")) {
            window.location.href = 'payroll.php?delete_task=1&id=' + id;
        }
    }

</script>
