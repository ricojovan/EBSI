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

function is_absent($employee_id, $date, $admin_class) {
    $sql = "SELECT in_time FROM attendance_info WHERE atn_user_id = :employee_id AND DATE(in_time) = :date";
    $stmt = $admin_class->db->prepare($sql);
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $attendance = $stmt->fetch(PDO::FETCH_ASSOC);

    // if INTIME is not null, employee is not absent i.e. returns FALSE
    if ($attendance && !empty($attendance['in_time'])) {
        return false; 
    }

    return true;  // if INTIME is null, employee is absent
}


function calculate_minutes_late($employee_id, $date, $admin_class) {
    $sql = "SELECT TIMESTAMPDIFF(MINUTE, TIME('08:00:00'), TIME(in_time)) AS minutes_late 
            FROM attendance_info 
            WHERE atn_user_id = :employee_id 
            AND DATE(in_time) = :date 
            AND TIME(in_time) > '08:00:00'";
    $stmt = $admin_class->db->prepare($sql);
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $minutes_late = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($minutes_late !== false && isset($minutes_late['minutes_late'])) {
        return $minutes_late['minutes_late'];
    }

    return 0;  // return 0 if no late record was found
}

function calculate_overtime_hours($employee_id, $date, $admin_class) {
    $sql = "SELECT * 
      FROM attendance_info 
      WHERE atn_user_id = :employee_id 
      AND DATE(in_time) = :date";
    $stmt = $admin_class->db->prepare($sql);
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $emp_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($emp_data !== false && isset($emp_data['in_time'])) {
        $in_time = new DateTime($emp_data['in_time']);
        $out_time = new DateTime($emp_data['out_time']);
        $overtime_hours = 0;

        // calculate total worked hours
        $total_work_hours = $out_time->diff($in_time)->h + ($out_time->diff($in_time)->i / 60); // includes fractional hours

        if ($total_work_hours > 8) {
            $overtime_hours = $total_work_hours - 8;
        }

        return $overtime_hours; 
    }

    return 0; 
}

