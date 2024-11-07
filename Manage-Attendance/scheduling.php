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
    // Check if we are updating an existing schedule
    if (isset($_POST['schedule_id'])) {
        // Update existing schedule
        $schedule_id = $_POST['schedule_id'];
        $name = $_POST['employee_name'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $intime = $_POST['intime'];
        $outtime = $_POST['outtime'];

        $query = "UPDATE scheduling SET fullname = :fullname, start_date = :start_date, end_date = :end_date, intime = :intime, outtime = :outtime WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':fullname' => $name,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':intime' => $intime,
            ':outtime' => $outtime,
            ':id' => $schedule_id
        ]);
    } else {
        // Insert new schedule
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
    }

    header('Location: ../Manage-Attendance/scheduling.php');
    exit();
}

// Fetch existing scheduling data to display in the calendar
$schedulingQuery = "SELECT fullname, start_date, end_date FROM scheduling WHERE start_date >= CURDATE()";
$schedulingResult = $pdo->query($schedulingQuery);
$scheduleEvents = [];

// Define array of colors for different employees
$employeeColors = [
    '#FF5733', '#33FF57', '#3357FF', '#FF33A5', '#33FFA5', '#FFAA33', '#AA33FF'
];

// Function to get initials
function getInitials($name) {
    if (empty($name)) {
        return ''; // Return an empty string if the name is empty
    }
    
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

// Fetch past scheduling data to display in the logs
$pastSchedulingQuery = "SELECT id, fullname, start_date, end_date FROM scheduling WHERE end_date < CURDATE() ORDER BY end_date DESC";
$pastSchedulingResult = $pdo->query($pastSchedulingQuery);
$pastScheduleLogs = [];

// Fetch past scheduling data
while ($row = $pastSchedulingResult->fetch(PDO::FETCH_ASSOC)) {
    $pastScheduleLogs[] = $row;
}

// Fetch all employee names from the database
$employeeNames = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $employeeNames[] = $row['fullname'];
}

// Initialize a variable to check if there are any matches
$noResults = true; // Assume no results initially

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedEmployee = $_POST['employee_name'];
    // Validate if the selected employee exists in the database
    if (!in_array($selectedEmployee, $employeeNames)) {
        $errorMessage = "Invalid employee name. Please select a valid employee.";
    } else {
        // Proceed with form processing (e.g., save to database)
        // ...
    }
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

    #full-name-display {
        font-size: 14px;
        padding: 5px; /* Adjust padding for better alignment */
        background-color: rgba(0, 0, 0, 0.8); /* Dark background for contrast */
        color: white;
        border-radius: 5px;
        position: absolute;
        display: none;
        z-index: 1000;
        white-space: nowrap;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);
        transition: opacity 0.2s ease;
        /* Set a minimum width for better alignment */
        min-width: 100px; 
        text-align: center; /* Center text */
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
        .fc-event div {
            width: 25px;
            height: 25px;
            font-size: 12px; 
            line-height: 25px;
        }
    }
    @media (max-width: 576px) {
        #calendar {
            font-size: 0.7rem; /* Smaller font size for mobile phones */
        }
        .fc-event div {
            width: 20px;
            height: 20px;
            font-size: 10px; /* Adjust font size even smaller for initials */
            line-height: 20px;
        }

        /* Modal adjustments for small screens */
        .modal-dialog {
            max-width: 90%;
            margin: 1.75rem auto;
        }

        /* Full name display adjustment for small screens */
        #full-name-display {
            font-size: 12px;
            padding: 10px;
            max-width: 150px;
        }
    }

    .input-group {
        width: 100%; /* Full width */
    }
    .input-group input {
        border-radius: 0.25rem 0 0 0.25rem; /* Rounded corners */
    }
    .input-group-append .input-group-text {
        border-radius: 0 0.25rem 0.25rem 0; /* Rounded corners */
    }
    .form-control {
        border: 1px solid #ced4da; /* Custom border color */
    }
    .form-control:focus {
        border-color: #80bdff; /* Focus border color */
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Focus shadow */
    }

    #searchResults {
        position: absolute;
        z-index: 1000;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        background-color: white;
    }
    .list-group-item {
        cursor: pointer;
    }
    .list-group-item:hover {
        background-color: #f8f9fa; /* Highlight on hover */
    }

    /* Custom styles for the search input and dropdown */
    .input-group {
        position: relative;
    }
    #employeeSearch {
        border-radius: 0.25rem 0 0 0.25rem; /* Rounded corners */
    }
    .input-group-append .input-group-text {
        border-radius: 0 0.25rem 0.25rem 0; /* Rounded corners */
        cursor: pointer; /* Pointer cursor for dropdown */
    }
    #searchResults {
        position: absolute;
        z-index: 1000;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for dropdown */
    }
    .list-group-item {
        cursor: pointer;
    }
    .list-group-item:hover {
        background-color: #f8f9fa; /* Highlight on hover */
    }
    .list-group-item:focus {
        outline: none; /* Remove outline on focus */
        background-color: #e9ecef; /* Light background on focus */
    }
    .no-results {
        padding: 10px;
        text-align: center;
        color: #6c757d; /* Bootstrap muted color */
    }
