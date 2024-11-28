<?php

$page_name = "Leave Report";
include('../nav-and-footer/header-nav.php');

$userId = $user_id;

$pendingData = $obj_admin->pending_leave_data_by_id($userId);
$leaveData = $obj_admin->fetch_leave_data_by_id($userId);

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
                                                                <td><?php echo htmlspecialchars((new DateTime($data['filed_date']))->format('Y-m-d')); ?>
                                                                </td>
                                                                <td><?php echo htmlspecialchars($data['status']); ?></td>

                                                                <?php if (!isset($data['isApproved'])): ?>
                                                                    <td>Pending</td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-sm btn-primary view-request-btn"
                                                                            data-leave-type="<?php echo htmlspecialchars($data['leave_type']); ?>"
                                                                            data-w-pay="<?php echo htmlspecialchars($data['w_pay']); ?>"
                                                                            data-from-date="<?php
                                                                                            $date = new DateTime($data['from_date']);
                                                                                            echo htmlspecialchars($date->format('Y-m-d'));
                                                                                            ?>"

                                                                            data-to-date="<?php
                                                                                            $date = new DateTime($data['to_date']);
                                                                                            echo htmlspecialchars($date->format('Y-m-d'));
                                                                                            ?>"

                                                                            data-filed-date="<?php
                                                                                                $date = new DateTime($data['filed_date']);
                                                                                                echo htmlspecialchars($date->format('Y-m-d'));
                                                                                                ?>"

                                                                            data-days="<?php echo htmlspecialchars($data['days']); ?>"
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
                                                                        </button></td>
                                                                <?php elseif ($data['isApproved'] === 0): ?>
                                                                    <td>Rejected</td>
                                                                    <td><button type="button" class="btn btn-sm btn-primary view-request-btn"
                                                                            data-leave-type="<?php echo htmlspecialchars($data['leave_type']); ?>"
                                                                            data-w-pay="<?php echo htmlspecialchars($data['w_pay']); ?>"
                                                                            data-from-date="<?php echo htmlspecialchars($data['from_date']); ?>"
                                                                            data-to-date="<?php echo htmlspecialchars($data['to_date']); ?>"
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
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="details">
            </div>
            <div class="modal-footer">
                <button type="button" id="cancel" class="btn btn-sm btn-danger cancel-request-btn"
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

            const detailsContainer = document.getElementById('details');

            var Data = [];

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
            var pendingId = this.getAttribute('data-pending-id');
            var stat = "";
            if (approved == 1 || approved == 0) {
                if (approved == 1) {
                    stat = "Approved";
                } else {
                    stat = "Rejected";
                }
                Data = {
                    "Leave Type": lType,
                    "Pay": wPay,
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
                    "Leave Type": lType,
                    "Pay": wPay,
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
            document.querySelector('.cancel-request-btn').setAttribute('data-pending-id', pendingId);
            var viewLeaveModal = document.getElementById('viewLeaveModal');
            var viewModal = new bootstrap.Modal(viewLeaveModal);
            viewModal.show();
        });
    });

    document.querySelectorAll('.cancel-request-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            console.log('Cancel button clicked from View Modal');

            e.preventDefault();

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