function calculate_night_hours($employee_id, $date, $admin_class) {
    $sql = "SELECT * 
            FROM attendance_info 
            WHERE atn_user_id = :employee_id 
            AND DATE(in_time) = :date";
    $stmt = $admin_class->db->prepare($sql);
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $emp_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($emp_data !== false && isset($emp_data['in_time'])) {
        $in_time = new DateTime($emp_data['in_time']);
        $out_time = new DateTime($emp_data['out_time']);
        $night_hours = 0;

        $night_start = new DateTime($in_time->format('Y-m-d') . ' 22:00:00');
        $night_end = new DateTime($in_time->format('Y-m-d') . ' 06:00:00');
        $night_end->modify('+1 day');

       // calculate overlap of the employee's shift with the night period
        if ($out_time > $night_start) { // Work overlaps night start
            $start = max($in_time, $night_start); 
            $end = min($out_time, $night_end);    
            
            if ($start < $end) { // check if valid overlap
                $interval = $start->diff($end);
                $night_hours = $interval->h + ($interval->i / 60); // includes fractional hours 
            }
        }

        return $night_hours;
    }

    return 0;
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

function calculate_sss_ee($salary) {
  $range_increment = 500; // Range increment (e.g., 4250 to 4750)
  $msc_increment = 500;   // MSC increment
  $base_msc = 4000;       // Starting MSC
  $base_salary = 4250;    // Starting salary range
  $rate = 0.045;          // Contribution rate

  // check if salary is below first range 4250
  if ($salary < $base_salary) {
      return $base_msc * $rate;
  }

  // Calculate the MSC based on the pattern
  $steps = floor(($salary - $base_salary) / $range_increment);
  $msc = $base_msc + ($msc_increment * ($steps+1)); // Increment MSC by steps

  // if the MSC is 20000 or above, fixed contribution of 900 by employee
  if ($msc >= 20000) {
    return 900; 
  }

  // Return the calculated contribution
  return $msc * $rate;
}

function calculate_pagibig_ee($salary){

  if($salary > 0 && $salary <=  5000.00) {
    return $salary * 0.02;
  } else {
    return 100.00;
  }

}

function calculate_phic_ee($salary){

  if($salary > 0 && $salary <= 10000.00) {
    return (10000.00 * 0.05) / 2;

  } else if ($salary <= 99999.99) {
    return ($salary * 0.05) / 2;

  } else {
    return (100000.00 * 0.05) / 2;

  }


}

// savebutton for add new employee payslip modal
if (isset($_POST['saveButton'])) {
  // Retrieve form data
  $employee_id = $_POST['employee_id'];
  $monthly_pay = $_POST['monthlyPay']; 
  
  // initialize values
  $basic_pay = (float) $monthly_pay / 2;
  $daily_pay = (($basic_pay * 2) * 12) / 313;
  $hourly_pay = $daily_pay / 8;
  $late_rate = ($daily_pay/8) / 60;
  //$special_holiday_hrs = (int) $_POST['specialHolidayHours'] * (($hourly_pay * 0.3) + $hourly_pay);
  //$legal_holiday_hrs = (int) $_POST['legalHolidayHours'] * ($hourly_pay + $hourly_pay);
  //$rest_day_hrs = (int) $_POST['restDayHours'];

  // Retrieve payroll ID from URL
  if (isset($_GET['id'])) {
      $payroll_id = $_GET['id'];
      
      // gets the start date and end date of the payroll period
      $sql= " SELECT start_date, end_date
              FROM payroll_list
              WHERE id = :payroll_id";

      $stmt = $admin_class->db->prepare($sql);
      $stmt->bindParam(':payroll_id', $payroll_id);
      $stmt->execute();
      $payroll_period = $stmt->fetch(PDO::FETCH_ASSOC);

      $payroll_start_date = $payroll_period['start_date'];
      $payroll_end_date = $payroll_period['end_date'];

      // get the date range from the payroll period
      $start_date = date_create($payroll_start_date); 
      $end_date   = date_create($payroll_end_date); 
      $end_date->modify('+1 day'); // +1 day to include the end date
      $interval = DateInterval::createFromDateString('1 day');
      $daterange = new DatePeriod($start_date, $interval, $end_date);

      // initialize the necessary values
      $days_absent = 0;
      $total_minutes_late = 0;
      $total_days = 0;
      $total_night_hours = 0;
      $total_overtime_hours = 0;

      foreach ($daterange as $date) {
          $day = $date->format("Y-m-d");
          $day_of_week = date('N', strtotime($day));

          // if the day is not a sunday and if employee is absent, increment the days_absent counter
          if (is_absent($employee_id, $day, $admin_class) && $day_of_week != 7) {
              $days_absent++;
          } else if ($day_of_week == 7) {
            echo "<script>
              console.log('This day is a Sunday: " . $day . "');
            </script>";
          } else {
            $total_minutes_late += calculate_minutes_late($employee_id, $day, $admin_class);
            $total_night_hours += calculate_night_hours($employee_id, $day, $admin_class);
            $total_overtime_hours += calculate_overtime_hours($employee_id, $day, $admin_class);

            echo "<script>
              console.log('Employee was present on: " . $day . "');
              console.log('Minutes late: " . calculate_minutes_late($employee_id, $day, $admin_class) . "');
              console.log('Night hours: " . calculate_night_hours($employee_id, $day, $admin_class) . "');
              console.log('Overtime hours: " . calculate_overtime_hours($employee_id, $day, $admin_class) . "');
            </script>";
          }
          // note still have to account for other types of days like rest days, special holidays, etc.

          $total_days++;  // get total days in payroll period just for validity
      }

      // debugging values in console
      echo "<script>
        var totaldays = " . json_encode($total_days) . ";
        console.log('Total Days: ' + totaldays);
        var absentdays = " . json_encode($days_absent) . ";
        console.log('Absent Days: ' + absentdays);
        var totalminuteslate = " . json_encode($total_minutes_late) . ";
        console.log('Total minutes late: ' + totalminuteslate);
        console.log('Total night hours: " . $total_night_hours . "');
        console.log('Total overtime hours: " . $total_overtime_hours . "');
      </script>";

      // calculating the gross pay
      $deminimis_allowance = 0; // not included in gross pay
      $adjustments = 0;
      $overtime_pay = $total_overtime_hours * ($hourly_pay * 1.25);
      $special_holiday_pay = (int) $_POST['specialHolidayHours'] * (($daily_pay * 0.3));
      $legal_holiday_pay = (int) $_POST['legalHolidayHours'] * $daily_pay;
      $rest_day_pay = 0;
      $night_pay = $total_night_hours * ($hourly_pay * 0.1);
      $absent_penalty = $daily_pay * $days_absent;      // deduction
      $late_penalty = $late_rate * $total_minutes_late; // deduction

      $gross_pay = $basic_pay - $absent_penalty - $late_penalty + $overtime_pay + $special_holiday_pay + $legal_holiday_pay + $rest_day_pay + $night_pay + $adjustments;

      // replace basic pay with gross pay
      $sss_ee = calculate_sss_ee($basic_pay);         // assuming the ee contribution is based off the gross pay
      $pabibig_ee = calculate_pagibig_ee($basic_pay);
      $phic_ee = calculate_phic_ee($basic_pay);
      $sss_loan = $_POST['sssLoan'];
      $pagibig_loan = $_POST['pagibigLoan'];
      $pagibig_mp2 = $_POST['pagibigMP2'];
      $withholding_tax = 0; // not yet implemented
      $company_loan_mc = $_POST['companyLoanMC'];
      $company_loan_cash = $_POST['companyLoanCash'];
      $vault_loan = $_POST['vaultLoan'];

      // placed all the deductions inside total_deductions for now
      $total_deductions = $sss_ee + $phic_ee + $pabibig_ee + $sss_loan + $pagibig_loan + $withholding_tax + $company_loan_mc + $vault_loan;
      $total_pay = $gross_pay - $total_deductions;  // assume total_pay is net take home pay

      echo "<script>
            console.log('SSS-EE contribution based off basic pay " . $basic_pay . " : " . $sss_ee . "');
            console.log('PHIC-EE contribution based off basic pay " . $basic_pay . " : " . $phic_ee . "');
            console.log('PAG-IBIG-EE contribution based off basic pay " . $basic_pay . " : " . $pabibig_ee . "');
            console.log('SSS Loan: " . $sss_loan . "');
            console.log('PAG-IBIG Loan: " . $pagibig_loan . "');
            console.log('PAG-IBIG MP2: " . $pagibig_mp2 . "');
            console.log('Company Loan (MC): " . $company_loan_mc . "');
            console.log('Company Loan (Cash): " . $company_loan_cash . "');
            console.log('Vault Loan: " . $vault_loan . "');
            console.log('Withholding Tax: " . $withholding_tax . "');
          </script>";
      // Insert into payslip table
      $sql = "INSERT INTO payslip (payroll_id, employee_id, monthly_pay, basic_pay, daily_pay, hourly_pay, deminimis_allowance,
                                    overtime_pay, rest_day_pay, night_pay, legal_holiday_pay, special_holiday_pay,
                                    adjustments, total_deductions, total_pay) 
      VALUES (:payroll_id, :employee_id, :monthly_pay, :basic_pay, :daily_pay, :hourly_pay, :deminimis_allowance,
              :overtime_pay, :rest_day_pay, :night_pay, :legal_holiday_pay, :special_holiday_pay, :adjustments,
              :total_deductions, :total_pay)";
      $stmt = $admin_class->db->prepare($sql);
      $stmt->bindParam(':payroll_id', $payroll_id);
      $stmt->bindParam(':employee_id', $employee_id);
      $stmt->bindParam(':monthly_pay', $monthly_pay);
      $stmt->bindParam(':basic_pay', $basic_pay);
      $stmt->bindParam(':daily_pay', $daily_pay);
      $stmt->bindParam(':hourly_pay', $hourly_pay);
      $stmt->bindParam(':deminimis_allowance', $deminimis_allowance);
      $stmt->bindParam(':overtime_pay', $overtime_pay);
      $stmt->bindParam(':rest_day_pay', $rest_day_pay);
      $stmt->bindParam(':night_pay', $night_pay);
      $stmt->bindParam(':legal_holiday_pay', $legal_holiday_pay);
      $stmt->bindParam(':special_holiday_pay', $special_holiday_pay);
      $stmt->bindParam(':adjustments', $adjustments);
      $stmt->bindParam(':total_deductions', $total_deductions);
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
<!-- ADD NEW PAYSLIP Modal -->
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
              <label for="employee_id"><b>Employee</b></label>
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
              <label for="monthlyPay"><b>Monthly Pay</b></label>
              <input type="number" class="form-control" id="monthlyPay" name="monthlyPay" placeholder="Enter monthly pay" required>
            </div>
          </div>
        </div>

        <hr class="hr hr-blurry" />

        <div class="row">
          
          <div class="col-md-4">
            <div class="form-group">
              <label for="specialHolidayHours"><b>Special Holiday Hours</b></label>
              <input type="number" class="form-control" id="specialHolidayHours" name="specialHolidayHours" placeholder="Enter hours">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="legalHolidayHours"><b>Legal Holidays Hours</b></label>
              <input type="number" class="form-control" id="legalHolidayHours" name="legalHolidayHours" placeholder="Enter hours">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="restDayHours"><b>Rest Days Hours</b></label>
              <input type="number" class="form-control" id="restDayHours" name="restDayHours" placeholder="Enter hours">
            </div>
          </div>
        </div>

        <hr class="hr hr-blurry" />

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="sssLoan"><b>SSS Loan</b></label>
              <input type="number" class="form-control" id="sssLoan" name="sssLoan" placeholder="Enter amount">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="pagibigLoan"><b>PAG-IBIG Loan</b></label>
              <input type="number" class="form-control" id="pagibigLoan" name="pagibigLoan" placeholder="Enter amount">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="pagibigMP2"><b>PAG-IBIG MP2</b></label>
              <input type="number" class="form-control" id="pagibigMP2" name="pagibigMP2" placeholder="Enter amount">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="companyLoanMC"><b>Company Loan (MC)</b></label>
              <input type="number" class="form-control" id="companyLoanMC" name="companyLoanMC" placeholder="Enter amount">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="companyLoanCash"><b>Company Loan (Cash)</b></label>
              <input type="number" class="form-control" id="companyLoanCash" name="companyLoanCash" placeholder="Enter amount">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="vaultLoan"><b>Vault Loan</b></label>
              <input type="number" class="form-control" id="vaultLoan" name="vaultLoan" placeholder="Enter amount">
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
      //echo '<td>' . $payslip['created_at'] . '</td>';
      echo '<td>' . $payslip['employee_id'] . '</td>';
      echo '<td>' . $payslip['monthly_pay'] . '</td>';
      echo '<td>' . $payslip['basic_pay'] . '</td>';
      echo '<td>' . $payslip['daily_pay'] . '</td>';
      echo '<td>' . $payslip['hourly_pay'] . '</td>';
      echo '<td>&nbsp;</td>'; // Overtime Hours
      echo '<td>' . $payslip['overtime_pay'] . '</td>';
      echo '<td>&nbsp;</td>'; // Special Holiday Hours
      echo '<td>' . $payslip['special_holiday_pay'] . '</td>';
      echo '<td>&nbsp;</td>'; // Legal Holiday Hours
      echo '<td>' . $payslip['legal_holiday_pay'] . '</td>';
      echo '<td>&nbsp;</td>'; // Rest Days Hours
      echo '<td>' . $payslip['rest_day_pay'] . '</td>';
      echo '<td>&nbsp;</td>'; // Night Differential Hours
      echo '<td>' . $payslip['night_pay'] . '</td>';
      echo '<td>&nbsp;</td>'; // Absent penalty
      echo '<td>&nbsp;</td>'; // Late penalty
      echo '<td>&nbsp;</td>'; // Gross pay
      echo '<td>' . $payslip['total_deductions'] . '</td>'; // Deductions
      echo '<td>' . $payslip['total_pay'] . '</td>'; // Net Take Home pay
      //echo '<td>' . $payslip['project_based_pay'] . '</td>';
      //echo '<td>' . $payslip['monthly_pay'] . '</td>';
      //echo '<td>' . $payslip['total_pay'] . '</td>';
      // echo '<td><a href="payslip_pdf.php" class="btn btn-primary">Print</a></td>';
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

<!-- <script type="text/javascript">
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
</script> -->

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