</style>

<div class="col-12 mt-3 mb-3">
    <div class="card">
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="schedulingTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="calendar-tab" data-toggle="tab" href="#calendarView" role="tab" aria-controls="calendarView" aria-selected="true">Calendar View</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="table-tab" data-toggle="tab" href="#tableView" role="tab" aria-controls="tableView" aria-selected="false">Schedule List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="past-schedule-tab" data-toggle="tab" href="#pastScheduleView" role="tab" aria-controls="pastScheduleView" aria-selected="false">Past Schedule</a>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content" id="schedulingTabContent">
                <!-- Calendar View Tab -->
                <div class="tab-pane fade show active" id="calendarView" role="tabpanel" aria-labelledby="calendar-tab">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="assign-button-container">
                                <button type="button" id="openModalButton" class="btn btn-primary" disabled>Assign Employee</button>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Employee Schedule Calendar</h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="calendar"></div>
                                            <div id="full-name-display"></div>
                                        </div>
                                    </div>

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
                                                    <form method="POST" action="scheduling.php" id="scheduleForm" novalidate>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="selectedStartDate">Start Date:</label>
                                                                <input type="date" id="selectedStartDate" name="start_date" class="form-control" required>
                                                                <div class="invalid-feedback">Start date is required.</div>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="selectedEndDate">End Date:</label>
                                                                <input type="date" id="selectedEndDate" name="end_date" class="form-control" required>
                                                                <div class="invalid-feedback">End date is required.</div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="employeeName">Employee Name:</label>
                                                            <div class="input-group">
                                                                <input type="text" id="employeeSearch" class="form-control" placeholder="Search Employee" onkeyup="filterEmployees()" onfocus="showSuggestions()" aria-label="Search Employee" autocomplete="off">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="dropdownMenuButton" onclick="toggleDropdown()">
                                                                        <i class="fas fa-chevron-down"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div id="searchResults" class="list-group mt-2" style="display: none;"></div>
                                                            <input type="hidden" id="employeeName" name="employee_name" required>
                                                            <div class="invalid-feedback" id="employeeError" style="display: none;">Please input a valid employee name.</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="intime">In Time:</label>
                                                            <div class="input-group">
                                                                <select id="intime" name="intime" class="form-control" required>
                                                                    <option value="">Select In Time</option>
                                                                    <option value="06:00">6:00 AM</option>
                                                                    <option value="07:00">7:00 AM</option>
                                                                    <option value="08:00">8:00 AM</option>
                                                                    <option value="custom">Custom Time</option>
                                                                </select>
                                                                <input type="time" id="customIntime" name="custom_intime" class="form-control mt-2" style="display:none;" placeholder="Custom In Time">
                                                            </div>
                                                            <div class="invalid-feedback">In time is required.</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="outtime">Out Time:</label>
                                                            <div class="input-group">
                                                                <select id="outtime" name="outtime" class="form-control" required>
                                                                    <option value="">Select Out Time</option>
                                                                    <option value="17:00">5:00 PM</option>
                                                                    <option value="custom">Custom Time</option>
                                                                </select>
                                                                <input type="time" id="customOuttime" name="custom_outtime" class="form-control mt-2" style="display:none;" placeholder="Custom Out Time">
                                                            </div>
                                                            <div class="invalid-feedback">Out time is required.</div>
                                                        </div>
                                                        <div class="invalid-feedback" id="startDateError" style="display: none;">Start date is required.</div>
                                                        <div class="invalid-feedback" id="endDateError" style="display: none;">End date is required.</div>
                                                        <div class="invalid-feedback" id="intimeError" style="display: none;">In time is required.</div>
                                                        <div class="invalid-feedback" id="outtimeError" style="display: none;">Out time is required.</div>
                                                        <button type="submit" class="btn btn-primary btn-block">Save</button>
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

                <!-- Table View Tab -->
                <div class="tab-pane fade" id="tableView" role="tabpanel" aria-labelledby="table-tab">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card-header">
                                <h5 class="card-title">Upcoming Employee Schedules</h5>
                            </div>
                            <table class="table table-striped table-custom table-hover">
                                <thead class="text-uppercase table-bg-default text-white">
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Employee Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                try {
                                    // Get scheduling data for upcoming schedules only
                                    $sql = "SELECT s.id, s.*, a.fullname 
                                           FROM scheduling s
                                           INNER JOIN tbl_admin a ON s.fullname = a.fullname
                                           WHERE s.start_date >= CURDATE()  /* Only upcoming schedules */
                                           ORDER BY s.start_date ASC"; // Order by start date ascending
                                    
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();
                                    
                                    $counter = 1;
                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td>" . $counter . "</td>";
                                        echo "<td>" . $row['fullname'] . "</td>";
                                        echo "<td>" . date('M d, Y', strtotime($row['start_date'])) . "</td>";
                                        echo "<td>" . date('M d, Y', strtotime($row['end_date'])) . "</td>";
                                        echo "<td>
                                                <button class='btn btn-primary btn-sm' 
                                                        data-toggle='modal' 
                                                        data-target='#editModal' 
                                                        data-id='" . $row['id'] . "' 
                                                        data-fullname='" . htmlspecialchars($row['fullname'], ENT_QUOTES) . "' 
                                                        data-startdate='" . $row['start_date'] . "' 
                                                        data-enddate='" . $row['end_date'] . "' 
                                                        data-intime='" . $row['intime'] . "' 
                                                        data-outtime='" . $row['outtime'] . "'>Edit</button>
                                                <button class='btn btn-danger btn-sm' 
                                                        data-toggle='modal' 
                                                        data-target='#deleteModal' 
                                                        data-id='" . $row['id'] . "' 
                                                        data-fullname='" . htmlspecialchars($row['fullname'], ENT_QUOTES) . "'>Delete</button>
                                             </td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                } catch(PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Past Schedule Tab -->
                <div class="tab-pane fade" id="pastScheduleView" role="tabpanel" aria-labelledby="past-schedule-tab">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card-header">
                                <h5 class="card-title">Past Employee Schedules</h5>
                            </div>
                            <table class="table table-condensed table-custom table-hover">
                                <thead class="text-uppercase table-bg-default text-white">
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Employee Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $counter = 1;
                                foreach ($pastScheduleLogs as $log) {
                                    echo "<tr>";
                                    echo "<td>" . $counter . "</td>";
                                    echo "<td>" . htmlspecialchars($log['fullname'], ENT_QUOTES) . "</td>";
                                    echo "<td>" . date('M d, Y', strtotime($log['start_date'])) . "</td>";
                                    echo "<td>" . date('M d, Y', strtotime($log['end_date'])) . "</td>";
                                    echo "<td>
                                            <button class='btn btn-danger btn-sm' 
                                                    data-toggle='modal' 
                                                    data-target='#deleteModal' 
                                                    data-id='" . $log['id'] . "' 
                                                    data-fullname='" . htmlspecialchars($log['fullname'], ENT_QUOTES) . "'>Delete</button>
                                         </td>";
                                    echo "</tr>";
                                    $counter++;
                                }
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

<?php
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
    var fullNameDisplay = document.getElementById('full-name-display');
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

        select: function(info) {
            selectedRange.start = info.startStr;  // Store the start date
            selectedRange.end = info.endStr;      // Store the end date
            openModalButton.disabled = false;     // Enable the "Assign Employee" button

            // Adjust the end date to be the day before the selected end date
            selectedRange.end = new Date(info.endStr);
            selectedRange.end.setDate(selectedRange.end.getDate() - 1); // Subtract one day
            selectedRange.end = selectedRange.end.toISOString().split('T')[0]; // Format to YYYY-MM-DD
        },

        // Custom event content for initials
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
            // Show full name display
            fullNameDisplay.style.display = 'block';
            fullNameDisplay.innerText = info.event.extendedProps.fullName;

            // Get the position of the event element (the initials div)
            var eventRect = info.el.getBoundingClientRect();
            
            // Adjust positioning to be centered above the initials
            fullNameDisplay.style.left = (eventRect.left + window.scrollX - 225) + 'px'; 
            fullNameDisplay.style.top = (eventRect.top + window.scrollY - fullNameDisplay.offsetHeight - 280) + 'px';  // Adjusted to 5px above the initials
        },

        eventMouseLeave: function(info) {
            // Hide the full name display when the mouse leaves
            fullNameDisplay.style.display = 'none';
        }
    });

    calendar.render();

    openModalButton.addEventListener('click', function() {
        if (selectedRange.start && selectedRange.end) {
            // Check if the selected dates are in the past
            var startDate = new Date(selectedRange.start);
            var endDate = new Date(selectedRange.end);
            var today = new Date();
            today.setHours(0, 0, 0, 0); // Set time to midnight for comparison

            if (startDate < today || endDate < today) {
                alert("The selected dates cannot be in the past. Please select valid dates.");
                return; // Exit the function if dates are in the past
            }

            document.getElementById('selectedStartDate').value = selectedRange.start;
            document.getElementById('selectedEndDate').value = selectedRange.end;
            var modalElement = document.getElementById('timeModal');
            var modal = new bootstrap.Modal(modalElement);
            modal.show();
        }
    });

    var form = document.getElementById('scheduleForm');

    form.addEventListener('submit', function(event) {
        var selectedEmployee = document.getElementById('employeeName').value;
        var employeeNames = <?php echo json_encode($employeeNames); ?>; // Fetch employee names from PHP
        var startDate = document.getElementById('selectedStartDate').value;
        var endDate = document.getElementById('selectedEndDate').value;
        var intime = document.getElementById('intime').value;
        var outtime = document.getElementById('outtime').value;
        var isValid = true; // Flag to track overall validity

        // Reset error messages
        document.getElementById('employeeError').style.display = 'none';
        document.getElementById('startDateError').style.display = 'none';
        document.getElementById('endDateError').style.display = 'none';
        document.getElementById('intimeError').style.display = 'none';
        document.getElementById('outtimeError').style.display = 'none';

        // Validate employee name
        if (!employeeNames.includes(selectedEmployee)) {
            event.preventDefault(); // Prevent form submission
            document.getElementById('employeeError').style.display = 'block'; // Show error message
            isValid = false;
        }

        // Validate start date
        if (!startDate) {
            event.preventDefault();
            document.getElementById('startDateError').style.display = 'block'; // Show error message
            isValid = false;
        }

        // Validate end date
        if (!endDate) {
            event.preventDefault();
            document.getElementById('endDateError').style.display = 'block'; // Show error message
            isValid = false;
        }

        // Validate in time
        if (!intime) {
            event.preventDefault();
            document.getElementById('intimeError').style.display = 'block'; // Show error message
            isValid = false;
        }

        // Validate out time
        if (!outtime) {
            event.preventDefault();
            document.getElementById('outtimeError').style.display = 'block'; // Show error message
            isValid = false;
        }

        // Additional validation for date range
        if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
            event.preventDefault();
            alert("Start date must be before or equal to end date.");
            isValid = false;
        }

        // If all validations pass, proceed with form submission
        if (isValid) {
            document.getElementById('employeeError').style.display = 'none'; // Hide error message
        }
    });

    // Show custom time input when "Custom Time" is selected
    document.querySelectorAll('select[name="intime"], select[name="outtime"]').forEach(function(select) {
        select.addEventListener('change', function() {
            const customInput = this.id === 'intime' ? document.getElementById('customIntime') : document.getElementById('customOuttime');
            if (this.value === 'custom') {
                customInput.style.display = 'block';
                customInput.required = true; // Make custom input required
                customInput.classList.add('mt-1'); // Add margin-top for spacing
            } else {
                customInput.style.display = 'none';
                customInput.required = false; // Remove required if not using custom
            }
        });
    });
});
</script>

