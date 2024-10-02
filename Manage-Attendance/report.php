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
            <!-- Start 12 column grid system -->
            <div class="row">
                <div class="col-12">
                    <?php $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d') ?>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="well well-custom rounded-0">
                                <div class="gap"></div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="start_date">Start Date:</label>
                                        <input type="date" id="start_date" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d') ?>" class="form-control rounded-0">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="end_date">End Date:</label>
                                        <input type="date" id="end_date" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d') ?>" class="form-control rounded-0">
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-danger btn-sm btn-menu" type="button" id="pdf"><i class="glyphicon glyphicon-file"></i> PDF </button>
                                        <button class="btn btn-primary btn-sm btn-menu" type="button" id="csv"><i class="glyphicon glyphicon-download"></i> CSV </button>
                                    </div>
                                </div><br>
                                
                                <div class="gap"></div>
                                <div class="gap"></div>
                                <div class="table-responsive" id="printout">
                                    <table id="attendance-report" class="table table-codensed table-custom table-hover">
                                        <thead class="text-uppercase bg-primary text-white">
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
                                            
                                            $sql = "SELECT a.*, b.fullname 
                                                    FROM attendance_info a
                                                    LEFT JOIN tbl_admin b ON(a.atn_user_id = b.user_id) 
                                                    WHERE date(a.in_time) BETWEEN '{$start_date}' AND '{$end_date}'
                                                    ORDER BY date(a.in_time) ASC"; // Order by start date
                                            
                                            $info = $obj_admin->manage_all_info($sql);
                                            $serial  = 1;
                                            $num_row = $info->rowCount();
                                            
                                            $total_seconds = 0; // Initialize total seconds
                                            
                                            if($num_row==0){
                                                echo '<tr><td colspan="7">No Data found</td></tr>';
                                            }
                                            while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
                                            ?>
                                            <tr>
                                                <td><?php echo $serial; ?></td>
                                                <td><?php echo $row['fullname']; ?></td>
                                                <td><?php echo $row['in_time']; ?></td>
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
        </div>
    </div>
</div>
<!-- Bootstrap Grid end -->

<?php include("../etms/include/footer.php"); ?>
<?php include("../nav-and-footer/footer-area.php"); ?>


