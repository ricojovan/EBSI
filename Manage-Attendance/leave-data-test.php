<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$page_name = "Leave Report";
include('../nav-and-footer/header-nav.php');

$userId = $user_id;

$pendingData = $obj_admin->pending_leave_data_by_id($userId);
$leaveData = $obj_admin->fetch_leave_data_by_id($userId);

var_dump($pendingData, $leaveData);

if (isset($_GET['cancel_pending']) && $_GET['cancel_pending'] === 'cancel_pending' && isset($_GET['pending_id'])) {
    $pendingId = intval($_GET['pending_id']);
    if ($pendingId > 0) {
        $deleteSuccess = $obj_admin->cancel_pending_request($pendingId);
        if ($deleteSuccess) {
            echo "<script>alert('Leave request deleted successfully.');</script>";
            header("Location: leave-data.php");
            exit;
        } else {
            echo "<script>alert('Failed to delete leave request.');</script>";
        }
    } else {
        echo "<script>alert('Invalid leave request ID.');</script>";
    }
}
?>

<style>
    .table-custom tbody tr {
        height: 50px;
    }

    .table-custom tbody td,
    .table-custom thead th {
        vertical-align: middle;
        text-align: center;
    }

    .table-custom tbody td button,
    .table-custom tbody td a {
        margin: auto;
    }
</style>

<div class="col-12 mt-3 mb-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 d-flex justify-content-end">
                    <a href="leave-form-emp.php" class="btn btn-success">
                        <i class="fa fa-plus"></i> Add Leave
                    </a>
                </div>
                <div class="col-12">
                    <div class="container">
                        <div class="col-12 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table id="group-h" class="table table-condensed table-custom table-hover text-center">
                                                <thead class="text-uppercase table-bg-default text-white">
                                                    <tr>
                                                        <th>Employee Name</th>
                                                        <th>Leave Type</th>
                                                        <th>Date Filed</th>
                                                        <th>Classification</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $combinedData = array_merge((array)$pendingData, (array)$leaveData);

                                                    if (!empty($combinedData) && is_array($combinedData)):
                                                        foreach ($combinedData as $key => $data): ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($data['fullname']); ?></td>
                                                                <td><?php echo htmlspecialchars($data['leave_type']); ?></td>
                                                                <td><?php echo htmlspecialchars($data['filed_date']); ?></td>
                                                                <td><?php echo htmlspecialchars($data['status']); ?></td>

                                                                <?php if (!isset($data['isApproved'])): ?>
                                                                    <td>Pending</td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-sm btn-primary view-request-btn"
                                                                            data-leave-type="<?php echo htmlspecialchars($data['leave_type']); ?>"
                                                                            data-w-pay="<?php echo htmlspecialchars($data['w_pay']); ?>"
                                                                            data-from-date="<?php echo htmlspecialchars($data['from_date']); ?>"
                                                                            data-to-date="<?php echo htmlspecialchars($data['to_date']); ?>"
                                                                            data-reason="<?php echo htmlspecialchars($data['reason']); ?>"
                                                                            data-pending-id="<?php echo $data['pending_id']; ?>"
                                                                            data-toggle="modal" data-target="#viewLeaveModal">
                                                                            <i class="fa fa-eye"></i> View Details
                                                                        </button>
                                                                    </td>
                                                                <?php elseif ($data['isApproved'] === 1): ?>
                                                                    <td>Approved</td>
                                                                    <td><button type="button" class="btn btn-sm btn-primary view-request-btn"
                                                                            data-leave-type="<?php echo htmlspecialchars($data['leave_type']); ?>"
                                                                            data-w-pay="<?php echo htmlspecialchars($data['w_pay']); ?>"
                                                                            data-from-date="<?php echo htmlspecialchars($data['from_date']); ?>"
                                                                            data-to-date="<?php echo htmlspecialchars($data['to_date']); ?>"
                                                                            data-reason="<?php echo htmlspecialchars($data['reason']); ?>"
                                                                            data-toggle="modal" data-target="#viewLeaveModal">
                                                                            <i class="fa fa-eye"></i> View Details
                                                                        </button></td>
                                                                <?php elseif ($data['isApproved'] === 0): ?>
                                                                    <td>Rejected</td>
                                                                    <td><button type="button" class="btn btn-sm btn-primary view-request-btn"
                                                                            data-leave-type="<?php echo htmlspecialchars($data['leave_type']); ?>"
                                                                            data-w-pay="<?php echo htmlspecialchars($data['w_pay']); ?>"
                                                                            data-from-date="<?php echo htmlspecialchars($data['from_date']); ?>"
                                                                            data-to-date="<?php echo htmlspecialchars($data['to_date']); ?>"
                                                                            data-reason="<?php echo htmlspecialchars($data['reason']); ?>"
                                                                            data-toggle="modal" data-target="#viewLeaveModal">
                                                                            <i class="fa fa-eye"></i> View Details
                                                                        </button></td>
                                                                <?php else: ?>
                                                                    <td>-</td>
                                                                <?php endif; ?>
                                                            </tr>
                                                        <?php endforeach;
                                                    else: ?>
                                                        <tr>
                                                            <td colspan="6" class="text-center">No leave data available.</td>
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

