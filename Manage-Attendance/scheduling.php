<?php
$page_name = "Scheduling";
include('../nav-and-footer/header-nav.php');

$dbInstance = new Admin_Class(); 
$pdo = $dbInstance->db; 

if ($pdo === null) {
    die("Database connection not established.");
}

$query = "SELECT fullname FROM tbl_admin";
$result = $pdo->query($query); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['employee_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $intime = $_POST['intime'];
    $outtime = $_POST['outtime'];

    $query = "INSERT INTO scheduling (fullname, start_date, end_date, intime, outtime) 
              VALUES (:fullname, :start_date, :end_date, :intime, :outtime)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':fullname' => $name,
        ':start_date' => $start_date,
        ':end_date' => $end_date,
        ':intime' => $intime,
        ':outtime' => $outtime
    ]);

    header('Location: ../Manage-Attendance/scheduling.php');
    exit();
}

// Fetch existing scheduling data to display in the calendar
$schedulingQuery = "SELECT fullname, start_date, end_date FROM scheduling";
$schedulingResult = $pdo->query($schedulingQuery);
$scheduleEvents = [];

// Define array of colors for different employees
$employeeColors = [
    '#FF5733', '#33FF57', '#3357FF', '#FF33A5', '#33FFA5', '#FFAA33', '#AA33FF'
];

// Function to get initials
function getInitials($name) {
  $nameParts = explode(' ', $name);
  return strtoupper($nameParts[0][0]); // Only get the first letter of the first name
}

// Function to assign a color based on employee name
function getEmployeeColor($name, $employeeColors) {
    $nameHash = crc32($name);  // Generate a unique hash for each employee
    $index = $nameHash % count($employeeColors); // Map the hash to the color array
    return $employeeColors[$index];
}

// Function to generate events for each day in the date range
function createDailyEvents($fullname, $startDate, $endDate, $employeeColors) {
    $events = [];
    $initials = getInitials($fullname);
    $color = getEmployeeColor($fullname, $employeeColors);

    // Create DateTime objects
    $currentDate = new DateTime($startDate);
    $endDate = new DateTime($endDate);

    // Loop from start date to end date
    while ($currentDate <= $endDate) {
        $events[] = [
            'title' => $initials,
            'start' => $currentDate->format('Y-m-d'),
            'end' => $currentDate->format('Y-m-d'),
            'backgroundColor' => $color,  // Assign unique color for each employee
            'fullName' => $fullname // Add full name for tooltip
        ];

        // Move to the next day
        $currentDate->modify('+1 day');
    }

    return $events;
}

while ($row = $schedulingResult->fetch(PDO::FETCH_ASSOC)) {
    // Create daily events for each entry
    $dailyEvents = createDailyEvents($row['fullname'], $row['start_date'], $row['end_date'], $employeeColors);
    $scheduleEvents = array_merge($scheduleEvents, $dailyEvents);
}
?>


<!-- FullCalendar CSS and JS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>

<style>
    #calendar {
        max-width: 100%;
        margin: 0 auto;
    }
    .assign-button-container {
        text-align: right;
        margin-bottom: 15px;
    }

    /* Design for event initials in a row */
      .fc-event {
          display: inline-flex;
          justify-content: center;
          align-items: center;
          background-color: #007bff; 
          color: white;
          height: 30px;
          width: 30px;
          font-weight: bold;
          text-transform: uppercase; 
          border-radius: 50%; 
          margin: 0 5px;
      }

      .event-initials-container {
          display: flex; 
          flex-wrap: nowrap;
          gap: 5px; /* Space between initials */
      }

      .fc-event div {
          display: inline-block;
          width: 30px;
          height: 30px;
          background-color: inherit; /* Match event color */
          color: white;
          font-size: 14px;
          line-height: 30px;
          text-align: center;
          border-radius: 50%; /* Circular initials */
      }

      /* Tooltip customization for a rectangle shape */
      .tooltip-inner {
          background-color: #333;
          color: #fff;
          font-size: 14px;
          padding: 8px;
          border-radius: 5px; /* Rounded rectangle */
      }

      .tooltip {
          opacity: 1 !important; /* Ensure visibility */
          width: auto !important;
          white-space: nowrap;
      }

    /* Responsive styles */
    @media (max-width: 768px) {
        #calendar {
            font-size: 0.8rem; /* Adjust font size for smaller screens */
        }
        .fc-event {
            height: 30px;
            width: 30px;
        }
    }
