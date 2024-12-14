<?php

$page_name = "Leave Report";
include('../nav-and-footer/header-nav.php');

$pendingData = $obj_admin->pending_leave_data();
$leaveData = $obj_admin->fetch_leave_data();

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
                <div class="col-12">
                    <div class="container">
                        <div class="col-12 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>Pending Leave Requests</h4>
                                            <div class="table-responsive">
                                                <table class="table table-condensed table-custom table-hover text-center">
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
                                                        <?php
                                                        if (!empty($pendingData) && is_array($pendingData)):
                                                            foreach ($pendingData as $data): ?>
                                                                <tr>
                                                                    <td><?php echo htmlspecialchars($data['fullname']); ?></td>
                                                                    <td><?php echo htmlspecialchars($data['leave_type']); ?></td>
                                                                    <td><?php echo htmlspecialchars((new DateTime($data['filed_date']))->format('Y-m-d')); ?>
                                                                    <td>Pending</td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-sm btn-primary view-request-btn"
                                                                            data-employee-name="<?php echo htmlspecialchars($data['fullname']); ?>"
                                                                            data-filed-date="<?php echo htmlspecialchars($data['filed_date']); ?>"
                                                                            data-leave-type="<?php echo htmlspecialchars($data['leave_type']); ?>"
                                                                            data-w-pay="<?php echo htmlspecialchars($data['w_pay']); ?>"
                                                                            data-from-date="<?php echo htmlspecialchars($data['from_date']); ?>"
                                                                            data-to-date="<?php echo htmlspecialchars($data['to_date']); ?>"
                                                                            data-filed-date="<?php echo htmlspecialchars($data['filed_date']); ?>"
                                                                            data-days="<?php echo htmlspecialchars($data['days']); ?>"
                                                                            data-reason="<?php echo htmlspecialchars($data['reason']); ?>"
                                                                            data-pending-id="<?php echo $data['pending_id']; ?>"
                                                                            data-user-id="<?php echo $data['user_id']; ?>"
                                                                            data-toggle="modal" data-target="#viewLeaveModal">
                                                                            <i class="fa fa-eye"></i> View Details
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach;
                                                        else: ?>
                                                            <tr>
                                                                <td colspan="5" class="text-center">No pending leave requests available.</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <h4>Leave History</h4>
                                            <div class="table-responsive">
                                                <table class="table table-condensed table-custom table-hover text-center">
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
                                                        <?php
                                                        if (!empty($leaveData) && is_array($leaveData)):
                                                            foreach ($leaveData as $data): ?>
                                                                <tr>
                                                                    <td><?php echo htmlspecialchars($data['fullname']); ?></td>
                                                                    <td><?php echo htmlspecialchars($data['leave_type']); ?></td>
                                                                    <td><?php echo htmlspecialchars((new DateTime($data['filed_date']))->format('Y-m-d')); ?>
                                                                    <td>
                                                                        <?php echo $data['isApproved'] === 1 ? 'Approved' : 'Rejected'; ?>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-sm btn-primary view-request-btn"
                                                                            data-employee-name="<?php echo htmlspecialchars($data['fullname']); ?>"
                                                                            data-filed-date="<?php echo htmlspecialchars((new DateTime($data['filed_date']))->format('Y-m-d')); ?>"
                                                                            data-leave-type="<?php echo htmlspecialchars($data['leave_type']); ?>"
                                                                            data-w-pay="<?php echo htmlspecialchars($data['w_pay']); ?>"
                                                                            data-from-date="<?php echo htmlspecialchars((new DateTime($data['from_date']))->format('Y-m-d')); ?>"
                                                                            data-to-date="<?php echo htmlspecialchars((new DateTime($data['to_date']))->format('Y-m-d')); ?>"
                                                                            data-days="<?php echo htmlspecialchars($data['days']); ?>"
                                                                            data-reason="<?php echo htmlspecialchars($data['reason']); ?>"
                                                                            data-leave-bal="<?php echo htmlspecialchars($data['leave_bal']); ?>"
                                                                            data-leave-req="<?php echo htmlspecialchars($data['leave_req']); ?>"
                                                                            data-new-bal="<?php echo htmlspecialchars($data['new_bal']); ?>"
                                                                            data-ver-by="<?php echo htmlspecialchars($data['ver_by']); ?>"
                                                                            data-req-by="<?php echo htmlspecialchars($data['req_by']); ?>"
                                                                            data-approved="<?php echo htmlspecialchars($data['isApproved']); ?>"
                                                                            data-hr-name="<?php echo htmlspecialchars($data['hr_name']); ?>"
                                                                            data-toggle="modal" data-target="#viewLeaveModal">
                                                                            <i class="fa fa-eye"></i> View Details
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach;
                                                        else: ?>
                                                            <tr>
                                                                <td colspan="5" class="text-center">No leave history available.</td>
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
</div>

