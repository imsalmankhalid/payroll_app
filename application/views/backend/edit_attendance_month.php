<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<?php $settingsvalue = $this->settings_model->GetSettingsValue(); ?>

<style>
    .day-row {
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .holiday-row {
        background-color: #f8d7da;
        color: #721c24;
    }

    .day-row .form-control {
        margin-bottom: 10px;
    }

    .day-row .col-form-label {
        font-weight: bold;
    }

    .day-row .col-md-2,
    .day-row .col-md-3 {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-small {
        margin-bottom: 20px;
    }
</style>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Monthly Attendance</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Monthly Attendance</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <!-- First Row: Copy Attendance Card -->
        <div class="row m-b-10"> 
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Copy Attendance</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="Cpy_Attendance_Month" id="copyForm" enctype="multipart/form-data" onsubmit="return validateForm()">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>From Employee</label>
                                        <select class="form-control custom-select" tabindex="1" name="emid" id="emid" required>
                                            <?php if (!empty($attval->em_code)) : ?>
                                                <option value="<?php echo $attval->em_code ?>"><?php echo $attval->first_name . ' ' . $attval->last_name ?></option>
                                            <?php else : ?>
                                                <option value="#">Select Here</option>
                                                <?php foreach ($employee as $value) : ?>
                                                    <option value="<?php echo $value->em_code ?>"><?php echo $value->first_name . ' ' . $value->last_name ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>To Employee</label>
                                        <select class="form-control custom-select" tabindex="1" name="emid2" id="emid2" required>
                                            <option value="#">Select Here</option>
                                            <?php foreach ($data as $all) : ?>
                                                <option value="<?php echo $all->em_code ?>"><?php echo $all->first_name . ' ' . $all->last_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Select Month: </label>
                                        <div class="input-group date">
                                            <input name="selected_month2" id="selected_month2" class="form-control" type="month" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 align-self-center">
                                    <button type="submit" id="attendanceCopy" class="btn btn-primary mt-4">Copy</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row: Edit Attendance and Attendance Data Cards -->
        <div class="row m-b-10"> 
            <div class="col-12">
                <div class="card card-outline-info card-small">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Edit Attendance</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="Upd_Attendance_Month" id="attendanceForm" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Employee</label>
                                    <select class="form-control custom-select" tabindex="1" name="eemid" id="eemid" required>
                                        <?php if (!empty($attval->em_code)) : ?>
                                            <option value="<?php echo $attval->em_code ?>"><?php echo $attval->first_name . ' ' . $attval->last_name ?></option>
                                        <?php else : ?>
                                            <option value="#">Select Here</option>
                                            <?php foreach ($employee as $value) : ?>
                                                <option value="<?php echo $value->em_code ?>"><?php echo $value->first_name . ' ' . $value->last_name ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Select Month: </label>
                                    <div class="input-group date">
                                        <input name="selected_month" id="selected_month" class="form-control" type="month" required onchange="updateDays()">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Place</label>
                                    <select class="form-control custom-select" tabindex="1" name="place" required>
                                        <option value="office" <?php if (isset($attval->place) && $attval->place == "office") { echo "selected"; } ?>>Office</option>
                                        <option value="field" <?php if (isset($attval->place) && $attval->place == "field") { echo "selected"; } ?>>Field</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="days-container">
                                <!-- Dynamic input fields for days will be appended here -->
                            </div>
                        </div>
                            <div class="modal-footer">
                                <button type="submit" id="attendanceUpdate" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    function validateForm() {
        // Get all form elements
        // const form = document.getElementById('attendanceForm');
        // const inputs = form.querySelectorAll('input, select');

        // // Flag to check if any invalid entries are found
        // let hasInvalidEntries = false;

        // // Iterate over all form elements
        // for (const input of inputs) {
        //     // Remove previous background highlight
        //     input.style.backgroundColor = '';

        //     // Check if text fields contain 'Invalid'
        //     if (input.type === 'text' && input.value.includes('Invalid')) {
        //         input.style.backgroundColor = 'lightyellow'; // Highlight invalid entry
        //         hasInvalidEntries = true;
        //     }
        // }

        // // Check if there are invalid entries
        // if (hasInvalidEntries) {
        //     alert('Please correct the invalid entries before submitting.');
        //     return false; // Prevent form submission
        // }

        return true; // Allow form submission
    }
$(document).ready(function () {
    $(".holiday").click(function (e) {
        e.preventDefault(e);
        // Get the record's ID via attribute  
        var iid = $(this).attr('data-id');
        $('#holidayform').trigger("reset");
        $('#holysmodel').modal('show');
        $.ajax({
            url: 'Holidaybyib?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).done(function (response) {
            console.log(response);
            // Populate the form fields with the data returned from server
			$('#holidayform').find('[name="id"]').val(response.holidayvalue.id).end();
            $('#holidayform').find('[name="holiname"]').val(response.holidayvalue.holiday_name).end();
            $('#holidayform').find('[name="startdate"]').val(response.holidayvalue.from_date).end();
            $('#holidayform').find('[name="enddate"]').val(response.holidayvalue.to_date).end();
            $('#holidayform').find('[name="nofdate"]').val(response.holidayvalue.number_of_days).end();
            $('#holidayform').find('[name="year"]').val(response.holidayvalue.year).end();
		});
    });
});
</script>
<script type="text/javascript">
$(document).ready(function () {
        $.ajax({
            url: '<?php echo base_url(); ?>leave/Holidays_for_calendar',
            method: 'GET',
            data: '',
            dataType: 'json',
        }).done(function (response) {
            console.log(response);
		});
});
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

// Fetch holiday calendar and store it
var holidays = [];

function updateDays() {
    var emid = $('#eemid').val();
    var month = $('#selected_month').val();
    $.ajax({
        url: '<?php echo base_url(); ?>attendance/AttendancebyMonth',
        method: 'GET',
        data: { month: month, employee_id: emid },
        dataType: 'json',
    }).done(function(response) {
        if (response.attendancelist && response.attendancelist.length > 0) {

            // Assuming response.attendancelist is an array of attendance records
            var attendancelist = response.attendancelist;
            var attendanceMap = {};

            // Create a map for easy lookup by date
            attendancelist.forEach(function(record) {
                attendanceMap[record.atten_date] = record;
            });

            console.log(attendanceMap);

            // Get the selected month value
            var selectedMonth = document.getElementById('attendanceForm').elements['selected_month'].value;

            // Create a Date object using the selected month value
            var selectedDate = new Date(selectedMonth + '-01');

            // Calculate the last day of the selected month
            selectedDate.setMonth(selectedDate.getMonth() + 1);
            selectedDate.setDate(0);

            // Get the number of days in the selected month
            var selectedMonthDays = selectedDate.getDate();

            // Get the container div for days
            var daysContainer = document.getElementById('days-container');

            // Remove existing input fields
            daysContainer.innerHTML = '';

            // Append input fields for each day in the selected month
            for (var day = 1; day <= selectedMonthDays; day++) {
                (function(day) {
                    var rowContainer = document.createElement('div');
                    rowContainer.className = 'form-group row align-items-center day-row';

                    // Calculate the full date and day name
                    var currentDate = new Date(selectedMonth + '-' + (day < 10 ? '0' + day : day));
                    var currentDateString = currentDate.toISOString().split('T')[0];
                    var dayName = currentDate.toLocaleDateString('de-DE', { weekday: 'long' });
                    var holidayLabel = isHoliday(currentDateString) ? ' (Holiday)' : '';

                    // Create a label for the date
                    var dateLabel = document.createElement('label');
                    dateLabel.className = 'col-form-label col-md-2';
                    dateLabel.innerHTML = 'Date (Day ' + day + ') ' + currentDateString + ' (' + dayName + ')' + holidayLabel;

                    // Create input fields for sign-in and sign-out times using array notation
                    var signInInput = document.createElement('div');
                    signInInput.className = 'col-sm-2';
                    signInInput.innerHTML = '<label for="attendance[' + day + '][signin]">Sign In Time</label>' +
                        '<input type="time" name="attendance[' + day + '][signin]" class="form-control" placeholder="Sign In Time">';

                    var signOutInput = document.createElement('div');
                    signOutInput.className = 'col-sm-2';
                    signOutInput.innerHTML = '<label for="attendance[' + day + '][signout]">Sign Out Time</label>' +
                        '<input type="time" name="attendance[' + day + '][signout]" class="form-control" placeholder="Sign Out Time">';

                    var breaktime = document.createElement('div');
                    var value = "<?php echo $settingsvalue->breakTime; ?>";
                    breaktime.className = 'col-sm-2';
                    breaktime.innerHTML = '<label for="attendance[' + day + '][break]">Break Time</label>' +
                        '<input type="number" name="attendance[' + day + '][break]" class="form-control" placeholder="Break Time (minutes)" value="' + value + '">';

                    var durationOutput = document.createElement('div');
                    durationOutput.className = 'col-md-2';
                    durationOutput.innerHTML = '<label>Duration</label>' +
                        '<input type="text" class="form-control" readonly>';

                    // Append label and input fields to the row container
                    rowContainer.appendChild(dateLabel);
                    rowContainer.appendChild(signInInput);
                    rowContainer.appendChild(signOutInput);
                    rowContainer.appendChild(breaktime);
                    rowContainer.appendChild(durationOutput);

                    // Append the row container to the daysContainer
                    daysContainer.appendChild(rowContainer);

                    // Get references to the input fields
                    var signInField = signInInput.querySelector('input');
                    var signOutField = signOutInput.querySelector('input');
                    var breakField = breaktime.querySelector('input');
                    var durationField = durationOutput.querySelector('input');
                    

                    // Fill the sign-in and sign-out times if they exist in the attendance data
                    if (attendanceMap[currentDateString]) {
                        signInField.value = attendanceMap[currentDateString].signin_time;
                        signOutField.value = attendanceMap[currentDateString].signout_time;
                        breakField.value = attendanceMap[currentDateString].break;
                        calculateDuration(signInField, signOutField, breakField, durationField);
                    }

                    // Add event listeners to calculate time difference
                    signInField.addEventListener('input', function() {
                        calculateDuration(signInField, signOutField, breakField, durationField);
                    });

                    breakField.addEventListener('input', function() {
                        calculateDuration(signInField, signOutField, breakField, durationField);
                    });

                    signOutField.addEventListener('input', function() {
                        calculateDuration(signInField, signOutField, breakField, durationField);
                    });

                    // Disable input fields if the date is a holiday
                    if (isHoliday(currentDateString)) {
                        signInField.disabled = true;
                        signOutField.disabled = true;
                        durationField.disabled = true;
                        breakField.disabled = true;
                        rowContainer.classList.add('holiday-row'); // Add holiday class for styling
                    }
                })(day);
            }
        } else {
            $(".message").css('background-color', '#FF5722').fadeIn('fast').delay(10000).fadeOut('fast').html('No Data for selected options');
        }
    });
}


function isHoliday(date) {
    return holidays.some(function(holiday) {
        return date >= holiday.from_date && date <= holiday.to_date;
    });
}

function calculateDuration(signInField, signOutField, breakField, durationField) {
    var signInTime = signInField.value;
    var signOutTime = signOutField.value;
    var breakTime = breakField.value;

    if (signInTime && signOutTime) {
        // Create Date objects using today's date and the input times
        var today = new Date().toISOString().split('T')[0];
        var signInDate = new Date(today + 'T' + signInTime );
        var signOutDate = new Date(today + 'T' + signOutTime );
        var breakMs = parseFloat(breakTime) * 60 * 1000; 
        var diffMs = signOutDate - signInDate - breakMs;
        console
        if (diffMs > 0) {
            var diffHrs = Math.floor(diffMs / 3600000);
            var diffMins = Math.floor((diffMs % 3600000) / 60000);
            durationField.value = diffHrs + 'h ' + diffMins + 'm';
        } else {
            durationField.value = 'Invalid';
        }
    } else {
        durationField.value = '';
    }
}


</script>

<?php $this->load->view('backend/footer'); ?>
