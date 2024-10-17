<?php

$page_name = "Scheduling";
include('../nav-and-footer/header-nav.php');
?>

<style>
    #calendar {
    max-width: 100%;
    margin: 0 auto;
}
</style>
<div class="col-12 mt-3 mb-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well well-custom">
                                <!-- I want to put here the calendar that fit in the whole page but the day and year is accurate of what the day right now -->
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
                                            <label for="selectedDate">Selected Date:</label>
                                            <input type="text" id="selectedDate" class="form-control" disabled>
                                          </div>
                                          <div class="form-group">
                                            <label for="employeeName">Employee Name:</label>
                                            <input type="text" id="employeeName" class="form-control" placeholder="Enter employee name">
                                          </div>
                                          <div class="form-group">
                                            <label for="timeIn">Time In:</label>
                                            <input type="time" id="timeIn" class="form-control">
                                          </div>
                                          <div class="form-group">
                                            <label for="timeOut">Time Out:</label>
                                            <input type="time" id="timeOut" class="form-control">
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
                                        var calendar = new FullCalendar.Calendar(calendarEl, {
                                            initialView: 'dayGridMonth', // Shows the calendar in month view
                                            selectable: true, // Allows selecting dates
                                            dateClick: function(info) {
                                                // When a date is clicked, open the modal to assign time in/out
                                                $('#timeModal').modal('show');
                                                document.getElementById('selectedDate').value = info.dateStr;
                                            }
                                        });
                                        calendar.render();
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