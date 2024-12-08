<?php
$page_name = "Payroll";
include('../nav-and-footer/header-nav.php');

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



//Checks if the payslip record is deleted before the website refreshes
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


if (isset($_POST['add_payslip_button'])) {
  $payroll_id = $_GET['id'];
  $userRole = 2;

  // Check if payslips already exist for the payroll ID
  $check_sql = "SELECT COUNT(*) FROM payslip WHERE payroll_id = :payroll_id";
  $check_stmt = $admin_class->db->prepare($check_sql);
  $check_stmt->bindParam(':payroll_id', $payroll_id);
  $check_stmt->execute();

  if ($check_stmt->fetchColumn() == 0) {
      // Only insert if no payslips exist for this payroll ID
      $insert_sql = "
          INSERT INTO payslip (payroll_id, employee_id)
          SELECT :payroll_id, a.user_id
          FROM tbl_admin a
          JOIN attendance_info ai ON a.user_id = ai.atn_user_id
          JOIN payroll_list pl ON pl.id = :payroll_id
          WHERE a.user_role = :userRole
            AND DATE(ai.in_time) >= pl.start_date
            AND DATE(ai.out_time) <= pl.end_date
            AND ai.total_duration >= 8
            AND a.user_id NOT IN (
              SELECT employee_id 
              FROM payslip 
              WHERE payroll_id = :payroll_id
            )
          GROUP BY a.user_id";

      $insert_stmt = $admin_class->db->prepare($insert_sql);
      $insert_stmt->bindParam(':payroll_id', $payroll_id);
      $insert_stmt->bindParam(':userRole', $userRole, PDO::PARAM_INT);
      $insert_stmt->execute();
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

table {
  width: 100%;
  border-collapse: collapse;
}

th {
  text-align: center;
  padding: 10px;
  border: 1px solid #ddd;
  background-color: #f4f4f9;
  white-space: nowrap; 
  vertical-align: middle; 
}

.table-bordered th, .table-bordered td {
  border: 1px solid #ccc;
}

tr:nth-child(even) {
  background-color: #f9f9f9;
}


.table-bordered th, .table-bordered td {
  border: 1px solid #ccc;
}


tr:nth-child(even) {
  background-color: #f9f9f9;
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
        <h5 class="card-title mb-0">Payroll</h5>
    </div>
    <div class="text-right">
    <div class="d-flex align-items-center">
        <button type="button" class="btn btn-primary ml-2 print-link">Print Payroll</button>

        <!-- <form method="post" style="display:inline;">
          <button type="submit" class="btn btn-primary ml-3" name="add_payslip_button">Add New Payslip</button>
        </form> -->
        <!-- This line below is the old button -->
        <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#addPayslipModal">Add New Employee</button>
    </div>
  </div>
</div>


<!-- We will take out some parts in the modal because of Add new Payslip we dont need its stuff anymore or maybe 
 we will edit it to do something new -->
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

          <div class="col-md-6">
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
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="grossPay">Monthly Pay</label>
              <input type="number" class="form-control" id="grossPay" name="grossPay" placeholder="Enter monthly pay" required>
            </div>
          </div>
        </div>

        <div class="row">
          
          <div class="col-md-4">
            <div class="form-group">
              <label for="specialHolidayHours">Special Holiday Hours</label>
              <input type="number" class="form-control" id="specialHolidayHours" name="specialHolidayHours" placeholder="Enter hours">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="legalHolidayHours">Legal Holidays Hours</label>
              <input type="number" class="form-control" id="legalHolidayHours" name="legalHolidayHours" placeholder="Enter hours">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="restDayHours">Rest Days Hours</label>
              <input type="number" class="form-control" id="restDayHours" name="restDayHours" placeholder="Enter hours">
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
            <div class="table-responsive" >
              <!-- <h4 class="text-center">Deductions</h4> -->
              
              <!-- <table class=" no-wrap table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>SSS-EE</th>
                    <th>PHIC-EE</th>
                    <th>PAG-IBIG-EE</th>
                    <th>Gross Pay</th>
                    <th>Deductions</th>
                    <th>Total Pay</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                   Table data rows go here -->
                </tbody>
              </table> 
            </div>

            <div class="table-responsive" style="overflow-x: auto;">
  <div id="printableTable">
    <table class="no-wrap table table-bordered table-stripped">
      <thead>
        <tr>
          <th rowspan="2">#</th>
          <th rowspan="2">Name</th>
          <th rowspan="2">Monthly Rate</th>
          <th rowspan="2">Semi-Monthly Rate</th>
          <th rowspan="2">Daily</th>
          <th rowspan="2">Hourly</th>
          <th colspan="2">Overtime</th>
          <th colspan="2">Special Holiday</th>
          <th colspan="2">Legal Holiday</th>
          <th colspan="2">Rest Day Duty</th>
          <th colspan="2">Night Differential</th>
          <th colspan="2">Deductions</th>
          <th rowspan="2">Gross Pay</th>
          <th rowspan="2">Deductions Total</th>
          <th rowspan="2">Net Take/Home Pay</th>
          <th rowspan="2">Action</th>
        </tr>
        <tr>
          <th>Hours</th>
          <th>Add 25% Rate</th>

          <th>Hours</th>
          <th>Add 30% Rate</th>

          <th>Hours</th>
          <th>Add 100% Rate</th>

          <th>Hours</th>
          <th>Add 130% Rate</th>

          <th>Hours</th>
          <th>Add 10% Rate</th>

          <th>Absent without Pay</th>
          <th>Late/Undertime</th>
          
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
      // echo '<td><a href="#" class="btn btn-primary print-link">Print</a></td>';
      // echo '<td><a href="#" class="btn btn-danger delete-link" data-id="' . $payslip['id'] . '">Delete</a></td>'; // Attach payslip ID to the delete button
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


<?php

include("../nav-and-footer/footer-area.php");
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
        // var $table = $(this).closest("table").clone();
        var $table = $("#printableTable").clone();

        // Remove the "Print" column and "Action" column from the cloned table
        $table.find("th:last-child, td:last-child").remove();
        // $table.find("th:nth-child(7), td:nth-child(7)").remove();

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
                url: "p_list.php", // Same PHP script URL
                method: "POST",
                data: { delete_id: payslipId }, // Data to send (payslip ID)
                success: function(response) {
                  
                    // // Reload the page or update the table after successful deletion
                    location.reload(); // Reload the page
                    // // You can also remove the row from the table without reloading
                    // // $(this).closest('tr').remove();
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

