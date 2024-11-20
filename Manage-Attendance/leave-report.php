<?php
$page_name = "Leave Report";
include('../nav-and-footer/header-nav.php');
$admin = new Admin_Class();
$leaveData = $admin->pending_leave_data();
?>

<div class="col-12 mt-3 mb-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="col-12 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table id="group-h" class="table table-condensed table-custom table-hover">
                                                <thead class="text-uppercase table-bg-default text-white">
                                                    <tr>
                                                        <th>Employee Name</th>
                                                        <th>Leave Type</th>
                                                        <th>Date Filed</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($leaveData) && is_array($leaveData)): ?>
                                                        <?php foreach ($leaveData as $key => $leave): ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($leave['fullname']); ?></td>
                                                                <td><?php echo htmlspecialchars($leave['leave_type']); ?></td>
                                                                <td><?php echo htmlspecialchars($leave['filed_date']); ?></td>
                                                                <td><?php echo htmlspecialchars($leave['status']); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="5" class="text-center">No leave data available.</td>
                                                        </tr>
                                                    <?php endif; ?>
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
    </div>
</div>

<?php include '../nav-and-footer/footer-area.php'; ?>