</style>

<div class="col-12 mt-3 mb-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="assign-button-container">
                        <button type="button" id="openModalButton" class="btn btn-primary" disabled>Assign Employee</button>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="well well-custom">
                                <div id="calendar"></div>
                                
                                <!-- Modal for assigning time in/out -->
                                <div class="modal fade" id="timeModal" tabindex="-1" role="dialog" aria-labelledby="timeModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="timeModalLabel">Assign Time for Employee</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>

                                      <div class="modal-body">
                                        <form method="POST" action="scheduling.php">
                                            <div class="form-group">
                                                <label for="selectedStartDate">Start Date:</label>
                                                <input type="text" id="selectedStartDate" name="start_date" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="selectedEndDate">End Date:</label>
                                                <input type="text" id="selectedEndDate" name="end_date" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="employeeName">Employee Name:</label>
                                                <select id="employeeName" name="employee_name" class="form-control">
                                                    <option value="">Select Employee</option>
                                                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                                                        <option value="<?php echo $row['fullname']; ?>">
                                                            <?php echo $row['fullname']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="intime">In Time:</label>
                                                <input type="time" id="intime" name="intime" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="outtime">Out Time:</label>
                                                <input type="time" id="outtime" name="outtime" class="form-control" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
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

<?php
include("../etms/include/footer.php");
include("../nav-and-footer/footer-area.php");
?>

<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery (must be loaded before Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (required for Bootstrap dropdowns) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

<!-- Bootstrap JS (make sure this comes after jQuery and Popper.js) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var selectedRange = {};
    var openModalButton = document.getElementById('openModalButton');

    // PHP scheduling data to a JavaScript array
    var scheduleEvents = <?php echo json_encode($scheduleEvents); ?>;

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        selectMirror: true,
        height: 'auto',
        contentHeight: 'auto',
        aspectRatio: 1.35,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        initialDate: new Date(),
        nowIndicator: true,

        // When a date range is selected
        select: function(info) {
            selectedRange.start = info.startStr;
            selectedRange.end = info.endStr;

            // Enable the Assign Employee button once a date range is selected
            openModalButton.disabled = false;
        },

        // Custom event content for limiting initials and showing tooltips
        eventContent: function(info) {
            var attendees = [info.event.title];  
            var initialsToShow = attendees.slice(0, 4);  
            var moreCount = attendees.length > 4 ? `...${attendees.length - 4}` : '';
            
            var container = document.createElement('div');
            container.classList.add('event-initials-container');
            
            // Add initials to the container
            initialsToShow.forEach(function(initial) {
                var initialDiv = document.createElement('div');
                initialDiv.innerText = initial;
                initialDiv.style.backgroundColor = info.event.backgroundColor; // Set color
                container.appendChild(initialDiv);
            });

            // Add "more" count if applicable
            if (moreCount) {
                var moreDiv = document.createElement('div');
                moreDiv.innerText = moreCount;
                container.appendChild(moreDiv);
            }

            return { domNodes: [container] };
        },

        events: scheduleEvents,

       
        
        eventMouseEnter: function(info) {
            // Show full name as tooltip on hover
            $(info.el).tooltip({
                title: info.event.extendedProps.fullName,
                placement: 'top',
                trigger: 'hover',
                container: 'body'
            });
            $(info.el).tooltip('show');
        },

        eventMouseLeave: function(info) {
            // Remove tooltip when mouse leaves
            $(info.el).tooltip('dispose');
        }
    });

    calendar.render();

    openModalButton.addEventListener('click', function() {
        if (selectedRange.start && selectedRange.end) {
            document.getElementById('selectedStartDate').value = selectedRange.start;
            document.getElementById('selectedEndDate').value = selectedRange.end;
            var modalElement = document.getElementById('timeModal');
            var modal = new bootstrap.Modal(modalElement);
            modal.show();
        }
    });
});

</script>