<script>
    // Handle the PDF generation
    document.getElementById('pdf').addEventListener('click', function () {
        // Get the date for the header
        
        var start_date = "<?= date('F d, Y', strtotime($start_date)) ?>"; 
        var end_date = "<?= date('F d, Y', strtotime($end_date)) ?>"; 

        // Create jsPDF instance
        const { jsPDF } = window.jspdf;
        var pdf = new jsPDF('p', 'pt', 'a4');

        // Add the header content (from <noscript>)
        pdf.setFontSize(12);
        pdf.setFont('Helvetica', 'bold');
        pdf.text(300, 40, 'Eternal Bright Sanctuary Inc.', { align: 'center' });
        pdf.text(300, 60, 'Attendance Report', { align: 'center' });
        pdf.setFont('Helvetica', 'normal');
        pdf.text(300, 80, 'as of', { align: 'center' });

        pdf.text(300, 100, start_date + ' - ' + end_date, { align: 'center' }); 

        // Draw a line below the header
        pdf.line(40, 110, 560, 110); // Horizontal line

        // Prepare the table data
        var table = document.querySelector("table");
        var rows = [];
        
        // Get table rows
        table.querySelectorAll("tbody tr").forEach(function (row) {
            var rowData = [];
            row.querySelectorAll("td").forEach(function (cell) {
                rowData.push(cell.innerText);
            });
            rows.push(rowData);
        });

        // Get table headers
        var headers = [];
        table.querySelectorAll("thead th").forEach(function (th) {
            headers.push(th.innerText);
        });

        // Add the table to the PDF using autoTable
        pdf.autoTable({
            head: [headers],
            body: rows,
            startY: 120 // Start below the header
        });

        // Add the total hours below the table
        pdf.text(40, pdf.autoTable.previous.finalY + 20, "Total Hours: <?= $total_hours_formatted ?>");

        // Get the real-time date for the filename
        var now = new Date();
        var dateString = now.getFullYear() + "-" +
                         ("0" + (now.getMonth() + 1)).slice(-2) + "-" +
                         ("0" + now.getDate()).slice(-2);
                         
        // Save the generated PDF with the real-time date in the filename
        pdf.save("Attendance_Report_" + dateString + ".pdf");
    });


    // Handle the CSV generation
    document.getElementById('csv').addEventListener('click', function () {
        // Get the table element
        var table = document.querySelector("table");

        // Prepare an array to store CSV data
        var csv = [];

        // Get the table headers
        var headers = [];
        table.querySelectorAll("thead th").forEach(function (th) {
            headers.push(th.innerText);
        });
        csv.push(headers.join(",")); // Join the headers with commas

        // Get the table rows
        var totalSeconds = 0; // Initialize total seconds for all durations

        table.querySelectorAll("tbody tr").forEach(function (row) {
            var rowData = [];
            row.querySelectorAll("td").forEach(function (cell, index) {
                if (index === 4) { // If the column is "Total Duration"
                    // Convert the total duration into seconds
                    var duration = cell.innerText.split(':');
                    var hours = parseInt(duration[0], 10);
                    var minutes = parseInt(duration[1], 10);
                    var seconds = parseInt(duration[2], 10);
                    totalSeconds += (hours * 3600) + (minutes * 60) + seconds;
                }
                rowData.push(cell.innerText);
            });
            csv.push(rowData.join(",")); // Join row data with commas
        });

        // Calculate the total hours, minutes, and seconds
        var totalHours = Math.floor(totalSeconds / 3600);
        var totalMinutes = Math.floor((totalSeconds % 3600) / 60);
        var totalSecondsRemaining = totalSeconds % 60;

        // Format the total time as HH:MM:SS
        var totalFormatted = `${String(totalHours).padStart(2, '0')}:${String(totalMinutes).padStart(2, '0')}:${String(totalSecondsRemaining).padStart(2, '0')}`;

        // Add the total hours to the CSV
        csv.push(`,,,,Total Hours: ${totalFormatted}`);

        // Create a CSV Blob
        var csvFile = new Blob([csv.join("\n")], { type: "text/csv" });

        // Create a link element for download
        var downloadLink = document.createElement("a");
        var currentDate = "<?= date('Y-m-d') ?>"; // Current date for file name

        downloadLink.download = `Attendance_Report_${currentDate}.csv`;

        // Create a URL for the CSV file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Programmatically click the download link to trigger download
        downloadLink.click();
    });



</script>


<script type="text/javascript">

function updateURLParameter(url, param, paramVal) {
        var newAdditionalURL = "";
        var tempArray = url.split("?");
        var baseURL = tempArray[0];
        var additionalURL = tempArray[1];
        var temp = "";

        if (additionalURL) {
            var tempArray = additionalURL.split("&");
            for (var i=0; i < tempArray.length; i++) {
                if (tempArray[i].split('=')[0] != param) {
                    newAdditionalURL += temp + tempArray[i];
                    temp = "&";
                }
            }
        }

        var rows_txt = temp + "" + param + "=" + paramVal;
        return baseURL + "?" + newAdditionalURL + rows_txt;
    }

    // Event listeners for the date inputs
    document.getElementById('start_date').addEventListener('change', function() {
        var newUrl = updateURLParameter(window.location.href, 'start_date', this.value);
        window.location.href = updateURLParameter(newUrl, 'end_date', document.getElementById('end_date').value);
    });

    document.getElementById('end_date').addEventListener('change', function() {
        var newUrl = updateURLParameter(window.location.href, 'end_date', this.value);
        window.location.href = updateURLParameter(newUrl, 'start_date', document.getElementById('start_date').value);
    });


</script>
