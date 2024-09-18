<?php
$page_name = "Payslip List";
include('nav-and-footer/header-nav.php');

// Create an instance of the admin class
$admin_class = new admin_class();

// Function to get payroll type
function get_payroll_type($type) {
    switch ($type) {
        case 1:
            return 'Monthly';
        case 2:
            return 'Semi-Monthly';
        case 3:
            return 'Daily';
        default:
            return 'N/A';
    }
}

// Check if the payroll ID is set in the URL
if(isset($_GET['id'])) {
    // Retrieve the payroll ID from the URL
    $payroll_id = $_GET['id'];
    
    // Fetch the payroll details from the database based on the ID
    $sql = "SELECT * FROM payroll_list WHERE id = :id";
    $stmt = $admin_class->db->prepare($sql);
    $stmt->bindParam(':id', $payroll_id);
    $stmt->execute();
    $payroll_details = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch the payroll details from the database based on the ID
    $sql = "SELECT p.*, a.fullname AS employee_id 
            FROM payslip p
            JOIN tbl_admin a ON p.employee_id = a.user_id
            WHERE p.payroll_id = :payroll_id";
    $stmt = $admin_class->db->prepare($sql);
    $stmt->bindParam(':payroll_id', $payroll_id);
    $stmt->execute();
    $payslips = $stmt->fetchAll(PDO::FETCH_ASSOC);
}



// Check if the form is submitted
if (isset($_POST['saveButton'])) {
    // Retrieve form data
    $employee_id = $_POST['employee_id'];
    $commission_percent = $_POST['CommisionPercent'];
    $project_based_pay = $_POST['projectBasedPay'];
    $income_tax_percent = $_POST['incomeTax'];

    // Calculate gross pay and total pay based on inputs (example calculations)
    $gross_pay = $project_based_pay;
    $total_pay = $project_based_pay * (1 - $income_tax_percent);

    // Retrieve payroll ID from URL
    if (isset($_GET['id'])) {
        $payroll_id = $_GET['id'];

        // Insert into payslip table
        $sql = "INSERT INTO payslip (payroll_id, employee_id, commission_percent, project_based_pay, gross_pay, income_tax_percent, total_pay) 
        VALUES (:payroll_id, :employee_id, :commission_percent, :project_based_pay, :gross_pay, :income_tax_percent, :total_pay)";
        $stmt = $admin_class->db->prepare($sql);
        $stmt->bindParam(':payroll_id', $payroll_id);
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->bindParam(':commission_percent', $commission_percent);
        $stmt->bindParam(':project_based_pay', $project_based_pay);
        $stmt->bindParam(':gross_pay', $gross_pay);
        $stmt->bindParam(':income_tax_percent', $income_tax_percent);
        $stmt->bindParam(':total_pay', $total_pay);

        // Execute the query
        if ($stmt->execute()) {
            // Data inserted successfully
            echo '<script>alert("Payslip added successfully.");</script>';

            // Re-fetch payslips for the current payroll ID after insertion
            $sql = "SELECT p.*, a.fullname AS employee_id 
                    FROM payslip p
                    JOIN tbl_admin a ON p.employee_id = a.user_id
                    WHERE p.payroll_id = :payroll_id";
            $stmt = $admin_class->db->prepare($sql);
            $stmt->bindParam(':payroll_id', $payroll_id);
            $stmt->execute();
            $payslips = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Error inserting data
            echo '<script>alert("Failed to add payslip.");</script>';
        }
    }
}
// Check if the delete request is received
if (isset($_POST['delete_id'])) {
  // Retrieve the payslip ID to be deleted
  $payslip_id = $_POST['delete_id'];
  
  // Perform the deletion
  $sql = "DELETE FROM payslip WHERE id = :payslip_id";
  $stmt = $admin_class->db->prepare($sql);
  $stmt->bindParam(':payslip_id', $payslip_id);
  
  if ($stmt->execute()) {
      // Deletion successful
      echo json_encode(['status' => 'success']);
      exit;
  } else {
      // Deletion failed
      echo json_encode(['status' => 'error', 'message' => 'Failed to delete payslip']);
      exit;
  }
}

?>

