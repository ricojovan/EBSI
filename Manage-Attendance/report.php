<?php 
if(isset($_SERVER['HTTPS'])){
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
} else {
    $protocol = 'http';
}
$base_url = $protocol . "://".$_SERVER['SERVER_NAME'].'/' .(explode('/',$_SERVER['PHP_SELF'])[1]).'/';
?>

<?php
$page_name = "Daily-Attennce-Report";
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
                                        <input type="date" id="date" value="<?= $date ?>" class="form-control rounded-0">
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary btn-sm btn-menu" type="button" id="filter"><i class="glyphicon glyphicon-filter"></i> Filter</button>
                                        <button class="btn btn-success btn-sm btn-menu" type="button" id="print"><i class="glyphicon glyphicon-print"></i> Print</button>
                                        <button class="btn btn-danger btn-sm btn-menu" type="button" id="pdf"><i class="glyphicon glyphicon-file"></i> PDF</button>
                                    </div>
                                </div>
                                <center><h3>Attendance Report</h3></center>
                                <div class="gap"></div>
                                <div class="gap"></div>
                                <div class="table-responsive" id="printout">
                                    <table class="table table-codensed table-custom table-hover">
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
                                            $sql = "SELECT a.*, b.fullname 
                                                    FROM attendance_info a
                                                    LEFT JOIN tbl_admin b ON(a.atn_user_id = b.user_id) where ('{$date}' BETWEEN date(a.in_time) and date(a.out_time))
                                                    ORDER BY a.aten_id DESC";
                                            $info = $obj_admin->manage_all_info($sql);
                                            $serial  = 1;
                                            $num_row = $info->rowCount();
                                            if($num_row==0){
                                                echo '<tr><td colspan="7">No Data found</td></tr>';
                                            }
                                            while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
                                            ?>
                                            <tr>
                                                <td><?php echo $serial; $serial++; ?></td>
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
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
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
        var currentDate = "<?= date("F d, Y", strtotime($date)) ?>";

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
        pdf.text(300, 100, currentDate, { align: 'center' });

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

        // Get the real-time date for the filename
        var now = new Date();
        var dateString = now.getFullYear() + "-" +
                         ("0" + (now.getMonth() + 1)).slice(-2) + "-" +
                         ("0" + now.getDate()).slice(-2);
                         
        // Save the generated PDF with the real-time date in the filename
        var filename = 'attendance_report_' + dateString + '.pdf';
        pdf.save(filename);

        // Save the generated PDF
        // pdf.save('attendance_report.pdf');
    });
</script>




<noscript>
    <div>
        <style>
            body {
                background-image: none !important;
            }
            .mb-0 {
                margin: 0px;
            }
        </style>
        <div style="line-height:1em">
            <h4 class="mb-0 text-center"><b>Human Resources Management System</b></h4>
            <h4 class="mb-0 text-center"><b>Daily Task Report</b></h4>
            <div class="mb-0 text-center"><b>as of</b></div>
            <div class="mb-0 text-center"><b><?= date("F d, Y", strtotime($date)) ?></b></div>
        </div>
        <hr>
    </div>
</noscript>

<script type="text/javascript">
$(function(){
    $('#filter').click(function(){
        location.href="./attendance.php?date="+$('#date').val()
    })
    $('#print').click(function(){
        var h = $('head').clone()
        var ns = $($('noscript').html()).clone()
        var p = $('#printout').clone()
        var base = '<?= $base_url ?>';
        h.find('link').each(function(){
            $(this).attr('href', base + $(this).attr('href'))
        })
        h.find('script').each(function(){
            if($(this).attr('src') != "")
            $(this).attr('src', base + $(this).attr('src'))
        })
        p.find('.table').addClass('table-bordered')
        var nw = window.open("", "_blank","width:"+($(window).width() * .8)+",left:"+($(window).width() * .1)+",height:"+($(window).height() * .8)+",top:"+($(window).height() * .1))
        nw.document.querySelector('head').innerHTML = h.html()
        nw.document.querySelector('body').innerHTML = ns[0].outerHTML
        nw.document.querySelector('body').innerHTML += p[0].outerHTML
        nw.document.close()
        setTimeout(() => {
            nw.print()
            setTimeout(() => {
                nw.close()
            }, 200);
        }, 200);
    })
})
</script>
