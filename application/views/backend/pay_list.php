<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<style>
    .display-6 {
    font-size: 1.00rem;

}
.display-4 {
    font-size: 2rem;
    font-weight: 300;
}

.display-8 {
    font-size: 1.25rem;
    font-weight: 500;
}
.color-legend {
        margin-bottom: 10px;
    }

    .legend-item {
        display: inline-block;
        padding: 5px 10px;
        margin-right: 10px;
        color: black;
        font-size: 14px;
        border-radius: 5px;
    }
</style>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Gehaltsabrechnung</h3>
        </div>
        <div class="col-md-7 align-self-center no-print">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Startseite</a></li>
                <li class="breadcrumb-item active"><i class="fa fa-university" aria-hidden="true"></i> Gehaltsabrechnung</li>
            </ol>
        </div>
    </div>
    
    <div class="container-fluid "> 
        <div class="row m-b-10 no-print"> 
            <div class="col-12">
                <button type="button" class="btn btn-info" onclick="printPage()">Drucken</button>
            </div>
        </div> 
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info first-card" >
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Gehaltsliste                     
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row no-print">
                            <div class="form-group col-md-4 ">
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
                        <div class="color-legend">
                            <span class="legend-item" style="background-color: #ffcccb;">Work Day (No Work Hours)</span>
                            <span class="legend-item" style="background-color: #E5E4E2;">Weekend</span>
                            <span class="legend-item" style="background-color: #F0FFF0;">Holiday</span>
                            <span class="legend-item" style="background-color: #DCD0FF;">Leave</span>
                            <span class="legend-item" style="background-color: #FFF9E3;">Off Day</span>
                        </div>
                        <div class="table-responsive">       
                            <table id="attendanceTable" class="display nowrap table table-hover table-bordered">
                                <thead>
                                    <tr>
                                    <th># (Number)</th>
                                    <th>Datum (Date)</th>
                                    <th>Tag (Day)</th>
                                    <th>Art (Type)</th>
                                    <th>Einloggen (Log In)</th>
                                    <th>Ausloggen (Log Out)</th>
                                    <th>Pause (Break)</th>
                                    <th>Arbeitszeit (Working Time)</th>
                                    <th>Normale Stunden (Regular Hours)</th>
                                    <th>Überstunden (Overtime)</th>
                                    <th>Nachtstunden (Night Hours)</th>
                                    <th>Mahlzeit(f) (Meal Time - Full)</th>
                                    <th>Mahlzeit(l) (Meal Time - Light)</th>
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
        <div class="col-md-6">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-calculator" aria-hidden="true"></i> Gehaltsabrechnung Zusammenfassung</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th>Beschreibung</th>
                                <th>Wert</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Total working days (ohne Sa-So)  totalWorkingDays:</strong></td>
                                <td id="totalWorkingDays" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Days worked in month (ohne Sa-So)  totalWorkDays:</strong></td>
                                <td id="totalWorkDays" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Gesamtarbeitsstunden im Monat totalWorkHours:</strong></td>
                                <td id="totalWorkHours" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Mitarbeiterarbeitsstunden im Monat  normalWorkHours:</strong></td>
                                <td id="normalWorkHours" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Überstunden des Mitarbeiters im Monat totalOvertime:</strong></td>
                                <td id="totalOvertime" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Nachtstunden im Monat  totalNightHours:</strong></td>
                                <td id="totalNightHours" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Verpflegung für volle Arbeitsstunden  mealsFull:</strong></td>
                                <td id="mealsFull" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Verpflegung für weniger als Arbeitsstunden  mealsLess:</strong></td>
                                <td id="mealsLess" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Bonus (pro Arbeitsstunde)  bonus:</strong></td>
                                <td id="bonus" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Bonus 2  bonus2: </strong></td>
                                <td id="bonus2" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Stundenlohn  hourlyPay:</strong></td>
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
                    <table class="table table-bordered table-striped" style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Value</th>
                                <th>Amount (€)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Gesamtarbeitsstunden im Monat  totalWorkHours_amt:</strong></td>
                                <td id="totalWorkHours2" class="display-8"></td>
                                <td id="totalWorkHours_amt" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Verpflegung für volle Arbeitsstunden  mealsFull_amt:</strong></td>
                                <td id="mealsFull2" class="display-8"></td>
                                <td id="mealsFull_amt" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Bonus (pro Arbeitsstunde) bonus_amt:</strong></td>
                                <td id="bonus_1" class="display-8"></td>
                                <td id="bonus_amt" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Bonus 2:</strong></td>
                                <td id="bonus_2" class="display-8"></td>
                                <td id="bonus2_amt" class="display-8"></td>
                            </tr>
                            <tr>
                                <td><strong>Daily Bonus:</strong></td>
                                <td id="bonus_daily" class="display-8"></td>
                                <td id="bonusDaily_amt" class="display-8"></td>
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
                                <td colspan="2"><div class="display-4 text-success" id="totalSalary"></div></td>
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