<style>
    @media print {
    body * {
        visibility: hidden;
    }

    #printableTable, #printableTable * {
        visibility: visible;
    }

    #printableTable {
        width: 100%;
        border-collapse: collapse;
    }

    #printableTable th, #printableTable td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
    }

    #printableTable th {
        background-color: #f2f2f2;
    }

    #printableTable td {
        background-color: #fff;
    }
    
}

    

</style>


<div class="col-lg-8 offset-lg-2 mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">Payroll Details</h5>
            <!-- Display payroll details -->
            <?php if(isset($payroll_details) && !empty($payroll_details)): ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code" class="font-weight-bold">Code:</label>
                            <input type="text" class="form-control" id="code" value="<?= $payroll_details['code'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type" class="font-weight-bold">Type:</label>
                            <input type="text" class="form-control" id="type" value="<?= get_payroll_type($payroll_details['type']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date" class="font-weight-bold">Cut-off Start:</label>
                            <input type="text" class="form-control" id="start_date" value="<?= date("M d, Y", strtotime($payroll_details['start_date'])) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date" class="font-weight-bold">Cut-off End:</label>
                            <input type="text" class="form-control" id="end_date" value="<?= date("M d, Y", strtotime($payroll_details['end_date'])) ?>" readonly>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger mt-4" role="alert">
                    Payroll details not found.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="col-lg-12 mt-4">
    <div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
    <div class="text-center w-100">
        <h5 class="card-title mb-0">Payslip List</h5>
    </div>
    <div class="text-right">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPayslipModal">Add New Payslip</button>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addPayslipModal" tabindex="-1" role="dialog" aria-labelledby="addPayslipModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPayslipModalLabel">Add New Payslip</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="payslipForm" method="post">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="employee_id">Employee</label>
                <select class="form-control" id="employee_id" name="employee_id" style="padding: 5px; font-size: 15px;">
                  <?php
                  // Fetch employees (user_role = 2) from tbl_admin
                  $stmt = $admin_class->db->prepare("SELECT user_id, fullname FROM tbl_admin WHERE user_role = :userRole");
                  $userRole = 2; // Assuming 2 represents employees
                  $stmt->bindParam(':userRole', $userRole, PDO::PARAM_INT);
                  $stmt->execute();

                  // Loop through each employee
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['user_id'] . '">' . $row['fullname'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="CommisionPercent">Commission Percent</label>
                <select class="form-control" id="CommisionPercent" name="CommisionPercent" style="padding: 5px; font-size: 15px;">
                    <option value="5">5%</option>
                    <option value="10">10%</option>
                    <option value="15">15%</option>
                    <option value="20">20%</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="projectBasedPay">Project Based Pay</label>
                <input type="number" class="form-control" id="projectBasedPay" name="projectBasedPay">
              </div>
              <div class="form-group">
                <label for="grossPay">Gross Pay</label>
                <input type="number" class="form-control" id="grossPay" name="grossPay" disabled>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="incomeTax">Income Tax</label>
                <select class="form-control" id="incomeTax" name="incomeTax" style="padding: 5px; font-size: 15px;">
                  <option value="0.00">NONE - 0%</option>
                  <option value="0.02">SSS - 2%</option>
                  <option value="0.02">PhilHealth - 2%</option>
                  <option value="0.02">Pag-IBIG - 2%</option>
                  <option value="0.04">SSS, PhilHealth - 4%</option>
                  <option value="0.04">SSS, Pag-IBIG - 4%</option>
                  <option value="0.04">Pag-IBIG, PhilHealth - 4%</option>
                  <option value="0.06">ALL (SSS, PhilHealth, Pag-IBIG) - 6%</option>
                </select>
              </div>
              <div class="form-group">
                <label for="totalPay">Total Pay</label>
                <input type="number" class="form-control" id="totalPay" name="totalPay" disabled>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="saveButton">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
            <div class="table-responsive">
            <div id="printableTable">
                <table class="table table-bordered table-stripped">
                    <colgroup>
                        <col width="5%">
                        <col width="15%">
                        <col width="20%">
                        <col width="15%">
                        <col width="15%">
                        <col width="10%">
                        <col width="10%">
                        <col width="%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Created At</th>
                            <th>Employee</th>
                            <th>Project Based Pay</th>
                            <th>Gross Pay</th>
                            <th>Total Pay</th>
                            <th>Print</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Loop through each payslip and display it in the table
if (isset($payslips) && !empty($payslips)) {
  $counter = 1;
  foreach ($payslips as $payslip) {
      echo '<tr>';
      echo '<td>' . $counter . '</td>';
      echo '<td>' . $payslip['created_at'] . '</td>';
      echo '<td>' . $payslip['employee_id'] . '</td>';
      echo '<td>' . $payslip['project_based_pay'] . '</td>';
      echo '<td>' . $payslip['gross_pay'] . '</td>';
      echo '<td>' . $payslip['total_pay'] . '</td>';
      echo '<td><a href="#" class="btn btn-primary print-link">Print</a></td>';
      echo '<td><a href="#" class="btn btn-danger delete-link" data-id="' . $payslip['id'] . '">Delete</a></td>'; // Attach payslip ID to the delete button
      echo '</tr>';
      $counter++;
  }
} else {
  echo '<tr><td colspan="8">No payslips found.</td></tr>';
}
                    ?>
                    </tbody>
                </table>
            </div>
            </div>


        </div>
    </div>
</div>

<?php
include("etms/include/footer.php");
include("nav-and-footer/footer-area.php");
?>

<!-- Your JavaScript code here -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    // Function to calculate and update Gross Pay and Total Pay
  function calculatePayslip() {
    let projectBasedPay = parseFloat($('#projectBasedPay').val());
    let commissionPercent = parseFloat($('#CommisionPercent').val()) / 100;
    let incomeTaxPercent = parseFloat($('#incomeTax').val());

    // Calculate Gross Pay
    let grossPay = projectBasedPay - (projectBasedPay * commissionPercent);
    $('#grossPay').val(grossPay.toFixed(2));

    // Calculate Total Pay
    let incomeTaxDeduction = grossPay * incomeTaxPercent;
    let totalPay = grossPay - incomeTaxDeduction;
    $('#totalPay').val(totalPay.toFixed(2));
  }

  // Execute calculation on input change
  $(document).ready(function() {
    $('#projectBasedPay, #CommisionPercent, #incomeTax').on('change', function() {
      calculatePayslip();
    });
  });
</script>

<script>
$(document).ready(function() {
    // Print function when "Print" link is clicked
    $("body").on("click", ".print-link", function() {
        // Get the parent table of the clicked link
        var $table = $(this).closest("table").clone();

        // Remove the "Print" column and "Action" column from the cloned table
        $table.find("th:last-child, td:last-child").remove();
        $table.find("th:nth-child(7), td:nth-child(7)").remove();

        // Create a new window for printing
        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print Payslip</title></head><body>');

        // Add CSS for styling the printable content
        printWindow.document.write('<style>\
            body { font-family: Arial, sans-serif; text-align: center; }\
            table { width: 100%; border-collapse: collapse; }\
            th, td { border: 1px solid #000; padding: 8px; text-align: center; }\
            th { background-color: #f2f2f2; }\
            td { background-color: #fff; }\
            </style>');

        // Append the table content to the new window
        printWindow.document.write($table.prop('outerHTML'));

        // Close the HTML document
        printWindow.document.write('</body></html>');
        printWindow.document.close();

        // Print the content
        printWindow.print();

        return false;
    });
});

$(document).ready(function() {
    // Delete function when "Delete" link is clicked
    $("body").on("click", ".delete-link", function(e) {
        e.preventDefault();
        var payslipId = $(this).data("id");

        // Confirmation dialog before deleting
        if (confirm("Are you sure you want to delete this payslip?")) {
            // Send AJAX request to delete payslip
            $.ajax({
                url: "payslip_list.php", // Same PHP script URL
                method: "POST",
                data: { delete_id: payslipId }, // Data to send (payslip ID)
                success: function(response) {
                    // Reload the page or update the table after successful deletion
                    location.reload(); // Reload the page
                    // You can also remove the row from the table without reloading
                    // $(this).closest('tr').remove();
                },
                error: function(xhr, status, error) {
                    // Handle error if any
                    console.error(xhr.responseText);
                    alert("Error deleting payslip. Please try again.");
                }
            });
        }
    });
});


</script>

