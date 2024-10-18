<?php 
if(isset($_SERVER['HTTPS'])){
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
} else {
    $protocol = 'http';
}
$base_url = $protocol . "://".$_SERVER['SERVER_NAME'].'/' .(explode('/',$_SERVER['PHP_SELF'])[1]).'/';
?>

<?php
$page_name = "Attendance Report";
include('../nav-and-footer/header-nav.php');

$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: ../Interface/login.php');
}

$user_role = $_SESSION['user_role'];

// Handle task deletion and addition
if(isset($_GET['delete_task'])){
    $action_id = $_GET['task_id'];
    $sql = "DELETE FROM task_info WHERE task_id = :id";
    $sent_po = "../task-info.php";
    $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

if(isset($_POST['add_task_post'])){
    $obj_admin->add_new_task($_POST);
}
?>

<!-- Bootstrap Grid start -->
<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>

                    <div class="row">
                        <!-- Start Date -->
                        <div class="col-md-2">
                            <label for="start_date">Start Date:</label>
                            <input type="date" id="start_date" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d') ?>" class="form-control rounded-0">
                        </div>

                        <!-- End Date -->
                        <div class="col-md-2">
                            <label for="end_date">End Date:</label>
                            <input type="date" id="end_date" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d') ?>" class="form-control rounded-0">
                        </div>

                        <!-- Name Search -->
                        <div class="col-md-3">
                            <label for="search_name">Search by Name:</label>
                            <input type="text" id="search_name" value="<?= isset($_GET['name']) ? $_GET['name'] : '' ?>" class="form-control rounded-0" placeholder="Enter Name">
                        </div>

                        <!-- PDF and CSV buttons -->
                        <div class="col-md-3">
                            <button class="btn btn-danger btn-sm btn-menu" type="button" id="pdf"><i class="glyphicon glyphicon-file"></i> PDF </button>
                            <button class="btn btn-primary btn-sm btn-menu" type="button" id="csv"><i class="glyphicon glyphicon-download"></i> CSV </button>
                        </div>
                    </div><br>

                    <!-- Table for Attendance Data -->
                    <div class="table-responsive" id="printout">
                        <table id="attendance-report" class="table table-condensed table-custom table-hover">
                            <thead class="text-uppercase table-bg-default text-white">
                                <tr>
                                    <th>S.N.</th>
                                    <th>Name</th>
                                    <th>In Time</th>
                                    <th>Out Time</th>
                                    <th>Total Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d');
                                $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
                                $search_name = isset($_GET['name']) ? $_GET['name'] : '';

                                // Adjust SQL to filter by date and name
                                $sql = "SELECT a.*, b.fullname 
                                        FROM attendance_info a
                                        LEFT JOIN tbl_admin b ON(a.atn_user_id = b.user_id) 
                                        WHERE date(a.in_time) BETWEEN '{$start_date}' AND '{$end_date}'";

                                if (!empty($search_name)) {
                                    $sql .= " AND b.fullname LIKE '%{$search_name}%'"; // Add name filter
                                }

                                $sql .= " ORDER BY date(a.in_time) ASC";

                                $info = $obj_admin->manage_all_info($sql);
                                $serial  = 1;
                                $num_row = $info->rowCount();
                                
                                $total_seconds = 0; // Initialize total seconds
                                
                                if($num_row==0){
                                    echo '<tr><td colspan="5">No Data found</td></tr>';
                                }
                                while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
                                    // Convert In Time to DateTime object for comparison
                                    $in_time = new DateTime($row['in_time']);
                                    $threshold_time = new DateTime($in_time->format('Y-m-d') . ' 08:10:00');
                                    
                                    // Set the color based on whether in_time is past 8:10 AM
                                    $font_color = ($in_time > $threshold_time) ? 'red' : 'black';
                                ?>
                                <tr>
                                    <td><?php echo $serial; ?></td>
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td style="color: <?php echo $font_color; ?>;">
                                        <?php echo $in_time->format('m-d-Y H:i:s'); ?>
                                    </td>
                                    <td><?php echo $row['out_time']; ?></td>
                                    <td><?php
                                        if($row['total_duration'] == null){
                                            $date = new DateTime('now', new DateTimeZone('Asia/Manila'));
                                            $current_time = $date->format('d-m-Y H:i:s');
                                
                                            $dteStart = new DateTime($row['in_time']);
                                            $dteEnd   = new DateTime($current_time);
                                            $dteDiff  = $dteStart->diff($dteEnd);
                                            echo $dteDiff->format("%H:%I:%S"); 
                                        } else {
                                            echo $row['total_duration'];
                                            
                                            // Calculate total seconds from total_duration
                                            list($hours, $minutes, $seconds) = explode(':', $row['total_duration']);
                                            $total_seconds += ($hours * 3600) + ($minutes * 60) + $seconds;
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php 
                                $serial++;
                                } 
                                
                                // Convert total seconds to hours, minutes, and seconds
                                $total_hours = floor($total_seconds / 3600);
                                $total_minutes = floor(($total_seconds % 3600) / 60);
                                $total_secs = $total_seconds % 60;
                                
                                // Format the total time as HH:MM:SS
                                $total_hours_formatted = sprintf('%02d:%02d:%02d', $total_hours, $total_minutes, $total_secs);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Grid end -->


<?php include("../nav-and-footer/footer-area.php"); ?>

<!-- JavaScript for PDF and CSV generation and search filters -->

<script>

// Handle PDF generation
document.getElementById('pdf').addEventListener('click', function () {
    var start_date = "<?= date('F d, Y', strtotime($start_date)) ?>"; 
    var end_date = "<?= date('F d, Y', strtotime($end_date)) ?>"; 
    const { jsPDF } = window.jspdf;
    var pdf = new jsPDF('p', 'pt', 'a4');

    // Add the header content
    pdf.setFontSize(12);
    pdf.setFont('Helvetica', 'bold');
    pdf.text(300, 40, 'Eternal Bright Sanctuary Inc.', { align: 'center' });
    pdf.text(300, 60, 'Attendance Report', { align: 'center' });
    pdf.setFont('Helvetica', 'normal');
    pdf.text(300, 80, 'as of', { align: 'center' });
    pdf.text(300, 100, start_date + ' - ' + end_date, { align: 'center' }); 

    // Draw a line below the header
    pdf.line(40, 110, 560, 110);

    // Prepare the table data
    var table = document.querySelector("table");
    var rows = [];
    
    // Get table rows
    table.querySelectorAll("tbody tr").forEach(function (row) {
        var rowData = [];
        row.querySelectorAll("td").forEach(function (cell, index) {
            var cellText = cell.innerText;

            // Check if it is the "In Time" column (assuming column index 2)
            if (index === 2) {
                var inTime = new Date(cellText);
                var thresholdTime = new Date(inTime);
                thresholdTime.setHours(8, 10, 0); // Set the threshold to 08:10 AM

                // If In Time is after 08:10 AM, mark it as red
                if (inTime > thresholdTime) {
                    cellText = 'LATE: ' + cellText; // Indicate lateness
                    rowData.push({ content: cellText, styles: { textColor: 'red' } }); // Red font color
                } else {
                    rowData.push(cellText);
                }
            } else {
                rowData.push(cellText);
            }
        });
        rows.push(rowData);
    });

    // Get table headers
    var headers = [];
    table.querySelectorAll("thead th").forEach(function (th) {
        headers.push(th.innerText);
    });

    // Add the table to the PDF
    pdf.autoTable({
        startY: 120,
        head: [headers],
        body: rows,
        theme: 'grid',
        headStyles: { fillColor: [0, 0, 128] },
    });

    // Add the total hours at the end of the report
    var total_hours = '<?= $total_hours_formatted ?>';
    pdf.setFont('Helvetica', 'bold');
    pdf.text(500, pdf.lastAutoTable.finalY + 20, 'Total: ' + total_hours, { align: 'right' });

    // Save the generated PDF
    pdf.save('attendance_report.pdf');
});


// Handle search filters for Name, Start Date, End Date
const inputs = ['start_date', 'end_date', 'search_name'];
inputs.forEach(function (inputId) {
    document.getElementById(inputId).addEventListener('change', function () {
        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;
        var name = document.getElementById('search_name').value;

        var url = "?start_date=" + startDate + "&end_date=" + endDate + "&name=" + name;
        window.location.href = url;
    });
});

// Handle CSV generation
document.getElementById('csv').addEventListener('click', function () {
    var table = document.querySelector("table");
    var csvContent = "";
    
    // Get table headers
    var headers = [];
    table.querySelectorAll("thead th").forEach(function (th) {
        headers.push(th.innerText);
    });
    csvContent += headers.join(",") + "\n";

    // Get table rows
    table.querySelectorAll("tbody tr").forEach(function (row) {
        var rowData = [];
        row.querySelectorAll("td").forEach(function (cell, index) {
            var cellText = cell.innerText;

            // Check if it is the "In Time" column (assuming column index 2)
            if (index === 2) {
                var inTime = new Date(cellText);
                var thresholdTime = new Date(inTime);
                thresholdTime.setHours(8, 10, 0); // Set the threshold to 08:10 AM

                // If In Time is after 08:10 AM, mark it as "LATE"
                if (inTime > thresholdTime) {
                    cellText = 'LATE: ' + cellText; // Indicate lateness
                }
            }

            rowData.push(cellText);
        });
        csvContent += rowData.join(",") + "\n";
    });

    // Append total duration at the end of the CSV
    var total_hours = '<?= $total_hours_formatted ?>';
    csvContent += "\nTotal Hours," + total_hours + "\n";

    // Download the CSV file
    var csvBlob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
    var csvUrl = URL.createObjectURL(csvBlob);
    var hiddenElement = document.createElement("a");
    hiddenElement.href = csvUrl;
    hiddenElement.target = "_blank";
    hiddenElement.download = "attendance_report.csv";
    hiddenElement.click();
});


</script>