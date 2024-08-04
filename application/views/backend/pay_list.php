<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<style>
    .display-6 {
    font-size: 1.25rem;

}
.display-4 {
    font-size: 2rem;
    font-weight: 700;
}

.display-8 {
    font-size: 1.25rem;
    font-weight: 700;
}
</style>
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
                <div class="card card-outline-info" >
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
                                        <th>Nachtstunden</th>
                                        <th>Verpflegung - full</th>
                                        <th>Verpflegung - less</th>
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
        <div class="container-fluid">
    <div class="row">
        <!-- First Card: Gehaltsabrechnung Zusammenfassung -->
        <div class="col-md-3">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-calculator" aria-hidden="true"></i> Gehaltsabrechnung Zusammenfassung</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Beschreibung</th>
                                <th>Wert</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Arbeitstage des Monats (ohne Sa-So):</strong></td>
                                <td id="totalWorkDays" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Gesamtarbeitsstunden im Monat:</strong></td>
                                <td id="totalWorkHours" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Mitarbeiterarbeitsstunden im Monat:</strong></td>
                                <td id="normalWorkHours" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Überstunden des Mitarbeiters im Monat:</strong></td>
                                <td id="totalOvertime" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Nachtstunden im Monat:</strong></td>
                                <td id="totalNightHours" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Verpflegung für volle Arbeitsstunden:</strong></td>
                                <td id="mealsFull" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Verpflegung für weniger als Arbeitsstunden:</strong></td>
                                <td id="mealsLess" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Bonus (pro Arbeitsstunde):</strong></td>
                                <td id="bonus" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Bonus 2:</strong></td>
                                <td id="bonus2" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Stundenlohn:</strong></td>
                                <td id="hourlyPay" class="display-8"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Second Card: Calculations -->
        <div class="col-md-6">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-calculator" aria-hidden="true"></i> Calculation Summary</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Value</th>
                                <th>Amount (€)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Gesamtarbeitsstunden im Monat:</strong></td>
                                <td id="totalWorkHours2" class="display-8"></td>
                                <td id="totalWorkHours_amt" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Verpflegung für volle Arbeitsstunden:</strong></td>
                                <td id="mealsFull2" class="display-8"></td>
                                <td id="mealsFull_amt" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Bonus (pro Arbeitsstunde):</strong></td>
                                <td id="bonus_1" class="display-8"></td>
                                <td id="bonus_amt" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Bonus 2:</strong></td>
                                <td id="bonus_2" class="display-8"></td>
                                <td id="bonus2_amt" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Abzüge:</strong></td>
                                <td><input type="text" id="deductions" class="form-control" placeholder="Abzüge eingeben"></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong class="display-4 text-success">Gesamtgehalt:</strong></td>
                                <td></td>
                                <td><div class="display-4 text-success" id="totalSalary"></div></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


    </div>
                        
