<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Payroll</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-university" aria-hidden="true"></i> Payroll</li>
                    </ol>
                </div>
            </div>
            
            <div class="container-fluid"> 
                <div class="row m-b-10"> 
                    <div class="col-12">
<!--                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#TypeModal" data-whatever="@getbootstrap" class="text-white TypeModal"><i class="" aria-hidden="true"></i> Add Payroll </a></button>-->
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Payroll/Generate_salary" class="text-white"><i class="" aria-hidden="true"></i>  Generate Payroll</a></button>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-12">

                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Payroll List                     
                                </h4>
                            </div>
                            <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="depid" name="depid" style="margin-top: 21px;" required>
                                    <option value="#">Select Department
                                    </option>
                                    <?php foreach ($department as $value): ?>
                                    <option value="<?php echo $value->id; ?>">
                                        <?php echo $value->dep_name; ?>
                                    </option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="empid" name="empid" style="margin-top: 21px;" required>
                                    <option value="#">Select Employee
                                    </option>
                                    <?php foreach ($employee as $value): ?>
                                        <option value="<?php echo $value->em_code; ?>"><?php echo $value->first_name.' '.$value->last_name; ?></option>
                                    </option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>
                                    </label>
                                        <div class='input-group date' id='monthPicker'>
                                        <input type='text' name="datetime" class="form-control mydatetimepicker" placeholder="Month"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                        </div>
                                </div> 
                            </div>
                                <div class="table-responsive ">       
                                    <table id="attendanceTable" class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Day</th>
                                                <th>Type</th>
                                                <th>Sign In</th>
                                                <th>Sign Out</th>
                                                <th>Break</th>
                                                <th>Working Hour</th>
                                                <th>Normal Hours</th>
                                                <th>Extra time</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data will be populated here via AJAX -->
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
                    $('#empid').append('<option value="#">Select Employee</option>');
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
            $('#empid').append('<option value="#">Select Employee</option>');
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
        // var selectedMonth = $('#monthSelect').val(); // This line is commented out because 'month' is passed as a parameter
        var emid = $(empid).val();
        $.ajax({
            url: '<?php echo base_url(); ?>attendance/AttendancebyMonth', 
            type: 'GET',
            data: { month: month, employee_id:emid }, // Use 'month' parameter here instead of 'selectedMonth'
            success: function(response) {

                var data = JSON.parse(response).attendancelist;
                var tableBody = $('#attendanceTable tbody');
                tableBody.empty(); // Clear the table body

                $.each(data, function(index, attendance) {
                    var date = new Date(attendance.atten_date);
                    var dayOfWeek = moment(date).format('dddd');
                    var row = '<tr>' +
                        '<td>' + attendance.atten_date + '</td>' +
                        '<td>' + dayOfWeek + '</td>' +
                        '<td>' + 'Type' + '</td>' +
                        '<td>' + attendance.signin_time + '</td>' +
                        '<td>' + attendance.signout_time + '</td>' +
                        '<td>' + 'break' + '</td>' +
                        '<td>' + attendance.Hours + '</td>' +
                        '<td>7.6 </td>' +
                        '<td>' +  + '</td>' +
                        '<td><button class="action-btn">Action</button></td>' +
                        '</tr>';
                    tableBody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    }
});


$(document).ready(function() {    
/*var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd = '0'+dd
} 

if(mm<10) {
    mm = '0'+mm
} 

today = mm + '/' + dd + '/' + yyyy;*/
var d = new Date();
var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
var m = months[d.getMonth()];    
var y = d.getFullYear();    
//document.write(today);    
   var table = $('#example123').DataTable( {
        "aaSorting": [[9,'desc']],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                title: 'Salary List'+'<br>'+ m +' '+ y,
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '50pt' )
                        .prepend(
                            '<img src="<?php echo base_url()?>assets/images/dRi_watermark.png" style="position:absolute;background-size:300px 300px; top:35%; left:27%;" />'
                        );
                    $(win.document.body)
                        //.css( 'border', 'inherit' )
                        .prepend(
                            '<footer class="footer" style="border:inherit"><img src="<?php echo base_url();?>assets/images/signature_vice.png" style="position:absolute; top:0; left:0;" /><img src="<?php echo base_url();?>assets/images/signature_ceo.png" style="position:absolute; top:0; right:0;height:30px;" /></footer>'
                        );
                    $(win.document.body).find( 'h1' )
                        .addClass( 'header' )
                        .css( 'display', 'inharit' )
                        .css( 'position', 'relative' )
                        .css( 'float', 'right' )
                        .css( 'font-size', '24px' )
                        .css( 'font-weight', '700' )
                        .css( 'margin-right', '15px' );
                    $(win.document.body).find( 'div' )
                        .addClass( 'header-top' )
                        .css( 'background-position', 'left top' )
                        .css( 'height', '100px' )
                        .prepend(
                            '<img src="<?php echo base_url()?>assets/images/dri_Logo.png" style="position:absolute;background-size:30%; top:0; left:0;" />'
                        );
                    $(win.document.body).find( 'div img' )
                        .addClass( 'header-img' )
                        .css( 'width', '300px' );
                    $(win.document.body).find( 'h1' )
                        .addClass( 'header' )
                        .css( 'font-size', '25px' );

                    $(win.document.body).find( 'table thead' )
                        .addClass( 'compact' )
                        .css( {
                            color: '#000',
                            margin: '20px',
                            background: '#e8e8e8',

                        });
 
                    $(win.document.body).find( 'table thead th' )
                        .addClass( 'compact' )
                        .css( {
                            color: '#000',
                            border: '1px solid #000',
                            padding: '15px 12px',
                            width: '8%'
                        });
 
                    $(win.document.body).find( 'table tr td' )
                        .addClass( 'compact' )
                        .css( {
                            color: '#000',
                            margin: '20px',
                            border: '1px solid #000'

                        });
 
                    $(win.document.body).find( 'table thead th:nth-child(3)' )
                        .addClass( 'compact' )
                        .css( {
                            width: '15%',
                        });
 
                    $(win.document.body).find( 'table thead th:nth-child(1)' )
                        .addClass( 'compact' )
                        .css( {
                            width: '1%',
                        });
 
                    $(win.document.body).find( 'table thead th:nth-child(2)' )
                        .addClass( 'compact' )
                        .css( {
                            width: '5%',
                        });
 
                    $(win.document.body).find( 'table thead th:last-child' )
                        .addClass( 'compact' )
                        .css( {
                            display: 'none',

                        });
 
                    $(win.document.body).find( 'table tr td:last-child' )
                        .addClass( 'compact' )
                        .css( {
                            display: 'none',

                        });
                }
            }
        ]
    } );
  
} );
</script>
<?php $this->load->view('backend/footer'); ?>
<script>
    $('#salary123').DataTable({
        "aaSorting": [[10,'desc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });   
</script>