<!-- Modal for editing schedule -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="scheduling.php">
                    <input type="hidden" id="editScheduleId" name="schedule_id">
                    <div class="form-group">
                        <label for="editStartDate">Start Date:</label>
                        <input type="text" id="editStartDate" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editEndDate">End Date:</label>
                        <input type="text" id="editEndDate" name="end_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmployeeName">Employee Name:</label>
                        <input type="text" id="editEmployeeName" name="employee_name" class="form-control" value="<?php echo htmlspecialchars($fullName, ENT_QUOTES); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="editIntime">In Time:</label>
                        <input type="time" id="editIntime" name="intime" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editOuttime">Out Time:</label>
                        <input type="time" id="editOuttime" name="outtime" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to handle the edit button click -->
<script>
    $(document).on('click', '.btn.btn-primary.btn-sm', function() {
        var scheduleId = $(this).data('id');
        var fullName = $(this).data('fullname');
        var startDate = $(this).data('startdate');
        var endDate = $(this).data('enddate');
        var intime = $(this).data('intime');
        var outtime = $(this).data('outtime');

        // Set the values in the modal
        $('#editScheduleId').val(scheduleId);
        $('#editStartDate').val(startDate); // Set existing start date
        $('#editEndDate').val(endDate); // Set existing end date
        $('#editIntime').val(intime); // Set existing in time
        $('#editOuttime').val(outtime); // Set existing out time

        // Set the employee name in the dropdown
        $('#editEmployeeName').val(fullName); // Set existing employee name
    });
