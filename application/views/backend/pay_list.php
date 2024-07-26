<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Gehaltsabrechnung</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Startseite</a></li>
                <li class="breadcrumb-item active"><i class="fa fa-university" aria-hidden="true"></i> Gehaltsabrechnung</li>
            </ol>
        </div>
    </div>
    
    <div class="container-fluid"> 
        <div class="row m-b-10"> 
            <div class="col-12">
                <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Payroll/Generate_salary" class="text-white"><i class="" aria-hidden="true"></i> Gehalt generieren</a></button>
            </div>
        </div> 
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Gehaltsliste                     
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <select class="form-control custom-select" data-placeholder="Wählen Sie eine Abteilung" tabindex="1" id="depid" name="depid" style="margin-top: 21px;" required>
                                <option value="#">Abteilung auswählen</option>
                                <?php foreach ($department as $value): ?>
                                <option value="<?php echo $value->id; ?>">
                                    <?php echo $value->dep_name; ?>
                                </option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <select class="form-control custom-select" data-placeholder="Wählen Sie einen Mitarbeiter" tabindex="1" id="empid" name="empid" style="margin-top: 21px;" required>
                                <option value="#">Mitarbeiter auswählen</option>
                                <?php foreach ($employee as $value): ?>
                                    <option value="<?php echo $value->em_code; ?>"><?php echo $value->first_name.' '.$value->last_name; ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label></label>
                                <div class='input-group date' id='monthPicker'>
                                    <input type='text' name="datetime" class="form-control mydatetimepicker" placeholder="Monat"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div> 
                        </div>
                        <div class="table-responsive">       
                            <table id="attendanceTable" class="display nowrap table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Datum</th>
                                        <th>Tag</th>
                                        <th>Art</th>
                                        <th>Einloggen</th>
                                        <th>Ausloggen</th>
                                        <th>Pause</th>
                                        <th>Arbeitszeit</th>
                                        <th>Normale Stunden</th>
                                        <th>Überstunden</th>
                                        <th>ÜStd a 45 p. Woche</th>
                                        <th>Nachtstunden</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Daten werden hier per AJAX eingefügt -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        
    <script type="text/javascript">
$(document).ready(function() {

    $('#depid').on('change', function() {
        var depid = $(this).val();
        
        if (depid) {
            $.ajax({
                url: '<?php echo base_url(); ?>employee/emplbyDep',
                type: 'GET',
                data: { depid: depid },
                success: function(response) {
                    var data = JSON.parse(response);
                    $('#empid').empty();
                    $('#empid').append('<option value="#">Mitarbeiter auswählen</option>');
                    $.each(data.employee, function(key, value) {
                        $('#empid').append('<option value="' + value.em_code + '">' + value.first_name + ' ' + value.last_name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        } else {
            $('#empid').empty();
            $('#empid').append('<option value="#">Mitarbeiter auswählen</option>');
        }
    });

    $('.mydatetimepicker').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true
    }).on('changeDate', function(e) {
        var selectedMonth = e.format('mm');
        fetchAttendanceData(selectedMonth);
    });

    function fetchAttendanceData(month) {
        var emid = $('#empid').val();
        $.ajax({
            url: '<?php echo base_url(); ?>attendance/AttendancebyMonth', 
            type: 'GET',
            data: { month: month, employee_id: emid },
            success: function(response) {

                var data = JSON.parse(response).attendancelist;
                var tableBody = $('#attendanceTable tbody');
                tableBody.empty(); // Clear the table body

                var weeklyHours = 0;
                var weekStart = moment(data[0].atten_date).startOf('isoWeek');
                var weekEnd = moment(data[0].atten_date).endOf('isoWeek');

                $.each(data, function(index, attendance) {
                    var date = moment(attendance.atten_date);
                    var dayOfWeek = date.format('dddd');
                    var workHours = parseFloat(attendance.Hours);
                    var nightHours = 0;
                    var overtime = Math.max(0, workHours - 7.6);

                    // Check if signout time falls in the night hours (22:00 to 06:00)
                    var signoutTime = moment(attendance.signout_time, "HH:mm");
                    if (signoutTime.hour() >= 22 || signoutTime.hour() < 6) {
                        nightHours = Math.min(workHours, (signoutTime.hour() < 6 ? signoutTime.hour() + 24 : signoutTime.hour()) - 22);
                    }

                    // Check if we are still in the same week
                    if (date.isBetween(weekStart, weekEnd, null, '[]')) {
                        weeklyHours += workHours;
                    } else {
                        // If we have moved to a new week, reset weekly hours and week range
                        weekStart = date.startOf('isoWeek');
                        weekEnd = date.endOf('isoWeek');
                        weeklyHours = workHours;
                    }

                    var weeklyOvertime = weeklyHours > 45 ? (weeklyHours - 45) : 0;
                    weeklyOvertime = weeklyOvertime > 0 ? weeklyOvertime.toFixed(2) : '';
                    var breakTime = 0;
                    var row = '<tr>' +
                        '<td>' + attendance.atten_date + '</td>' +
                        '<td>' + dayOfWeek + '</td>' +
                        '<td>' + 'Type' + '</td>' +
                        '<td>' + attendance.signin_time + '</td>' +
                        '<td>' + attendance.signout_time + '</td>' +
                        '<td>' + breakTime.toFixed(2) + '</td>' +
                        '<td>' + workHours.toFixed(2) + '</td>' +
                        '<td>7.6</td>' +
                        '<td>' + overtime.toFixed(2) + '</td>' +
                        '<td>' + weeklyOvertime + '</td>' +
                        '<td>' + nightHours.toFixed(2) + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
                // Calculate sums for each column
                var totalWorkHours = 0;
                    var totalOvertime = 0;
                    var totalWeeklyOvertime = 0;
                    var totalNightHours = 0;

                    data.forEach(function(attendance) {
                        totalWorkHours += parseFloat(attendance.Hours);
                        var overtime = Math.max(0, parseFloat(attendance.Hours) - 7.6);
                        totalOvertime += overtime;
                        if (parseFloat(attendance.Hours) > 45) {
                            totalWeeklyOvertime += parseFloat(attendance.Hours) - 45;
                        }
                        var signoutTime = moment(attendance.signout_time, "HH:mm");
                        if (signoutTime.hour() >= 22 || signoutTime.hour() < 6) {
                            totalNightHours += Math.min(parseFloat(attendance.Hours), (signoutTime.hour() < 6 ? signoutTime.hour() + 24 : signoutTime.hour()) - 22);
                        }
                    });
                // Append the totals row at the end of the table
                var totalsRow = '<tr>' +
                    '<td colspan="6"><strong>Total</strong></td>' +
                    '<td><strong>' + totalWorkHours.toFixed(2) + '</strong></td>' +
                    '<td><strong>7.6</strong></td>' +
                    '<td><strong>' + totalOvertime.toFixed(2) + '</strong></td>' +
                    '<td><strong>' + totalWeeklyOvertime.toFixed(2) + '</strong></td>' +
                    '<td><strong>' + totalNightHours.toFixed(2) + '</strong></td>' +
                    '</tr>';
                tableBody.append(totalsRow);
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    }
});

</script>

<?php $this->load->view('backend/footer'); ?>