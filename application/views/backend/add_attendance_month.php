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
        <div class="row m-b-10"> 
            <div class="col-12">
                <button type="button" class="btn btn-info">
                    <i class="fa fa-plus"></i>
                    <a href="<?php echo base_url(); ?>attendance/Attendance" class="text-white">
                        <i class="" aria-hidden="true"></i>  Attendance List
                    </a>
                </button>
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <a href="<?php echo base_url(); ?>leave/Application" class="text-white">
                        <i class="" aria-hidden="true"></i>  Leave Application
                    </a>
                </button>
            </div>
        </div>  
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Attendance</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="Add_Attendance_Month" id="attendanceForm" enctype="multipart/form-data" onsubmit="return validateForm()">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Employee</label>

                                        <select class="form-control custom-select" data-placeholder="Choose an Employee" tabindex="1" name="emid" required>
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select Month:</label>
                                        <div class="input-group date">
                                            <input name="selected_month" class="form-control" type="month" required onchange="updateDays()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Place</label>
                                        <select class="form-control custom-select" data-placeholder="" tabindex="1" name="place" required>
                                            <option value="office" <?php if (isset($attval->place) && $attval->place == "office") { echo "selected"; } ?>>Office</option>
                                            <option value="field" <?php if (isset($attval->place) && $attval->place == "field") { echo "selected"; } ?>>Field</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="color-legend">
                                <span class="legend-item" style="background-color: #ffcccb;">Work Day (No Work Hours)</span>
                                <span class="legend-item" style="background-color: #E5E4E2;">Weekend</span>
                                <span class="legend-item" style="background-color: #F0FFF0;">Holiday</span>
                                <span class="legend-item" style="background-color: #DCD0FF;">Leave</span>
                                <span class="legend-item" style="background-color: #FFF9E3;">Off Day</span>
                            </div>
                                <div id="days-container" class="col-12">
                                    <!-- Dynamic input fields for days will be appended here -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="id" value="<?php if (!empty($attval->id)) { echo $attval->id; } ?>" class="form-control" id="recipient-name1">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" id="attendanceUpdate" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                        <div class="modal fade" id="holysmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel1">Holidays</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form method="post" action="Add_Holidays" id="holidayform" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        
                                            <div class="form-group">
                                                <label class="control-label">Holidays name</label>
                                                <input type="text" name="holiname" class="form-control" id="recipient-name1" minlength="4" maxlength="25" value="" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Holidays Start Date</label>
                                                <input type="date" name="startdate" class="form-control" id="recipient-name1"  value="">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Holidays End Date</label>
                                                <input type="date" name="enddate" class="form-control" id="recipient-name1" value="">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Number of Days</label>
                                                <input type="number" name="nofdate" class="form-control" id="recipient-name1" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="control-label"> Year</label>
                                                <textarea class="form-control" name="year" id="message-text1"></textarea>
                                            </div>                                           
                                        
                                    </div>
                                    <div class="modal-footer">
                                    <input type="hidden" name="id" value="" class="form-control" id="recipient-name1">                                       
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
<script type="text/javascript">

    function validateForm() {
        // Get all form elements
        const form = document.getElementById('attendanceForm');
        const inputs = form.querySelectorAll('input, select');

        // Flag to check if any invalid entries are found
        let hasInvalidEntries = false;

        // Iterate over all form elements
        for (const input of inputs) {
            // Remove previous background highlight
            input.style.backgroundColor = '';

            // Check if text fields contain 'Invalid'
            if (input.type === 'text' && input.value.includes('Invalid')) {
                input.style.backgroundColor = 'lightyellow'; // Highlight invalid entry
                hasInvalidEntries = true;
            }
        }

        // Check if there are invalid entries
        if (hasInvalidEntries) {
            alert('Please correct the invalid entries before submitting.');
            return false; // Prevent form submission
        }

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
    // Fetch holiday calendar and store it
    var holidays = [];
    var leaves = [];
    var off_day = -1;
    $(document).ready(function () {
        // Fetch holidays
        $.ajax({
            url: '<?php echo base_url(); ?>leave/Holidays_for_calendar',
            method: 'GET',
            data: '',
            dataType: 'json',
        }).done(function (response) {
            holidays = response;
            console.log(response);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX request failed:', textStatus, errorThrown);
        });

    });


    
    function updateDays() {
        const selectElement = document.querySelector('select[name="emid"]');
        const idValue = selectElement.value;
        var leavesRequest = $.ajax({
            url: '<?php echo base_url(); ?>leave/Leaves_for_calendar',
            method: 'GET',
            data: { id: idValue },
            dataType: 'json'
        });

        var offdayRequest = $.ajax({
            url: '<?php echo base_url(); ?>leave/get_off_day',
            method: 'GET',
            data: { id: idValue },
            dataType: 'json'
        });

        // Fetch leaves
        $.when(leavesRequest, offdayRequest).done(function(leavesResponse, offdayResp) {
            leaves = leavesResponse[0];
            off_day = parseInt(offdayResp[0]);
            loadDays();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX request failed:', textStatus, errorThrown);
        });
    }

    function loadDays() {
        var selectedMonth = document.getElementById('attendanceForm').elements['selected_month'].value;
        var selectedDate = new Date(selectedMonth + '-01');
        selectedDate.setMonth(selectedDate.getMonth() + 1);
        selectedDate.setDate(0);
        var selectedMonthDays = selectedDate.getDate();

        var daysContainer = document.getElementById('days-container');
        daysContainer.innerHTML = '';

        for (var day = 1; day <= selectedMonthDays; day++) {
            (function(day) {
                var rowContainer = document.createElement('div');
                rowContainer.className = 'form-group row align-items-center day-row';

                var currentDate = new Date(selectedMonth + '-' + (day < 10 ? '0' + day : day));
                var dayName = currentDate.toLocaleDateString('de-DE', { weekday: 'long' });
                var currentDateString = currentDate.toISOString().split('T')[0];
                var holidayLabel = isHoliday(currentDateString) ? '<br>(Holiday)' : '';
                var leaveLabel = isLeave(currentDateString) ? '<br>(On Leave)' : '';

                var dateLabel = document.createElement('label');
                dateLabel.className = 'col-form-label col-md-3';
                dateLabel.innerHTML = currentDateString + ' (' + dayName + '[' + day + '])' + holidayLabel + leaveLabel;

                var signInInput = document.createElement('div');
                signInInput.className = 'col-sm-2';
                signInInput.innerHTML = '<label for="attendance[' + day + '][signin]">Sign In Time</label>' +
                    '<input type="time" name="attendance[' + day + '][signin]" class="form-control" placeholder="Sign In Time" >';

                var signOutInput = document.createElement('div');
                signOutInput.className = 'col-sm-2';
                signOutInput.innerHTML = '<label for="attendance[' + day + '][signout]">Sign Out Time</label>' +
                    '<input type="time" name="attendance[' + day + '][signout]" class="form-control" placeholder="Sign Out Time" >';

                var breaktime = document.createElement('div');
                var value = "<?php echo $settingsvalue->breakTime; ?>";
                breaktime.className = 'col-sm-2';
                breaktime.innerHTML = '<label for="attendance[' + day + '][break]">Break Time</label>' +
                    '<input type="number" name="attendance[' + day + '][break]" class="form-control" placeholder="Break Time (minutes)" value="'+value+'" >';

                var durationOutput = document.createElement('div');
                durationOutput.className = 'col-md-2';
                durationOutput.innerHTML = '<label>Duration</label>' +
                    '<input type="text" class="form-control" readonly>';

                rowContainer.appendChild(dateLabel);
                rowContainer.appendChild(signInInput);
                rowContainer.appendChild(signOutInput);
                rowContainer.appendChild(breaktime);
                rowContainer.appendChild(durationOutput);

                daysContainer.appendChild(rowContainer);

                var signInField = signInInput.querySelector('input');
                var signOutField = signOutInput.querySelector('input');
                var breakField = breaktime.querySelector('input');
                var durationField = durationOutput.querySelector('input');

                signInField.addEventListener('input', function() {
                    calculateDuration(signInField, signOutField, breakField, durationField);
                });

                breakField.addEventListener('input', function() {
                    calculateDuration(signInField, signOutField, breakField, durationField);
                });

                signOutField.addEventListener('input', function() {
                    calculateDuration(signInField, signOutField, breakField, durationField);
                });

                // Check if the date is a holiday or leave, and disable fields or set background
                if (isHoliday(currentDateString)) {
                    // signInField.disabled = true;
                    // signOutField.disabled = true;
                    // durationField.disabled = true;
                    // breakField.disabled = true;
                    rowContainer.style.backgroundColor = '#F0FFF0';
                }

                if (isLeave(currentDateString)) {
                    // signInField.disabled = true;
                    // signOutField.disabled = true;
                    // durationField.disabled = true;
                    // breakField.disabled = true;
                    rowContainer.style.backgroundColor = '#DCD0FF'; // Set background to yellow for leave
                }
                if ((currentDate.getDay() === 0 || currentDate.getDay() === 6)) {
                    // signInField.disabled = true;
                    // signOutField.disabled = true;
                    // durationField.disabled = true;
                    // breakField.disabled = true;
                    rowContainer.style.backgroundColor = '#E5E4E2';
                }
                if (currentDate.getDay() === off_day) {
                    // signInField.disabled = true;
                    // signOutField.disabled = true;
                    // durationField.disabled = true;
                    // breakField.disabled = true;
                    rowContainer.style.backgroundColor = '#FFF9E3';
                    dateLabel.innerHTML += "<br>(Off Day)"
                }
            })(day);
        }
    }

    // Function to check if the date is a holiday
    function isHoliday(date) {
        return holidays.some(function(holiday) {
            return date >= holiday.from_date && date <= holiday.to_date;
        });
    }

    // Function to check if the date is a leave
    function isLeave(date) {
        return leaves.some(function(leave) {
            return date >= leave.from_date && date <= leave.to_date;
        });
    }

    function calculateDuration(signInField, signOutField, breakField, durationField) {
        var signInTime = signInField.value;
        var signOutTime = signOutField.value;
        var breakTime = breakField.value;

        if (signInTime && signOutTime) {
            var today = new Date().toISOString().split('T')[0];
            var signInDate = new Date(today + 'T' + signInTime + ':00');
            var signOutDate = new Date(today + 'T' + signOutTime + ':00');
            var breakMs = parseFloat(breakTime) * 60 * 1000; 
            var diffMs = signOutDate - signInDate - breakMs;
            if (diffMs >= 0) {
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