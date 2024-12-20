

<!-- footer area start-->
</div>
<footer>
            <div class="footer-area">
                <p>
                Copyright © 2023 Aeternitas</p>
            </div>
        </footer>
        <!-- footer area end-->
    <!-- JQuery and Bootstrap -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Bootstrap, Owl Carousel, SlickNav, and MetisMenu -->
<script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/owl.carousel.min.js"></script>
<script src="../assets/js/metisMenu.min.js"></script>
<script src="../assets/js/jquery.slimscroll.min.js"></script>
<script src="../assets/js/jquery.slicknav.min.js"></script>

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/main.min.js'></script>

<!-- Highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<!-- Amcharts -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/ammap.js"></script>
<script src="https://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

<!-- Custom JS -->
<script src="../assets/js/line-chart.js"></script>
<script src="../assets/js/pie-chart.js"></script>
<script src="../assets/js/bar-chart.js"></script>
<script src="../assets/js/maps.js"></script>
<script src="../assets/js/plugins.js"></script>
<script src="../assets/js/scripts.js"></script>
<script src="..assets/js/popper.min.js"></script>

<!-- Datepicker JS -->
<script src="../etms/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../etms/assets/bootstrap-datepicker/js/datepicker-custom.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>



    <script>
        $(document).ready(function() {
        // Edit button click handler
        $('.edit-btn').click(function(e) {
            e.preventDefault();

            // Get data attributes from the edit button
            var empId = $(this).closest('tr').find('td:eq(0)').text().trim();
            var fullName = $(this).data('name');
            var position = $(this).data('position');
            var group = $(this).closest('tr').find('td:eq(3)').text().trim(); // Assuming Group is in the 4th column
            var username = $(this).data('username');
            var age = $(this).data('age');
            var startDate = $(this).data('start-date');
            var phone = $(this).closest('tr').find('td:eq(7)').text().trim(); // Assuming Phone is in the 8th column

            // Populate form fields with fetched data
            $('#validationCustom04').val(empId);
            $('#validationCustom01').val(fullName.split(' ')[0]);
            $('#validationCustom02').val(fullName.split(' ')[1]);
            $('#validationCustomUsername').val(username);
            $('#example-number-input').val(age);
            $('#validationCustom05').val(startDate);
            $('#validationCustom03').val(""); // Reset password field
            $('#validationCustom06').val(position);
            $('#validationCustom07').val(group);
            $('#validationCustom08').val(phone);

            // Focus on the first name field after populating
            $('#validationCustom01').focus();

            // Prepare the HTML content to display in the <div>
            var divContent = '<p class="text-xl font-serif font-semibold text-[#434955]">' + fullName + '</p>';
            // divContent += '<p>Emp ID: ' + empId + '<br>';
            divContent += '<p class="text-sm font-semibold text-[#434955]">' + position + '</p>';
            var divContent = '<p>+' + phone + '</p>';
            divContent += 'username: ' + username + '<br>';
            divContent += 'Date Hire: ' + startDate + '<br>';
            // divContent += 'Age: ' + age + '<br>';
            divContent += 'Group: ' + group + '</p>';

            // Update the content of the <div> with the prepared HTML
            $('.f-name').html(divContent);
            
            // Optionally, you can show/hide or animate the <div> to make it visible
            
            $('.f-name').slideDown(); // Example: Use a slide-down animation to reveal the updated content
            
        });

            // Delete button click handler
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var fullName = $(this).data('name');

                // Send an AJAX request to delete the record
                $.ajax({
                    method: 'POST',
                    url: 'delete_employee.php', // Create a new PHP file to handle deletion
                    data: { fullName: fullName },
                    success: function(response) {
                        if (response === 'success') {
                            alert('Employee record deleted successfully!');
                            window.location.reload(); // Refresh the page
                        } else {
                            alert('Error deleting employee record.');
                        }
                    },
                    error: function() {
                        alert('Error deleting employee record.');
                    }
                });
            });
        });



        $(document).ready(function() {
    // Suppress DataTables warnings
    $.fn.dataTable.ext.errMode = 'none';

    var tableIds = ['#dataTable3'];
    tableIds.forEach(function(id) {
        $(id).DataTable({
            // Your DataTables options here,
            initComplete: function(settings, json) {
                var api = this.api();
                if (api.page.info().recordsTotal === 0 && settings.jqXHR.responseJSON.error) {
                    // If there are no records and there is an error, hide the warning message
                    $('.dataTables_empty').hide();
                }
            }
        });
    });
});


$(document).ready(function() {
    // Suppress DataTables warnings
    $.fn.dataTable.ext.errMode = 'none';

    var tableIds = ['#attendance-report'];
    tableIds.forEach(function(id) {
        $(id).DataTable({
            // Your DataTables options here,
            searching: false,
            initComplete: function(settings, json) {
                var api = this.api();
                if (api.page.info().recordsTotal === 0 && settings.jqXHR.responseJSON.error) {
                    // If there are no records and there is an error, hide the warning message
                    $('.dataTables_empty').hide();
                }
            }
        });
    });
});


$(document).ready(function() {
    // Suppress DataTables warnings
    $.fn.dataTable.ext.errMode = 'none';

    var groups = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];
    groups.forEach(function(group) {
        $('#group-' + group).DataTable({
            // Your DataTables options here,
            initComplete: function(settings, json) {
                var api = this.api();
                if (api.page.info().recordsTotal === 0 && settings.jqXHR.responseJSON.error) {
                    // If there are no records and there is an error, hide the warning message
                    $('.dataTables_empty').hide();
                }
            }
        });
    });
});


    </script>
    </body>
</html>