</script>

<!-- Modal for confirming deletion -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="deleteEmployeeName"></strong>?
            </div>
            <div class="modal-footer">
                <form method="POST" action="scheduling.php">
                    <input type="hidden" id="deleteScheduleId" name="schedule_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to handle the delete button click -->
<script>
    $(document).on('click', '.btn.btn-danger.btn-sm', function() {
        var scheduleId = $(this).data('id');
        var fullName = $(this).data('fullname');

        // Set the values in the modal
        $('#deleteScheduleId').val(scheduleId);
        $('#deleteEmployeeName').text(fullName); // Display the employee name in the modal
    });
</script>

<?php
// Handle deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['schedule_id'])) {
    $schedule_id = $_POST['schedule_id'];

    // Check if schedule_id is not empty or null before proceeding
    if (!empty($schedule_id) && is_numeric($schedule_id)) {
        // Change the query to delete all rows in the scheduling table
        $query = "DELETE FROM scheduling"; // Delete all rows
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        // Log the action
        error_log("Deleted all schedules from the table.");
    } else {
        error_log("Attempted to delete with an invalid schedule_id: " . var_export($schedule_id, true));
    }

    // Redirect to the same page to refresh the schedule list
    header('Location: ../Manage-Attendance/scheduling.php');
    exit();
}
?>

