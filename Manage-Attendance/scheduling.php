<?php
$page_name = "Scheduling";
include('../nav-and-footer/header-nav.php');
?>

<!-- jQuery (required for Bootstrap and FullCalendar) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (required for Bootstrap dropdowns) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

<!-- Bootstrap JS (required for modal functionality) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>

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
                                        <form>
                                          <div class="form-group">
                                            <label for="selectedStartDate">Start Date:</label>
                                            <input type="text" id="selectedStartDate" class="form-control" disabled>
                                          </div>
                                          <div class="form-group">
                                            <label for="selectedEndDate">End Date:</label>
                                            <input type="text" id="selectedEndDate" class="form-control" disabled>
                                          </div>
                                          <div class="form-group">
                                            <label for="employeeName">Employee Name:</label>
                                            <input type="text" id="employeeName" class="form-control" placeholder="Enter employee name">
                                          </div>
                                          <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var calendarEl = document.getElementById('calendar');
                                        var selectedRange = {}; // Store selected start and end dates
                                        var openModalButton = document.getElementById('openModalButton'); // Button to open modal

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
                                            initialDate: new Date(), // Ensure the calendar shows the current date
                                            nowIndicator: true,

                                            // Allow selection of multiple dates
                                            select: function(info) {
                                                // Store the selected start and end dates
                                                selectedRange = {
                                                    start: info.startStr,
                                                    end: info.endStr
                                                };

                                                // Enable the button when a date range is selected
                                                openModalButton.disabled = false;
                                            }
                                        });

                                        calendar.render();

                                        // Open modal when button is clicked
                                        openModalButton.addEventListener('click', function() {
                                            if (selectedRange.start && selectedRange.end) {
                                                // Show the selected start and end dates in the modal
                                                document.getElementById('selectedStartDate').value = selectedRange.start;
                                                document.getElementById('selectedEndDate').value = selectedRange.end;

                                                // Show the modal
                                                $('#timeModal').modal('show');
                                            }
                                        });
                                    });
                                </script>

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