<script type="text/javascript">
$(document).ready(function() {
    // Fetch holiday calendar and store it
var holidays = [];

$.ajax({
    url: '<?php echo base_url(); ?>leave/Holidays_for_calendar',
    method: 'GET',
    data: '',
    dataType: 'json',
}).done(function(response) {
    holidays = response;
    console.log(holidays);
});

function getHolidayType(date) {
    // Convert the date to YYYY-MM-DD format
    var formattedDate = date.toISOString().split('T')[0];
    
    // Check if the date is a weekend (Saturday or Sunday)
    var dayOfWeek = date.getDay(); // 0 = Sunday, 6 = Saturday
    if (dayOfWeek === 0 || dayOfWeek === 6) {
        return ''; // Return empty for weekends
    }
    
    // Find if the date matches any holiday
    var holiday = holidays.find(function(holiday) {
        return formattedDate >= holiday.from_date && formattedDate <= holiday.to_date;
    });
    
    // Return holiday name if found, otherwise "Arbeitszeit"
    return holiday ? holiday.holiday_name : 'Arbeitszeit';
}

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

            var totalWorkMinutes = 0;
            var totalMonthMinutes = 0;
            var totalOvertimeMinutes = 0;
            var totalWeeklyOvertimeMinutes = 0;
            var totalNightMinutes = 0;
            var weeklyHours = 0;
            var weekStart = moment(data[0].atten_date).startOf('isoWeek');
            var weekEnd = moment(data[0].atten_date).endOf('isoWeek');
            var totalMealsLess = 0; // Total count for meals with total time < work hours
            var totalMealsEqualOrMore = 0; // Total count for meals with total time >= work hours
            var hourly_salary = 0;
            var bonusPerHour = 0;
            var bonusPerHour2 = 0;
            $.each(data, function(index, attendance) {
                var date = moment(attendance.atten_date);
                var dayOfWeek = date.format('dddd');

                hourly_salary = attendance.total;
                bonusPerHour = attendance.hourly_bonus;
                bonusPerHour2 = attendance.hourly_bonus2;

                // Convert work hours and hours worked to minutes
                var workHours = parseInt(attendance.Hours.match(/(\d+) h/)[1]) * 60 + parseInt(attendance.Hours.match(/(\d+) m/)[1]);
                var [dh, dm] = attendance.work_hours.split(':').map(Number);
                var dayWorkMinutes = dh * 60 + dm;

                totalMonthMinutes += dayWorkMinutes;

                // Calculate overtime in minutes
                var overtimeMinutes = workHours - dayWorkMinutes;
                totalOvertimeMinutes += overtimeMinutes;
                var overtime = formatTime(Math.abs(overtimeMinutes));
                
                if (overtimeMinutes < 0) {
                    overtime = `<td style="color: red;">- ${overtime}</td>`;
                } else {
                    overtime = `<td>${overtime}</td>`;
                }

                // Calculate night hours (22:00 to 06:00)
                var signoutTime = moment(attendance.signout_time, "HH:mm");
                var signInTime = moment(attendance.signin_time, "HH:mm");
                var nightMinutes = 0;
                
                // Define boundaries for night hours
                const nightStart = moment('22:00', 'HH:mm'); // 10 PM
                const nightEnd = moment('06:00', 'HH:mm');   // 6 AM

                // Case 1: Add minutes from sign-in time if before 6 AM
                if (signInTime.isBefore(nightEnd)) {
                    if (signInTime.isBefore(nightStart)) {
                        // Sign-in time is before 10 PM
                        nightMinutes += nightEnd.diff(signInTime, 'minutes');;
                    } 
                }
                if (signoutTime.isAfter(nightStart)) {
                        // Sign-out time is after 10 PM
                        nightMinutes += signoutTime.diff(nightStart, 'minutes');
                } 

                totalNightMinutes += nightMinutes;

                // Check if we are still in the same week
                // Check if we are still in the same week
                if (!date.isBetween(weekStart, weekEnd, null, '[]')) {
                    // Calculate weekly overtime before resetting
                    if (weeklyHours > 45 * 60) {
                        totalWeeklyOvertimeMinutes += (weeklyHours - 45 * 60);
                    }
                    // Reset weekly hours and week range
                    weekStart = date.startOf('isoWeek');
                    weekEnd = date.endOf('isoWeek');
                    weeklyHours = 0;
                }

                weeklyHours += workHours;

                var weeklyOvertimeDisplay = weeklyHours > 45 * 60 ? formatTime(weeklyHours - 45 * 60) : '';
                
                totalWorkMinutes += workHours;


                // Determine daily meal based on total time vs work hours
                var mealLess = workHours < dayWorkMinutes ? 4.09 : "";
                var mealEqualOrMore = workHours >= dayWorkMinutes ? 4.09 : "";

                // Update totals
                totalMealsLess += mealLess !== "" ? parseFloat(mealLess) : 0;
                totalMealsEqualOrMore += mealEqualOrMore !== "" ? parseFloat(mealEqualOrMore) : 0;

                var row = '<tr>' +
                    '<td>' + attendance.atten_date + '</td>' +
                    '<td>' + dayOfWeek + '</td>' +
                    '<td>' + getHolidayType(new Date(attendance.atten_date)) + '</td>' +
                    '<td>' + attendance.signin_time + '</td>' +
                    '<td>' + attendance.signout_time + '</td>' +
                    '<td>' + attendance.break + '</td>' +
                    '<td>' + attendance.Hours + '</td>' +
                    '<td>' + attendance.work_hours + '</td>' +
                    overtime  +
                    '<td>' + formatTime(nightMinutes) + '</td>' +
                    '<td>' + mealLess + '</td>' +
                    '<td>' + mealEqualOrMore + '</td>' +
                    '</tr>';
                tableBody.append(row);
            });

            // Append the totals row at the end of the table
            var totalsRow = '<tr>' +
                '<td colspan="6"><strong>Total</strong></td>' +
                '<td><strong>' + formatTime(totalWorkMinutes) + '</strong></td>' +
                '<td><strong>' + formatTime(totalMonthMinutes) + '</strong></td>' +
                '<td><strong>' + formatTime(totalOvertimeMinutes) + '</strong></td>' +
                '<td><strong>' + formatTime(totalNightMinutes) + '</strong></td>' +
                '<td><strong>' + totalMealsLess.toFixed(2) + '</strong></td>' +
                '<td><strong>' + totalMealsEqualOrMore.toFixed(2) + '</strong></td>' +
                '</tr>';
            tableBody.append(totalsRow);



            // Calculate the total work days in the month excluding Sat-Sun
            var totalWorkDays = data.filter(function (attendance) {
                var dayOfWeek = moment(attendance.atten_date).day();
                return dayOfWeek !== 0 && dayOfWeek !== 6; // Exclude Sundays (0) and Saturdays (6)
            }).length;

                // Calculate the total work days in the month excluding Sat-Sun
                var totalWorkDays = data.filter(function (attendance) {
                    var dayOfWeek = moment(attendance.atten_date).day();
                    return dayOfWeek !== 0 && dayOfWeek !== 6; // Exclude Sundays (0) and Saturdays (6)
                }).length;

                // Convert minutes to hours
                var totalHours = totalWorkMinutes / 60;

                // Calculate total salary with floating-point precision
                var totalSalary = (totalHours * hourly_salary) +
                                (totalHours * bonusPerHour) +
                                (totalHours * bonusPerHour2) +
                                (totalMealsEqualOrMore + totalMealsLess);
                // Update the summary card values
                $('#totalWorkDays').text(totalWorkDays);
                $('#totalWorkHours').text(formatTime(totalWorkMinutes));$('#totalWorkHours2').text(hourly_salary +' x ' + formatTime(totalWorkMinutes));
                $('#totalWorkHours_amt').text(((totalWorkMinutes / 60) * hourly_salary).toFixed(2));
                $('#normalWorkHours').text(formatTime(totalMonthMinutes));
                $('#totalOvertime').text(formatTime(totalOvertimeMinutes));
                $('#totalNightHours').text(formatTime(totalNightMinutes));
                $('#mealsFull').text(totalMealsEqualOrMore.toFixed(2));
                $('#mealsFull2').text(totalMealsEqualOrMore.toFixed(2) + ' + ' + totalMealsLess.toFixed(2));
                $('#mealsFull_amt').text((totalMealsEqualOrMore + totalMealsLess).toFixed(2));
                $('#mealsLess').text(totalMealsLess.toFixed(2));
                $('#bonus').text(bonusPerHour + ' €/h');
                $('#bonus_1').text(bonusPerHour + '  x ' + formatTime(totalWorkMinutes));
                $('#bonus_2').text(bonusPerHour2 + '  x ' + formatTime(totalWorkMinutes));
                $('#bonus_amt').text(((totalWorkMinutes / 60) * bonusPerHour).toFixed(2));
                $('#bonus2_amt').text(((totalWorkMinutes / 60) * bonusPerHour2).toFixed(2));
                $('#bonus2').text(bonusPerHour2 + ' €/h');
                $('#hourlyPay').text(hourly_salary + ' €/h');
                $('#totalSalary').text(totalSalary.toFixed(2) + ' €');

                // Calculate total salary with deductions when deductions input changes
                $('#deductions').on('input', function () {
                    var deductions = parseFloat($(this).val()) || 0;
                    var finalSalary = totalSalary - deductions;
                    $('#totalSalary').text(finalSalary.toFixed(2) + ' €');
                });

        },
        error: function(xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
}
});
function formatTime(minutes) {
    let hours = Math.floor(minutes / 60);
    let mins = Math.round(minutes % 60);
    return `${hours} h ${mins} m`;
}



</script>

<?php $this->load->view('backend/footer'); ?>