function isHoliday(date) {
    // Convert the date to YYYY-MM-DD format
    var formattedDate = date.toISOString().split('T')[0];

    // Check if the date is a weekend (Saturday or Sunday)
    var dayOfWeek = date.getDay(); // 0 = Sunday, 6 = Saturday
    if (dayOfWeek === 0 || dayOfWeek === 6) {
        return false; // Return false for weekends
    }

    // Check if the date matches any holiday
    var holiday = holidays.find(function(holiday) {
        return formattedDate >= holiday.from_date && formattedDate <= holiday.to_date;
    });

    // Return true if it's a holiday, otherwise false
    return !!holiday; // Convert the holiday object to a boolean
}


function getHolidayType(date) {
    // Convert the date to YYYY-MM-DD format
    var formattedDate = date.toISOString().split('T')[0];
    
    // Check if the date is a weekend (Saturday or Sunday)
    var dayOfWeek = date.getDay(); // 0 = Sunday, 6 = Saturday
    if (dayOfWeek === 0 || dayOfWeek === 6) {
        return 'Ruhetage'; // Return empty for weekends
    }
    
    // Find if the date matches any holiday
    var holiday = holidays.find(function(holiday) {
        return formattedDate >= holiday.from_date && formattedDate <= holiday.to_date;
    });
    
    // Return holiday name if found, otherwise "Arbeitszeit"
    if(holiday)
        return holiday.holiday_name;
    return 'Arbeitszeit';
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
        var selectedMonth = e.format('yyyy-mm');
        fetchAttendanceData(selectedMonth);
    });

    var leaves = [];
    
    // Function to check if the date is a leave
    function isLeave(date) {
        // Convert the date to YYYY-MM-DD format
        var formattedDate = date.toISOString().split('T')[0];

        // Check if the date matches any holiday
        var holiday = leaves.find(function(holiday) {
            return formattedDate >= holiday.from_date && formattedDate <= holiday.to_date;
        });

        // Return true if it's a holiday, otherwise false
        return holiday || null; // Convert the holiday object to a boolean
    }