<!-- View Leave Modal -->
<div class="modal fade" id="viewLeaveModal" tabindex="-1" aria-labelledby="viewLeaveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewLeaveModalLabel">Leave Request Details</h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Leave Type:</strong> <span id="viewLeaveType"></span></p>
                <p><strong>Pay:</strong> <span id="viewPay"></span></p>
                <p><strong>From Date:</strong> <span id="viewFromDate"></span></p>
                <p><strong>To Date:</strong> <span id="viewToDate"></span></p>
                <p><strong>Reason:</strong> <span id="viewReason"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger cancel-request-btn"
                    data-dismiss="modal" data-pending-id="">
                    <i class="fa fa-trash-o"></i> Cancel Request
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Leave Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="cancelModalLabel">Confirm Cancellation</h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to cancel this leave request?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="confirmCancel">Yes, Cancel Request</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.view-request-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            console.log('View button clicked');

            var lType = this.getAttribute('data-leave-type');
            var wPay = this.getAttribute('data-w-pay') == 1 ? "With Pay" : "Without Pay";
            var fromDate = this.getAttribute('data-from-date');
            var toDate = this.getAttribute('data-to-date');
            var reason = this.getAttribute('data-reason');
            var pendingId = this.getAttribute('data-pending-id');

            document.getElementById('viewLeaveType').textContent = lType;
            document.getElementById('viewPay').textContent = wPay;
            document.getElementById('viewFromDate').textContent = fromDate;
            document.getElementById('viewToDate').textContent = toDate;
            document.getElementById('viewReason').textContent = reason;

            document.querySelector('.cancel-request-btn').setAttribute('data-pending-id', pendingId);

            var viewLeaveModal = document.getElementById('viewLeaveModal');
            var viewModal = new bootstrap.Modal(viewLeaveModal);
            viewModal.show();
        });
    });

    document.querySelectorAll('.cancel-request-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            console.log('Cancel button clicked from View Modal');

            var pendingId = this.getAttribute('data-pending-id');
            document.getElementById('confirmCancel').setAttribute('data-pending-id', pendingId);

            var viewLeaveModal = document.getElementById('viewLeaveModal');
            var cancelModal = document.getElementById('cancelModal');

            var viewModal = new bootstrap.Modal(viewLeaveModal);
            var cancelModalInstance = new bootstrap.Modal(cancelModal);

            viewModal.hide();

            cancelModalInstance.show();
        });
    });
    
    document.getElementById('confirmCancel').addEventListener('click', function() {
        var pendingId = this.getAttribute('data-pending-id');
        if (pendingId) {
            console.log('Cancelling leave request with ID:', pendingId);
            window.location.href = "?cancel_pending=cancel_pending&pending_id=" + pendingId;
        } else {
            alert('No pending ID found.');
        }
    });
</script>

<?php include '../nav-and-footer/footer-area.php'; ?>