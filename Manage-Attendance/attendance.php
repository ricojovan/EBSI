<?php

$page_name="Attendance";
include('../nav-and-footer/header-nav.php');

// require 'etms\authentication.php'; // admin authentication check 
if (isset($_POST['aten_id']) && isset($_POST['elapsed_time']) && isset($_POST['total_pause_duration'])) {
  $aten_id = $_POST['aten_id'];
  $elapsed_time = $_POST['elapsed_time']; // In milliseconds
  $total_pause_duration = $_POST['total_pause_duration']; // In milliseconds

  // Convert elapsed time and pause time to the total duration
  $total_duration = max(0, $elapsed_time - $total_pause_duration); // Subtract paused time from elapsed time
  
  // Convert milliseconds to time format
  $hours = floor($total_duration / 3600000);
  $minutes = floor(($total_duration % 3600000) / 60000);
  $seconds = floor(($total_duration % 60000) / 1000);
  $formatted_duration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

  $sql = "UPDATE attendance_info SET total_duration = :total_duration WHERE aten_id = :aten_id";
  $stmt = $db->prepare($sql);
  $stmt->execute([
      ':total_duration' => $formatted_duration,
      ':aten_id' => $aten_id
  ]);

  if ($stmt->rowCount()) {
      echo 'Elapsed time saved successfully.';
  } else {
      echo 'Failed to save elapsed time.';
  }
}


// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
$user_role = $_SESSION['user_role'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: ../Interface/login.php');
}
if(isset($_GET['delete_attendance'])){
  $action_id = $_GET['aten_id'];
  
  $sql = "DELETE FROM attendance_info WHERE aten_id = :id";
  $sent_po = "../Manage-Attendance/attendance.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}


if(isset($_POST['add_punch_in'])){
   $info = $obj_admin->add_punch_in($_POST);
}

if(isset($_POST['add_punch_out'])){
    $obj_admin->add_punch_out($_POST);
}


$page_name="Attendance";
// include("include/sidebar.php");

//$info = "Hello World";
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Bootstrap Grid start -->
<div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <!-- Start 12 column grid system -->
                                <div class="row">
                                    <div class="col-12">
                                        
                                    <div class="row">
      <div class="col-md-12">
        <div class="well well-custom">
          <div class="row">
            <div class="col-md-8 ">
              <div class="btn-group">
                <?php 
               
                  $sql = "SELECT * FROM attendance_info
                          WHERE atn_user_id = $user_id AND out_time IS NULL";
                

                  $info = $obj_admin->manage_all_info($sql);
                  $num_row = $info->rowCount();
                  if($num_row==0){
              ?>

                <div class="btn-group">
                  <form method="post" role="form" action="">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <button type="submit" name="add_punch_in" class="btn btn-primary btn-lg rounded" >Time In</button>
                  </form>
                  
                </div>

              <?php } ?>

              </div>
            </div>
            
          </div>

          <center><h3>Manage Attendance</h3>  </center>
          <div class="gap"></div>

          <div class="gap"></div>

          <div class="table-responsive">
            <table id="group-d" class="table table-codensed table-custom table-hover">
              <thead class="text-uppercase bg-primary text-white">
                <tr>
                  <th>S.N.</th>
                  <th>Name</th>
                  <th>In Time</th>
                  <th>Out Time</th>
                  <th>Total Duration</th>
                  <th>Status</th>
                  <?php if($user_role == 1){ ?> <?php } ?>
                  <th <?php if($user_role == 2){  ?> style="display:none" <?php } ?>>Action</th>
                  
                </tr>
              </thead>
              <tbody>

              <?php 
                if($user_role == 1){
                  $sql = "SELECT a.*, b.fullname 
                  FROM attendance_info a
                  LEFT JOIN tbl_admin b ON(a.atn_user_id = b.user_id)
                  ORDER BY a.aten_id DESC";
                }else{
                  $sql = "SELECT a.*, b.fullname 
                  FROM attendance_info a
                  LEFT JOIN tbl_admin b ON(a.atn_user_id = b.user_id)
                  WHERE atn_user_id = $user_id
                  ORDER BY a.aten_id DESC";

                }
                

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
                  <td>
                    <span id="stopwatch">
                        <?php echo ($row['total_duration']) ? $row['total_duration'] : '00:00:00'; ?>
                    </span>
                  </td>
                  <?php if($row['out_time'] == null){ ?>
                  <td>
                    <form method="post" role="form" action="">
                      <input type="hidden" name="punch_in_time" value="<?php echo $row['in_time']; ?>">
                      <input type="hidden" name="aten_id" value="<?php echo $row['aten_id']; ?>">

                      <button type="submit" name="add_punch_out" class="btn btn-warning btn-xs rounded">Pause Time</button>
                      
                      <button type="submit" name="add_punch_out" class="btn btn-danger btn-xs rounded" >Time Out</button>
                      <button id="pause-resume-btn" class="btn btn-primary btn-xs rounded">Pause</button>
                    </form>
                  </td>
                <?php }else{ ?>
                <td class="text-center">
                  ------
                </td>
                <?php } ?>
                <?php if($user_role == 1){ ?>
                 <td>
                  <a title="Delete" href="?delete_attendance=delete_attendance&aten_id=<?php echo $row['aten_id']; ?>" onclick=" return check_delete();"><i class="fa fa-trash-o"></i></a>
                </td>
                <?php }else{ ?>
                <td>
                </td>
                <?php } ?>
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

    


<?php

include("../etms/include/footer.php");
include("../nav-and-footer/footer-area.php");


?>

<script>
let stopwatchInterval;
let elapsedTime = 0;
let isPaused = false;
let startTime;
let pauseResumeBtn;
let storedElapsedTime = 0;
let totalPausedTime = 0;  // Total paused time
let lastPauseTime = 0;     // Time when last pause was triggered

// Initialize the stopwatch with stored data from the server (if available)
function initStopwatch(initialElapsedTime) {
  elapsedTime = initialElapsedTime || 0;
  document.getElementById('stopwatch').textContent = formatTime(elapsedTime);
}

// Start the stopwatch
function startStopwatch() {
  lastPauseTime = Date.now(); // Set the lastPauseTime when starting
  stopwatchInterval = setInterval(() => {
    if (!isPaused) {
      const currentTime = Date.now();
      elapsedTime = storedElapsedTime + (currentTime - lastPauseTime);
      document.getElementById('stopwatch').textContent = formatTime(elapsedTime);
    }
  }, 1000);
}

// Pause the stopwatch
function pauseStopwatch() {
  clearInterval(stopwatchInterval);
  isPaused = true;
  pauseStartTime = Date.now(); // Store the time when pause is clicked
  pauseResumeBtn.textContent = 'Resume';
}

// Resume the stopwatch
function resumeStopwatch() {
  if (isPaused) {
    isPaused = false;
    const pauseDuration = Date.now() - pauseStartTime; // Calculate the pause duration
    totalPauseDuration += pauseDuration; // Add it to the total pause time
    elapsedTime = storedElapsedTime - pauseDuration; // Remove pause duration from elapsed time
    lastPauseTime = Date.now(); // Reset lastPauseTime when resuming
    startStopwatch();
    pauseResumeBtn.textContent = 'Pause';
  }
}

// Add event listener to the pause-resume button
pauseResumeBtn = document.getElementById('pause-resume-btn');
pauseResumeBtn.addEventListener('click', function(event) {
  event.preventDefault();  // Prevent form reload
  if (isPaused) {
    resumeStopwatch();
  } else {
    pauseStopwatch();
  }
});

// When "Time Out" is clicked, stop the stopwatch and submit the correct time
document.querySelector('form').addEventListener('submit', function(event) {
  clearInterval(stopwatchInterval);
  document.querySelector('input[name="elapsed_time"]').value = elapsedTime;
  document.querySelector('input[name="total_pause_duration"]').value = totalPauseDuration;
  console.log('Submitting Elapsed Time:', elapsedTime);
  console.log('Submitting Total Pause Duration:', totalPauseDuration);
});


// Format time into hh:mm:ss
function formatTime(ms) {
  const totalSeconds = Math.floor(ms / 1000);
  const hours = Math.floor(totalSeconds / 3600);
  const minutes = Math.floor((totalSeconds % 3600) / 60);
  const seconds = totalSeconds % 60;
  return `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
}

function pad(num) {
  return num < 10 ? '0' + num : num;
}

// Safely handle total_duration from PHP
let totalDuration = '<?php echo isset($row['total_duration']) ? $row['total_duration'] : "00:00:00"; ?>';
let initialElapsedTime = totalDuration !== '00:00:00' ? convertToMilliseconds(totalDuration) : 0;

// Initialize the stopwatch with the stored data and start
initStopwatch(initialElapsedTime);
startStopwatch();
</script>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>