function fetchAttendanceData(month) {
    var emid = $('#empid').val();
    $.ajax({
        url: '<?php echo base_url(); ?>attendance/AttendancebyMonth', 
        type: 'GET',
        data: { month: month, employee_id: emid },
        success: function(response) {
            leaves = JSON.parse(response).leaves;
            var data = JSON.parse(response).attendancelist;
            if (Array.isArray(data) && data.length > 0) {
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
                var totalWorkDays = 0; 
                var totalWorkingDays = 0;
                var work_hours = 0;

                $.each(data, function(index, attendance) {
                    var date = moment(attendance.atten_date);
                    var dayOfWeek = date.day(); // This will give you a number (0-6)
                    const daysInGerman = ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"];
                    var dayShort = daysInGerman[dayOfWeek];
                    var overtimeMinutes = 0;
                    var overtime = formatTime(Math.abs(overtimeMinutes));
                    var rowBackgroundColor = 'style="background-color: #ffcccb;"';
                    var nightMinutes = 0;
                    var mealLess = "";
                    var mealEqualOrMore = "";

                    hourly_salary = attendance.total;
                    bonusPerHour = attendance.hourly_bonus;
                    bonusPerHour2 = attendance.hourly_bonus2;
                    daily_bonus = attendance.daily_bonus;

                    // Convert work hours and hours worked to minutes
                    var workHours = parseInt(attendance.Hours.match(/(\d+) h/)[1]) * 60 + parseInt(attendance.Hours.match(/(\d+) m/)[1]);
                    
                    var [dh, dm] = attendance.work_hours.split(':').map(Number);
                    var dayWorkMinutes = dh * 60 + dm;
                    

                    // Exclude Saturday and Sunday
                    var leave = isLeave(new Date(attendance.atten_date));
                    if ((dayOfWeek !== 6 && dayOfWeek !== 0) && !isHoliday(new Date(attendance.atten_date)) && !leave && !(attendance.off_day === String(dayOfWeek))) {
                        totalMonthMinutes += dayWorkMinutes;
                        work_hours = attendance.work_hours;
                        totalWorkingDays++;
                    } else {
                        if ((leave && leave.type == '1') || isHoliday(new Date(attendance.atten_date)))
                        {
                             work_hours = attendance.work_hours;
                             attendance.Hours = attendance.work_hours;
                             workHours = (attendance.work_hours.split(':')[0] * 60) + parseInt(attendance.work_hours.split(':')[1]);
                             totalMonthMinutes += workHours;
                             totalWorkingDays++;
                        } else {
                            work_hours = 0;
                            workHours = 0;
                        }
                        rowBackgroundColor = 'style="background-color: #E5E4E2;"';
                    }

                    // Calculate overtime in minutes
                    if(workHours > 0)
                    {
                        overtimeMinutes = workHours - dayWorkMinutes;
                        if(overtimeMinutes > 0)
                            totalOvertimeMinutes += overtimeMinutes;
                    
                        overtime = formatTime(Math.abs(overtimeMinutes));

                        if (overtimeMinutes < 0) {
                            overtime = `<td style="color: red;">- ${overtime}  </td>`;
                        } else {
                            overtime = `<td>${overtime}</td>`;
                        }

                        // Calculate night hours (22:00 to 06:00)
                        var signoutTime = moment(attendance.signout_time, "HH:mm");
                        var signInTime = moment(attendance.signin_time, "HH:mm");
                        
                        if (signInTime.isValid() && signoutTime.isValid() && signInTime.isAfter(moment('00:00', 'HH:mm')) && signoutTime.isAfter(moment('00:00', 'HH:mm'))) {
    
                            // Define boundaries for night hours
                            const nightStart = moment('22:00', 'HH:mm'); // 10 PM
                            const nightEnd = moment('06:00', 'HH:mm');   // 6 AM

                            if (signInTime.isBefore(nightEnd)) {
                                nightMinutes += nightEnd.diff(signInTime, 'minutes');
                            }
                            if (signoutTime.isAfter(nightStart)) {
                                nightMinutes += signoutTime.diff(nightStart, 'minutes');
                            }

                            totalNightMinutes += nightMinutes;

                            // Check if we are still in the same week
                            if (!date.isBetween(weekStart, weekEnd, null, '[]')) {
                                if (weeklyHours > 45 * 60) {
                                    totalWeeklyOvertimeMinutes += (weeklyHours - 45 * 60);
                                }
                                weekStart = date.startOf('isoWeek');
                                weekEnd = date.endOf('isoWeek');
                                weeklyHours = 0;
                            }

                            weeklyHours += workHours;

                            var weeklyOvertimeDisplay = weeklyHours > 45 * 60 ? formatTime(weeklyHours - 45 * 60) : '';

                            rowBackgroundColor = dayWorkMinutes === 0 ? 'style="background-color: #ffcccb;"' : '';
                            
                            // Determine daily meal based on 8 hours vs work hours
                            mealLess = workHours < 480 ? 4.09 : "";
                            mealEqualOrMore = workHours >= 480 ? 4.09 : "";

                            totalMealsLess += mealLess !== "" ? parseFloat(mealLess) : 0;
                            totalMealsEqualOrMore += mealEqualOrMore !== "" ? parseFloat(mealEqualOrMore) : 0;
                        }
                        totalWorkMinutes += workHours;
                        if (workHours > 0) {
                                totalWorkDays++; // Count the day as a working day if there are logged hours
                            }
                    }

                    var holiday_type =getHolidayType(new Date(attendance.atten_date));
                    if (isHoliday(new Date(attendance.atten_date)))
                    {
                        rowBackgroundColor = 'style="background-color: #F0FFF0;"'; 
                        holiday_type = getHolidayType(new Date(attendance.atten_date));
                    }

                    var leave = isLeave(new Date(attendance.atten_date));
                    if (leave)
                    {
                        rowBackgroundColor = 'style="background-color: #DCD0FF;"'; 
                        holiday_type = leave.leave_type;
                    }

                    if (attendance.off_day === String(dayOfWeek))
                    {
                        rowBackgroundColor = 'style="background-color: #FFF9E3;"';
                    }

                    var row = `<tr ${rowBackgroundColor}>` +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + attendance.atten_date + '</td>' +
                        '<td>' + dayShort + '</td>' +
                        '<td>' + holiday_type + '</td>' +
                        '<td>' + attendance.signin_time + '</td>' +
                        '<td>' + attendance.signout_time + '</td>' +
                        '<td>' + attendance.break + '</td>' +
                        '<td>' + attendance.Hours +'</td>' +
                        '<td>' + work_hours + '</td>' +
                        overtime +
                        '<td>' + formatTime(nightMinutes) + '</td>' +
                        '<td>' + mealLess + '</td>' +
                        '<td>' + mealEqualOrMore + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });

                var totalsRow = '<tr>' +
                    '<td colspan="7"><strong>Total</strong></td>' +
                    '<td><strong>' + formatTime(totalWorkMinutes) + '</strong></td>' +
                    '<td><strong>' + formatTime(totalMonthMinutes) + '</strong></td>' +
                    '<td><strong>' + formatTime(totalOvertimeMinutes) + '</strong></td>' +
                    '<td><strong>' + formatTime(totalNightMinutes) + '</strong></td>' +
                    '<td><strong>' + totalMealsLess.toFixed(2) + '</strong></td>' +
                    '<td><strong>' + totalMealsEqualOrMore.toFixed(2) + '</strong></td>' +
                    '</tr>';
                tableBody.append(totalsRow);

                // Update the summary card values
                var totalHours = totalWorkMinutes / 60;
                var dailyBonus = totalWorkDays*daily_bonus;
                var totalSalary = (totalHours * hourly_salary) +
                    (totalHours * bonusPerHour) +
                    (totalHours * bonusPerHour2) +
                    (totalMealsEqualOrMore + totalMealsLess) + dailyBonus;
                
                $('#totalWorkDays').text(totalWorkDays);
                $('#totalWorkingDays').text(totalWorkingDays);
                $('#totalWorkHours').text(formatTime(totalWorkMinutes));
                $('#totalWorkHours2').text(hourly_salary + ' x ' + formatTime(totalWorkMinutes));
                $('#totalWorkHours_amt').text(((totalWorkMinutes / 60) * hourly_salary).toFixed(2));
                $('#normalWorkHours').text(formatTime(totalMonthMinutes));
                $('#totalOvertime').text(formatTime(totalOvertimeMinutes));
                $('#totalNightHours').text(formatTime(totalNightMinutes));
                $('#mealsFull').text(totalMealsEqualOrMore.toFixed(2));
                $('#mealsFull2').text(totalMealsEqualOrMore.toFixed(2) + ' + ' + totalMealsLess.toFixed(2));
                $('#mealsFull_amt').text((totalMealsEqualOrMore + totalMealsLess).toFixed(2));
                $('#mealsLess').text(totalMealsLess.toFixed(2));
                $('#bonus').text(bonusPerHour + ' €/h');
                $('#bonus_1').text(bonusPerHour + ' x ' + formatTime(totalWorkMinutes));
                $('#bonus_2').text(bonusPerHour2 + ' x ' + formatTime(totalWorkMinutes));
                $('#bonusDaily_amt').text(dailyBonus);
                $('#bonus_daily').text(totalWorkDays + ' x ' + daily_bonus);
                $('#bonus_amt').text(((totalWorkMinutes / 60) * bonusPerHour).toFixed(2));
                $('#bonus2_amt').text(((totalWorkMinutes / 60) * bonusPerHour2).toFixed(2));
                $('#bonus2').text(bonusPerHour2 + ' €/h');
                $('#hourlyPay').text(hourly_salary + ' €/h');
                $('#totalSalary').text(totalSalary.toFixed(2) + ' €');

                $('#deductions').on('input', function () {
                    var deductions = parseFloat($(this).val()) || 0;
                    var finalSalary = totalSalary - deductions;
                    $('#totalSalary').text(finalSalary.toFixed(2) + ' €');
                });

            } else {
                $(".message").css('background-color', '#FF5722').fadeIn('fast').delay(10000).fadeOut('fast').html('No Data for selected month');
            }
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


function printPage() {
    var printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">'); // Include Bootstrap CSS if needed
    printWindow.document.write('<style>');
    printWindow.document.write('@media print {');
    printWindow.document.write('  @page {');
    printWindow.document.write('    margin: 10mm;'); // Ensure there is margin space for printing
    printWindow.document.write('  }');
    printWindow.document.write('  body {');
    printWindow.document.write('    font-family: Arial, sans-serif;');
    printWindow.document.write('    margin: 0;');
    printWindow.document.write('  }');
    printWindow.document.write('  .page-wrapper {');
    printWindow.document.write('    width: 100%;');
    printWindow.document.write('    page-break-inside: avoid;');
    printWindow.document.write('  }');
    printWindow.document.write('  .no-print {');
    printWindow.document.write('    display: none;'); // Hide elements with the no-print class
    printWindow.document.write('  }');
    printWindow.document.write('  table {');
    printWindow.document.write('    width: 100%;');
    printWindow.document.write('    table-layout: auto;'); // Auto size columns based on content
    printWindow.document.write('    font-size: 8px;'); // Reduce font size specifically for tables
    printWindow.document.write('    page-break-inside: auto;');
    printWindow.document.write('    border-collapse: collapse;'); // Ensure borders collapse for print
    printWindow.document.write('  }');
    printWindow.document.write('  th, td {');
    printWindow.document.write('    padding: 2px;'); // Adjust padding for better spacing
    printWindow.document.write('    word-wrap: break-word;'); // Ensure long words or content wrap to avoid overflow
    printWindow.document.write('    vertical-align: top;'); // Align text to the top of cells
    printWindow.document.write('    line-height: 0.5;');
    printWindow.document.write('    border: 1px solid black;'); // Optional: Add border for clarity
    printWindow.document.write('  }');
    printWindow.document.write('  tr {');
    printWindow.document.write('    page-break-inside: avoid;');
    printWindow.document.write('    page-break-after: auto;');
    printWindow.document.write('  }');
    printWindow.document.write('  .first-card {');
    printWindow.document.write('    page-break-after: always;'); // Ensure cards start on a new page
    printWindow.document.write('    margin-top: 20px;'); // Add space at the top of the card for better formatting
    printWindow.document.write('    padding: 10px;'); // Add padding to the card
    printWindow.document.write('    border: 1px solid black;'); // Optional: Add border for better visibility
    printWindow.document.write('  }');
    printWindow.document.write('}');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(document.querySelector('.page-wrapper').innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}


</script>

<?php $this->load->view('backend/footer'); ?>