<script>
function filterEmployees() {
    var input, filter, searchResults, options, i, txtValue;
    input = document.getElementById('employeeSearch');
    filter = input.value.toLowerCase();
    searchResults = document.getElementById('searchResults');
    searchResults.innerHTML = ''; // Clear previous results

    // Show results based on input
    var hasResults = false; // Flag to check if there are results
    <?php foreach ($employeeNames as $name): ?>
        if ('<?php echo htmlspecialchars($name, ENT_QUOTES); ?>'.toLowerCase().indexOf(filter) > -1) {
            hasResults = true; // Set flag to true if a match is found
            var resultItem = document.createElement('a');
            resultItem.className = 'list-group-item list-group-item-action employee-option';
            resultItem.textContent = '<?php echo htmlspecialchars($name, ENT_QUOTES); ?>';
            resultItem.onclick = function() {
                selectEmployee(this.textContent); // Set input value to clicked item
            };
            searchResults.appendChild(resultItem);
        }
    <?php endforeach; ?>

    // If no results found, show a message
    if (!hasResults && filter) {
        var noResultItem = document.createElement('div');
        noResultItem.className = 'no-results';
        noResultItem.textContent = 'No matching employee names found.';
        searchResults.appendChild(noResultItem);
        input.placeholder = 'Invalid name'; // Set placeholder to indicate invalid name
    } else {
        input.placeholder = 'Search Employee'; // Reset placeholder if there are results
    }

    searchResults.style.display = searchResults.innerHTML ? 'block' : 'none'; // Show or hide results based on input
}

function showSuggestions() {
    var searchResults = document.getElementById('searchResults');
    searchResults.innerHTML = ''; // Clear previous results
    var hasResults = false; // Flag to check if there are results
    <?php foreach ($employeeNames as $name): ?>
        hasResults = true; // Set flag to true if there are names
        var resultItem = document.createElement('a');
        resultItem.className = 'list-group-item list-group-item-action employee-option';
        resultItem.textContent = '<?php echo htmlspecialchars($name, ENT_QUOTES); ?>';
        resultItem.onclick = function() {
            selectEmployee(this.textContent); // Set input value to clicked item
        };
        searchResults.appendChild(resultItem);
    <?php endforeach; ?>

    searchResults.style.display = hasResults ? 'block' : 'none'; // Show all names if available
}

function selectEmployee(name) {
    document.getElementById('employeeSearch').value = name; // Set input value to selected name
    document.getElementById('employeeName').value = name; // Set hidden input value
    document.getElementById('searchResults').style.display = 'none'; // Hide results
    document.getElementById('employeeError').style.display = 'none'; // Hide error message
}

// Hide dropdown when clicking outside
document.addEventListener('click', function(event) {
    var searchResults = document.getElementById('searchResults');
    if (!event.target.closest('.input-group') && !event.target.closest('#searchResults')) {
        searchResults.style.display = 'none';
    }
});
</script>