<!-- View Leave Modal -->
<div class="modal fade" id="viewLeaveModal" tabindex="-1" aria-labelledby="viewLeaveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewLeaveModalLabel">Leave Request Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="details">
            </div>
            <div class="modal-footer">
                <button type="button" id="cancel" class="btn btn-sm btn-danger cancel-request-btn"
                    data-dismiss="modal" data-pending-id="">
                    <i class="fa fa-pencil"></i> Review Request
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.view-request-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            console.log('View button clicked');

            const detailsContainer = document.getElementById('details');
            const userId = this.getAttribute('data-user-id');
            const pendingId = this.getAttribute('data-pending-id');

            document.getElementById('cancel').setAttribute('data-user-id', userId);
            document.getElementById('cancel').setAttribute('data-pending-id', pendingId);

            var Data = [];

            var employeeName = this.getAttribute('data-employee-name');
            var filedDate = this.getAttribute('data-filed-date');
            var approved = this.getAttribute('data-approved');
            var lType = this.getAttribute('data-leave-type');
            var wPay = this.getAttribute('data-w-pay') == 1 ? "With Pay" : "Without Pay";
            var fromDate = this.getAttribute('data-from-date');
            var toDate = this.getAttribute('data-to-date');
            var days = this.getAttribute('data-days');
            var reason = this.getAttribute('data-reason');
            var leaveBal = this.getAttribute('data-leave-bal');
            var leaveReq = this.getAttribute('data-leave-req');
            var newBal = this.getAttribute('data-new-bal');
            var verBy = this.getAttribute('data-ver-by');
            var reqBy = this.getAttribute('data-req-by');
            var hrName = this.getAttribute('data-hr-name');
            var stat = "";
            if (approved == 1 || approved == 0) {
                if (approved == 1) {
                    stat = "Approved";
                } else {
                    stat = "Rejected";
                }
                Data = {
                    "Full Name": employeeName,
                    "Leave Type": lType,
                    "Pay": wPay,
                    "Filed Date": filedDate,
                    "From Date": fromDate,
                    "To Date": toDate,
                    "Days": days,
                    "Reason": reason,
                    "Leave Balance": leaveBal,
                    "Leave Requested": leaveReq,
                    "New Balance": newBal,
                    "Verified By": verBy,
                    "Requested By": reqBy,
                    "Status": stat,
                    "HR Name": hrName,
                }

                detailsContainer.querySelectorAll('.dynamic-added').forEach(element => element.remove());

                for (const [label, value] of Object.entries(Data)) {
                    const dataElement = document.createElement("p");
                    dataElement.classList.add('dynamic-added');
                    dataElement.innerHTML = `<strong>${label}:</strong> ${value}`;

                    detailsContainer.appendChild(dataElement);
                }
                $('#cancel').hide();
            } else {
                Data = {
                    "Full Name": employeeName,
                    "Leave Type": lType,
                    "Pay": wPay,
                    "Filed Date": filedDate,
                    "From Date": fromDate,
                    "To Date": toDate,
                    "Days": days,
                    "Reason": reason
                }

                detailsContainer.querySelectorAll('.dynamic-added').forEach(element => element.remove());

                for (const [label, value] of Object.entries(Data)) {
                    const dataElement = document.createElement("p");
                    dataElement.classList.add('dynamic-added');
                    dataElement.innerHTML = `<strong>${label}:</strong> ${value}`;

                    detailsContainer.appendChild(dataElement);
                }

                $('#cancel').show();
            }


            var viewLeaveModal = document.getElementById('viewLeaveModal');
            var viewModal = new bootstrap.Modal(viewLeaveModal);
            viewModal.show();
        });
    });

    document.querySelectorAll('.cancel-request-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            const userId = this.getAttribute('data-user-id');
            const pendingId = this.getAttribute('data-pending-id');

            if (userId && pendingId) {
                window.location.href = "leave-form.php?user_id=" + userId + "&pending_id=" + pendingId;
            } else {
                alert('User ID or Pending ID not found.');
            }
        });
    });
</script>

<?php include '../nav-and-footer/footer-area.php'; ?>